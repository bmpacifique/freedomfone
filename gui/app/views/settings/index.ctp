<?php 
/****************************************************************************
 * env.ctp	- Set environment settings
 * version 	- 1.0.362
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

$msgAccessLevel =  __('This setting determines the access level of the streaming audio content of your Freedom Fone installation.',true);



echo "<h1>".__("System settings",true)."</h1>";
echo $form->create('Setting',array('type' => 'post','action'=> 'index'));


 	if ($messages = $session->read('Message.multiFlash')) {
            foreach($messages as $k=>$v) $session->flash('multiFlash.'.$k);
   	   }


	foreach ($data as $key => $unit){

	  $entry = $unit['Setting'];

	  if ($entry['name']=='language'){

	    $lang_selected = $entry['value_string'];
	    $languages = Configure::read('LANGUAGES');

	    $rows[] = array('Language', $form->input($entry['id'].'.value',array('options'=>$languages,'label'=>false,'selected'=>$lang_selected)));

	     echo $form->hidden($entry['id'].'.field',array('value'=>'value_string'));
	     

	  } 

	  elseif ($entry['name']=='timezone'){
	  
	  $timezones = DateTimeZone::listIdentifiers();
	  
	    foreach ($timezones as $timezone){
	       if (preg_match( '/^(Africa|America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $timezone)){ $zones[$timezone] = $timezone;}
	    }


	     $rows[] = array("Time zone",$form->input($entry['id'].'.value',array('options'=>$zones,'label'=>false,'selected'=>$entry['value_string'])));
	     echo $form->hidden($entry['id'].'.field',array('value'=>'value_string'));
	    

	  } 

	  /*   elseif ($entry['name']=='domain'){
	
	     $rows[] = array("Domain",$form->input($entry['id'].'.value',array('type'=>'text','label'=>false,'value'=>$entry['value_string'],'size'=>30)));
	     echo $form->hidden($entry['id'].'.field',array('value'=>'value_string'));	

	  }  */ 

	   elseif ($entry['name']=='ip_address'){





	   $options1 = array($external => ' '.__('Public access',true));	
	   $options2 = array($internal => ' '.__('Local access',true));	
	   $options3 = array('127.0.0.1'=>' '.__('Private access',true));	

	   $default_ext = $default_int = $default_local = false;
	   $current_IP = $entry['value_string'];

	   if($entry['value_string'] == $external) { $default_ext = true; $value = false;}
	   elseif($entry['value_string'] == $internal) { $default_int = true; $value = false;}
	   elseif($entry['value_string'] == '127.0.0.1') { $default_local = true; $value = false;}
   


	    if ($external){ $radio[] = array($form->radio('ip_radio',$options1,array('legend'=>false,'value'=>$default_ext)),__('No restriction',true).' ('.__('accessible from ',true).$external.')');}
	    if ($internal){ $radio[] = array($form->radio('ip_radio',$options2,array('legend'=>false,'value'=>$default_int)),__('Access from Local Area Nework only',true).' ('.__('accessible from ',true).$internal.')');}
	    $radio[] = array($form->radio('ip_radio',$options3,array('legend'=>false,'value'=>$default_local)),__('Access from local machine only',true).' ('.__('accessible from 127.0.0.1',true).')');
	    //$radio[] = array("Other:",$form->input($entry['id'].'.value',array('type'=>'text','label'=>false,'value'=>false,'size'=>30)));
	    echo $form->hidden($entry['id'].'.field',array('value'=>'value_string'));



	  } /*  elseif ($entry['name']=='overwrite_event'){
	      $checked = false;
	      if($entry['value_int']){ $checked = 'checked';}
	     $rows[] = array("Overwrite event",$form->input($entry['id'].'.value',array('type'=>'checkbox','label'=>false,'checked'=>$checked)));
	     echo $form->hidden($entry['id'].'.field',array('value'=>'value_int'));
	  }   */

	}


     
	//Display language and timezone table
	echo "<h2>".__("Environment settings",true)."</h2>";
	echo "<table>";
	echo $html->tableCells($rows);
	echo "</table>";


	//Display IP address table
	echo "<h2>".__("Access level",true)."</h2>";
        echo $html->div('instruction', $msgAccessLevel);
	$session->flash();
	echo "<table ";
	echo $html->tableCells($radio);
        echo "</table>";



	//Display Submit button
	$submit = array($form->end(__('Save',true),array('colspan'=>2,'align'=>'center')));
	echo "<table>";
	echo $html->tableCells($submit);
	echo "</table>";



?>
