<?php
/****************************************************************************
 * add.ctp	- Create new tag (used in Leave-a-message)
 * version 	- 3.0.1500
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

      echo $this->Html->addCrumb(__('Message Centre',true), '');
      echo $this->Html->addCrumb(__('Tags',true), '/tags');
      echo $this->Html->addCrumb(__('Add',true), '/tags/add');

      echo "<h1>".__("Create tag",true)."</h1>";


      $this->Session->flash();
      $options	  = array('label' => false);


      echo $this->Form->create('Tag',array('type' => 'post','action'=> 'add'));
      echo "<table cellspacing=0 class='stand-alone'>";

      echo $this->Html->tableCells(array (
           array(__("Tag",true),           $this->Form->input('name',$options)),
           array(__("Description",true),   $this->Form->input('longname',$options)),
           array('',			     $this->Form->end(__('Save',true)))), array('class' => 'stand-alone'),array('class' => 'stand-alone'));

     echo "</table>";

?>