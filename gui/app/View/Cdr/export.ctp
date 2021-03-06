<?php
/****************************************************************************
 * export.ctp	- Display form for export of CDR.
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

echo $this->html->addCrumb(__('System data',true), '');
echo $this->html->addCrumb(__('Call data records',true), '/cdr');
echo $this->html->addCrumb(__('Export',true), '/cdr/export');


echo "<h1>".__("Export CDR",true)."</h1>";
echo $this->Form->create('Cdr',array('type' => 'post','action'=> 'output'));

echo "<table cellspacing = 0 class= 'stand-alone'>";
echo $this->html->tableCells(array (
     array(__("Start time",true),	$this->Form->input('start_time',array('label'=>false,'type' => 'datetime', 'interval' => 15,'selected' => $start))),
     array(__("End time",true),		$this->Form->input('end_time',array('label'=>false,'type' => 'datetime','interval' => 15,'selected' => $end)))
      ),array('class' => 'stand-alone'),array('class' => 'stand-alone'));
echo "</table>";

echo $this->Form->end(array('name' => __('Export',true), 'label' =>__('Export',true),'class' =>'button'));


?>


