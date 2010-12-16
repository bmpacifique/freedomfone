<?php
/****************************************************************************
 * edit.ctp	- Edit existing poll
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

echo $javascript->link('addRemoveElements');


	   echo "<h1>".__("Edit Poll",true)."</h1>";

	   $session->flash();
	   echo $form->create('Poll',array('type' => 'post','action'=> 'edit'));
	   echo $form->input('id',array('type' => 'hidden','value'=> $this->data['Poll']['id']));
   	   echo $form->input('invalid_open',array('type' => 'hidden','value'=> $this->data['Poll']['invalid_open']));
   	   echo $form->input('invalid_early',array('type' => 'hidden','value'=> $this->data['Poll']['invalid_early']));
	   echo $form->input('invalid_closed',array('type' => 'hidden','value'=> $this->data['Poll']['invalid_closed']));

	   echo "<table cellspacing='0'>";
	   echo $html->tableCells(array (
     	   	array(__("Question",true),	$form->input('question',array('label'=>false,'size' => 70))),
     		array(array(__("Define a concrete question using simple language",true),"colspan='2' class='formComment'")),
     		array(__("SMS Code",true),	$form->input('code',array('label'=>false))),
    		array(array(__("Alpha-numeric characters only (maximum 10)",true),"colspan='2' class='formComment'")),
     		),array('class' => 'stand-alone'),array('class' => 'stand-alone'));
	  echo "</table>";

	  echo "<h2>".__("Poll options",true)."</h2>";
	  echo "<div class='formComment'>".__("Alpha-numeric characters only (maximum 10)",true)."</div>";

	  echo "<table cellspacing ='0'>";
	  $rows=array();

		foreach ($this->data['Vote'] as $key =>$vote) {

		if(isset($vote['id'])){ $voteId=$vote['id'];} else { $voteId=false;}
			$hidden = $form->input('Vote.'.$key.'.id',array('value' => $voteId,'label'=>false));	    		
			if ($voteId){ 
			   $delete   = $html->link($html->image("icons/delete.png", array("title" => __("Delete",true))),"/polls/unlink/{$voteId}/{$this->data['Poll']['id']}",null , __("Are you sure you want to delete this poll option?",true),false);
			   } else { 
			   $delete=false;
			   }
			$rows[] = array(__("Option",true), $form->input('Vote.'.$key.'.chtext',array('value' => $vote['chtext'],'label'=>false)),$delete,$hidden);	    		

    			}


	echo $html->tableCells($rows,array('class' => 'stand-alone'),array('class' => 'stand-alone'));
        echo "</table>";	

	?>
	<div id="doc">
	<div id="content"></div>
	<input id='add-element' type="button" value="<? echo __("Add",true);?>"/>
	</div>
	<?



	echo "<h2>".__("Start and end time",true)."</h2>";
	echo "<div class='formComment'>".__("When would you like to open and close the poll?",true)."</div>";

	echo "<table cellspacing ='0'>";
	echo $html->tableCells(array (
     	     array(__("Start time",true),	$form->input('start_time',array('label'=>false))),
     	     array(__("End time",true),		$form->input('end_time',array('label'=>false)))
      	     ),array('class' => 'stand-alone'),array('class' => 'stand-alone'));
	echo "</table>";
	echo $form->end(__('Save',true)); 


?>

