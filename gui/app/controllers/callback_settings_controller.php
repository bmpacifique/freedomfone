<?php
/****************************************************************************
 * callback_settings_controller.php		- Controller for callback settings.
 * version 		 			- 1.0.368
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

class CallbackSettingsController extends AppController{

	var $name = 'CallbackSettings';
	var $helpers = array('Flash','Session');      



	function index(){

      	$this->pageTitle = 'Callback : Settings';           

		 $iid=IID;

		if (empty($this->data)) {
		       $this->data = $this->CallbackSetting->find('first', array('conditions' => array('instance_id' => $iid)));
		}

		if (!empty($this->data)) {

		   $this->data['CallbackSetting']['instance_id'] = $iid;
		   $this->CallbackSetting->save($this->data);
		}
	}

}
?>
