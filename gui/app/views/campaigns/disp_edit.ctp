<?php
/****************************************************************************
 * disp_edit.ctp	- Display callback requests by Campaign name
 * version 	        - 2.5.1200
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


   echo $ajax->div("service_div");
   $status = false;

   $options = array(1 => __('Start',true), 2 => __('Pause',true),3 => __('Abort',true));
   echo $form->create('Campaign', array('type' => 'post', 'action' => 'edit','enctype' => 'multipart/form-data') );  

  if ($campaign){

   echo $form->input('id',array('type'=>'hidden','value'=>$campaign['Campaign']['id']));

        foreach($campaign['Callback'] as $key => $callback){
              $status[] = $callback['status'];
        }
debug($status);
        $total   = sizeof($status);
        $pending = $number->toPercentage(100*sizeof(array_keys($status,1))/$total,0);
        $failure = $number->toPercentage(100*sizeof(array_keys($status,2))/$total,0);
        $retry   = $number->toPercentage(100*sizeof(array_keys($status,3))/$total,0);
        $success = $number->toPercentage(100*sizeof(array_keys($status,4))/$total,0);
        $abort   = $number->toPercentage(100*sizeof(array_keys($status,5))/$total,0);
        $pause   = $number->toPercentage(100*sizeof(array_keys($status,6))/$total,0);
        $process = $number->toPercentage(100*sizeof(array_keys($status,7))/$total,0);

        $campaign_status = $form->input('status',array('options' => $options, 'label' => false, 'selected' => $campaign['Campaign']['status']));
        $submit       = $form->end(__('Submit',true));
 
           echo "<table width='35%' cellspacing  = '0' class = 'stand-alone'>";
           $row[] = array(__('Name',true), $campaign['Campaign']['name']);
           $row[] = array(__('Start Time',true), $campaign['Campaign']['start_time']);
           $row[] = array(__('End Time',true), $campaign['Campaign']['end_time']);
           $row[] = array(__('Pending',true), $pending);
           $row[] = array(__('Failure',true), $failure);
           $row[] = array(__('Retry',true), $retry);
           $row[] = array(__('Success',true), $success);
           $row[] = array(__('Abort',true), $abort);
           $row[] = array(__('Pause',true), $pause);
           $row[] = array(__('Processing',true), $process);
           $row[] = array(__('Status',true), $campaign_status);
           echo $html->tableCells($row,array('class'=>'stand-alone'),array('class'=>'stand-alone'));
           echo "</table>";

           echo $submit;
                   

        }

     echo $ajax->divEnd("service_div");

?>