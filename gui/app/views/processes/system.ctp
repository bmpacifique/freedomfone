<?php
/****************************************************************************
 * system.ctp	- List system data (software versions, system environment)
 * version 	- 2.0.1170
 * 
 * Version: MPL 1.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 *
 * The Initial Developer of the Original Code is
 *   Louise Berthilson <louise@it46.se>
 *
 *
 ***************************************************************************/


echo $html->addCrumb('Dashboard', '');
echo $html->addCrumb('About', '/processes/system');


 $os = php_uname('s');

 $cmd1 = exec('/usr/bin/lsb_release -d');
 $cmd2 = exec('/usr/bin/lsb_release -a');
 $release = $lsb = false;

 if($cmd1){ 
 	    $release = explode(':',$cmd1); 
 }

 if($cmd2){ 
 	    $lsb = explode(':',$cmd2); 
  }

 $string = $os.', '.$release[1].', '.$lsb[1];


   foreach($settings as $key => $entry){

     switch ($entry['settings']['name']){

     	    case 'language':
	    $language = $entry['settings']['value_string'];
	    break;

     	    case 'timezone':
	    $timezone = $entry['settings']['value_string'];
	    break;

     	    case 'ip_address':
	    $ip_address = $entry['settings']['value_string'];
	    break;
 
     }
   }

     $lang = Configure::read('LANGUAGES.'.$language);


     echo "<h1>".__("About",true)."</h1>";


     echo "<h2>".__("Freedom Fone",true)."</h2>";
     $row0[] = array(__('Version',true),__('Freedom Fone',true)." ".VERSION." (<a href='http://en.wikipedia.org/wiki/African_Wild_Dog'>".VERSION_NAME."</a>)");
     $row0[] = array(__('SVN revision',true),$svn);
     echo "<table width='70%' cellspacing = 0 class='stand-alone'>";
     echo $html->tableCells($row0,array('class' =>'stand-alone'),array('class' =>'stand-alone'));
     echo "</table>"; 



     echo "<h2>".__("Software",true)."</h2>";
     $row1[] = array(__("Operating system",true).": ", $string); 
     $row1[] = array(__("FreeSWITCH",true).": ", $version[1]); 
     $row1[] = array(__("Web server",true).": ", apache_get_version());
     $row1[] = array(__("MySQL",true).": ", mysql_get_server_info());
     $row1[] = array(__("Dispatcher",true).": ", $version[0]);
    echo "<table width='70%' cellspacing = 0 class='stand-alone'>";
    echo $html->tableCells($row1,array('class' =>'stand-alone'),array('class' =>'stand-alone'));
    echo "</table>"; 


     echo "<h2>".__("Environment",true)."</h2>";
      $row2[] = array(__("IP address",true).": ", $ip_address); 
      $row2[] = array(__("Language",true).": ", $lang); 
      $row2[] = array(__("System time",true).": ", date('Y-m-d H:i A').' ('.$timezone.')'); 

    echo "<table width='70%' cellspacing = 0 class='stand-alone'>";
    echo $html->tableCells($row2,array('class' =>'stand-alone'),array('class' =>'stand-alone'));
    echo "</table>"; 



    if ($items){
      echo "<h2>".__("Latest news",true)."</h2>";
      foreach($items as $key => $item) {
	  if($key<5){	  echo $html->div('news',$html->link($item->get_title(), $item->get_permalink()));
	    //echo $text->truncate($item->get_description());  
	  }
      }
    }	  



?>