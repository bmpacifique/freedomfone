<?php 
/****************************************************************************
 * edit.ctp	- Edit existing phone books (used in Contacts)
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

echo $this->Html->addCrumb(__('Caller Management',true), '');
echo $this->Html->addCrumb(__('Phone books',true), '/phone_books');
echo $this->Html->addCrumb(__('Edit',true), '/phone_books/edit/'.$this->data['PhoneBook']['id']);


      if($this->data){


      echo "<h1>".__("Edit Phone book",true)."</h1>";
      $this->Session->flash();

      $options_name = array('label' =>  array('text'=>false), 'type'=>'text','size'=>'20');
      $options_longname = array('label' =>  array('text'=>false), 'type'=>'text','size'=>'50');


      echo $this->Form->create('PhoneBook',array('type' => 'post','action'=> 'edit'));
      echo $this->Form->hidden('id');


      
     echo "<table width='600px' cellspacing='0' >";
     echo $this->Html->tableCells(array (
     	  array(array(__("Name",true),array('width' =>'150px')),	        $this->Form->input('name',$options_name)),
     	  array(__("Description",true),                                         $this->Form->input('description',$options_longname)),
     	  array(array(__("Add caller to phone book",true),array('valign' => 'top')),		                        $this->Form->input('Caller',array('type'=>'select','multiple'=>'true','size' => 20, 'options' => $callers,'label'=>false,'empty'=>"-- ".__('Use in none',true)." --"))),
     	  array('',	$this->Form->end(__('Save',true)))), array('class' => 'stand-alone'),array('class' => 'stand-alone'));

    echo "</table>";

    }
    else {
    
    echo "<h1>".__("No phone book with this id exists",true)."</h1>";

    }



?>