<?php
/**
 * Class for FreeSWITCH event socket
 *
 */
class fs_sock {
    /**
     * file handler for FreeSWITCH socket connection
     *
     * @var file pointer
     */
    public $sock;

    public $handle;
    public $connected;
    /**
     * Sets Whether auth was successful or not
     * Used to not send further commands until auth is successful
     *
     * @var boolean
     */
    public $auth;
    private $type ='none';
    /**
     * Variable to hold current command
     *
     * @var string
     */
    private $command = 'initial_read';

    private $input_buffer;
    private $output_buffer;
 

    /**
     * Class instantiation
     * This method will connect to the socket and authenticate
     *
     * @param array $vars
     * @return fs_sock
     */
    function fs_sock($vars=null,$logfile) {

    	$this->handle = fopen($logfile,'a');
        if (!defined('BUFFER_SIZE')) {
            /**
             * This is the buffer size for fread/fgets operations (default 4096)
             * Define BUFFER_SIZE before instantiation to use a different size
             */
            define('BUFFER_SIZE', 4096);
        }
        $vars_array = is_array($vars) ? $vars : array();
        $initial_vars = $this -> set_initial_vars($vars_array);
        //$this -> debug($initial_vars);
        

	if($this -> sock_connect($initial_vars)){
           $initial_output = $this -> sock_get();
            if ($initial_output['Content-Type'] == 'auth/request') {
               $this -> debug('---- authentication requested ----');
               $this -> sock_auth($initial_vars['pass']);
            }
	    $this->connected=true;
	 }

	 else {

	 $this->connected=false;
//	 $this->connected=true;
	  } 
  }

    /**
     * Close the connection to the event socket
     *
     */
    function sock_close() {
        $this -> send_command('exit');
        fclose($this -> sock);
    }

    /**
     * Sets connection info from array passed, or used a set of defaults if nothing is passed
     *
     * @param array $var_array array of connection settings to use (host|port|pass|timeout)
     * @return array
     */
    function set_initial_vars($var_array) {
        $defaults = array(
        'host' => '127.0.0.1',
        'port' => '8021',
        'pass' => 'ClueCon',
        'timeout' => 30,
        'stream_timeout' => 5
        );
        if (array_key_exists('host', $var_array)
        && $var_array['host'] == 'localhost') {
            //$this -> debug('Replacing localhost with 127.0.0.1');
            $var_array['host'] = '127.0.0.1';
        }
        foreach ($defaults as $key => $val) {
            if (array_key_exists($key, $var_array)) {
                //$this -> debug("$key found in vars");
                $connection_settings[$key] = $var_array[$key];
            } else {
                //$this -> debug("$key not found in vars");
                $connection_settings[$key] = $val;
            }
        }
       // $this -> debug($connection_settings);
        return $connection_settings;
    }

    /**
     * Connect to the event socket using the array determined by set_initial_vars
     *
     * @param array $sock_array array of connection parameters
     * @return boolean
     */
    function sock_connect($sock_array) {
        //$this -> debug($sock_array);
        $host = $sock_array['host'];
        $port = $sock_array['port'];
        $timeout = $sock_array['timeout'];
        $this -> sock = fsockopen($host, $port, $errno, $errstr, $timeout);
     
     if (!$this -> sock) {
            //$error = sprintf('Unable to connect to %s:%s Error #%s: %s', $host, $port, $errno, $errstr );
	    $this->log("Unable to connect to FreeSWITCH","ERROR");
           // trigger_error($error, E_USER_ERROR);
            return false;
        } else {
            //$this -> debug(stream_get_meta_data($this -> sock));
            $this -> set_stream_opts($sock_array);
            return true;        }
    }

    /**
     * Set the stream timeout to not block for long periods of time
     *
     * @param array $opts initial options passed to class instantiation
     * @return void
     */
    function set_stream_opts($opts) {
        //$this -> debug($opts);
        if (ereg('^[0-9]*\.[0-9]+$', $opts['stream_timeout'])) {
            //$this -> debug($opts['stream_timeout'] . ' seems to be a float');
            $time_opts = split('\.', $opts['stream_timeout']);
            //$this -> debug($time_opts);
            $secs = sprintf('%d', $time_opts[0]);
            $ms = ($time_opts[1] * 100000);
        } else {
            $secs = $opts['stream_timeout'];
            $ms = 0;
        }
        if (!stream_set_timeout($this -> sock, $secs, $ms)) {
            $this -> debug(
            "Failed to set timeout to $secs seconds and $ms microseconds"
            );
        }
    }

    /**
     * Authenticate to the FreeSWITCH event socket
     *
     * @param string $pass FreeSWITCH event socket password
     * @return void
     */
    function sock_auth($pass) {
        $reply = $this -> send_command("auth $pass");
        if (is_array($reply) && array_key_exists('Reply-Text', $reply)
        && ereg('^\+?OK', $reply['Reply-Text'])) {
            $this -> debug('Successfully authenticated');
            //$this -> debug($reply);
            $this -> auth = true;
        } else {
            $this -> debug('Failed to authenticate');
            $this -> debug($reply);
            $this -> auth = false;
        }
    }

    /**
     * write raw data to the FreeSWITCH socket
     *
     * @param string $input command to write to the socket
     */
    private function sock_put($input, $sock=null) {
        $sock = is_null($sock) ? $this -> sock : $sock;
        fputs($this -> sock, $input);
    }

    /**
     * Read an event from the FreeSWITCH event socket
     *
     * @return array multi-dimentional array of the event
     */
    private function sock_get($sock=null) {
        $event=array(); 
	$sock = is_null($sock) ? $this -> sock : $sock;
        $this -> debug_read('.');
        while ($orig_line = fgets($this -> sock, BUFFER_SIZE)) {
            $trim_line = trim($orig_line);
            //$this -> debug("LINE: ".$trim_line);
            if (strlen($trim_line) > 0) {
                if (strstr($trim_line, ":")) {
                    $split = split(":", $trim_line);
                    $header = trim($split[0]);
                    $value = trim($split[1]);
                    $event[$header] = $value;
                }
            } elseif (is_array($event)
            && array_key_exists('Content-Length', $event)) {
	        $this -> type =$event['Content-Type'];
                //$this -> debug("line is empty: " . (empty($trim_line) ? 'true' : 'false'));
                $event['Body'] = $this -> sock_get_length($event['Content-Length']);
                break;
            } else {
                break;
            }
        }
       // $this -> debug('----   Event Finish ----');
       // $this -> debug($event);
        return $event;
    }





    private function sock_get_body($content_len) {
        $len = 0;
        $content = null;

        while ($orig_line = fgets($this -> sock, BUFFER_SIZE)) {

            $len += strlen($orig_line);
            $trim_line = trim($orig_line);

            $content .= $trim_line;
	    //$this->debug("***".$content);
	    
            if ($len >= $content_len) {
                break;
            }

        }
    
        return $content;
    }






    /**
     * Read $content_len bytes from the socket
     *
     * @param integer $content_len
     * @return array
     */
    private function sock_get_length($content_len) {

        $len = 0;
        $content = null;



        //for ($i=0; $i<$content_len; $i+=strlen($orig_line)) {
        while ($orig_line = fgets($this -> sock, BUFFER_SIZE)) {
            $len += strlen($orig_line);
             $trim_line = trim($orig_line);
             //$this -> debug("$trim_line - $len");

            if (strstr($orig_line, ":") && $this->type != 'api/response') {
     	
                $split = split(":", $orig_line);
                $attribute = trim($split[0]);
                $value = trim($split[1]);
                $content[$attribute] = urldecode($value);
            } elseif (empty($trim_line) && is_array($content) && array_key_exists('Content-Length', $content)) {
	
                $content['Body'] = $this -> sock_get_body($content['Content-Length']);
                $len += $content['Content-Length'];
                break;
            } elseif (!empty($trim_line)) {
                $content .= $trim_line;
	

            }
            if ($len >= $content_len) {
                break;
            }
        }

	//$this->debug("****OUTPUT****. ".$content);
        return $content;
    }

    /**
     * Send a command to the FreeSWITCH event socket
     * This method sends a command string to the FreeSWITCH event socket and
     * returns true upon success and false upon failure
     * @param string $cmd command string to send to socket excluding any \r or \n
     * @return boolean
     */
    public function send_command($cmd, $sock=null) {
        $sock = is_null($sock) ? $this -> sock : $sock;
        //$this -> debug('command is ' . $cmd);
        $cmd_split = split(' ', $cmd);
        //$this -> debug($cmd_split);
        $this -> command = $cmd_split[0];
        if ($this -> auth != true && $this -> command != 'auth') {
            unset($this -> command);
            return false;
        }
        //$this -> debug("sending command: '$cmd'");
        $this -> sock_put("$cmd\r\n\r\n", $sock);
        if ($this -> command != 'exit') {
	    //$this->debug("sock_get()");
            $reply = $this -> sock_get($sock);
            //$this -> debug($reply);
        } else {
            unset($this -> command);
            return;
        }
        if (is_array($reply)) {
    	//$this->debug("reply from sock_get is array");
            unset($this -> command);
            return $reply;
        } else {
            unset($this -> command);
            $this -> debug("Didn't get an array as a reply");
            return false;
        }
    }

    /**
     * Execute an api command
     *
     * @param string $cmd_str
     * @return array of the response or false
     */
    function api_command($cmd_str, $sock=null) {

        $sock = is_null($sock) ? $this -> sock : $sock;
        $reply = $this -> send_command("api $cmd_str", $sock);


        while ($reply['Content-Type'] != 'api/response') {
            if (count($reply) > 0) {
                $debug_text = sprintf(
                "%s - (%s) != (api/response) adding an event to the output buffer"
                , count($reply), $reply['Content-Type']
                );
                $this -> debug($debug_text);
                $this -> output_buffer[] = $reply;
            }
            $reply = $this -> sock_get();
        }
	    
            return $reply;
    }

    /**
     * Execute a backgrounded api command
     *
     * @param string $cmd_str
     * @return array of the response or false
     */
    function bgapi_command($cmd_str) {
        $reply = $this -> send_command("bgapi $cmd_str");
        while ($reply['Content-Type'] != 'command/reply') {
            if (count($reply) > 0) {
                $debug_text = sprintf(
                "%s - (%s) != (command/reply) adding an event to the output buffer"
                , count($reply), $reply['Content-Type']
                );
                $this -> debug($debug_text);
                $this -> output_buffer[] = $reply;
            }
            $reply = $this -> sock_get();
        }
        if (array_key_exists('Reply-Text', $reply)) {
            $split = split(':', $reply['Reply-Text']);
            $uuid = trim($split[1]);
            $reply['Job-UUID'] = $uuid;
        }
        return $reply;
    }

    /**
     * Pop an event off of the buffer or try to get one from the socket
     *
     * @return array
     */
    function read_event() {
        if (count($this -> output_buffer) > 0) {
	   
            return array_shift($this -> output_buffer);
        } else {
            $reply = $this -> sock_get();
	    
            return $reply;
        }
    }

    /**
     * Keep trying read_event until we actually get one
     *
     * @return array
     */
    function wait_for_event($alive) {
    	
        $event = array();

	 
        while (count($event) < 1 && time()-$alive < 25) {


            $event = $this -> read_event();
	    
        }

	if(isset($event)){

        return $event;
	}

	else {
	return false;
	}

    }


   function log($msg,$type){

   	    $string = date('c')." ".$type." ". $msg."\n";
	    fwrite($this->handle, $string);

   }


    /**
     * Subscribe to event notifications
     *
     * @param mixed $events comma-separated or array of events
     * @return boolean
     */
    function subscribe_events($events) {
        if (is_array($events)) {
            if (count($events) > 1) {
                $events_str = implode(',', $events);
            } else {
                $events_str = $events[0];
            }
        } else {
            $events_str = $events;
        }
        $reply = $this -> send_command("events plain $events_str");
        //$this -> debug($events_str);
	//$this -> debug("this is the reply".$reply);
        if (ereg('^\+?OK', $reply['Reply-Text'])) {
            return true;
        } else {
            return false;
        }
    }

    function debug_read($input){
    	     if (defined('FS_SOCK_DEBUG') && FS_SOCK_DEBUG == true) {
       	     	printf("%s", $input);
		}
    }

    function debug_newLine($input){
    	    if (defined('FS_SOCK_DEBUG') && FS_SOCK_DEBUG == true) {
       	       printf("\r\n%s\r\n", $input);
	       }
    }

    /**
     * Function to print out debugging info
     * This method will recieve arbitrary data and print it to the screen
     * enable/disable by defining FS_SOCK_DEBUG to true/false
     * @param mixed $input what to debug, arrays and strings tested, objects MAY work
     * @param integer $spaces
     */
    function debug($input, $spaces=0) {
	$spaces=0;
    	    if (defined('FS_SOCK_DEBUG') && FS_SOCK_DEBUG == true) {
            if (is_array($input)) {
                foreach ($input as $key=>$val) {
                    if (is_array($val) || is_object($val)) {
                        $this -> debug("[$key] => $val", $spaces+4);
                        $this -> debug('(', $spaces + 8);
                        $this -> debug($val, $spaces + 8);
                    } else {
                        $this -> debug("[$key] => '$val'", $spaces + 4);
                    }
                }
                $this -> debug(")", $spaces);
            } else {
                if (is_array($_SERVER)
                && array_key_exists('HTTP_HOST', $_SERVER)) {
                    printf("<!--%s%s-->\r\n"
                    , str_repeat(' ', $spaces)
                    , htmlentities($input)
                    );
                } else {
                    $input = trim($input);
                    printf("%s%s\r\n", str_repeat(' ', $spaces), $input);
                }
            }
        }
    }
}


?>
