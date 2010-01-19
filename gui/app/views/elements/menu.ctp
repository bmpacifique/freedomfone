<?php
/****************************************************************************
 * menu.ctp	- Main horizontal menu
 * version 	- 1.0.354
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
?>

<div>
<ul id='menu'>

<li class='logo'>
<?php echo $html->image('menu/menu_left.png',array('style'=>'float:left')); ?>
</li>

<li>
<?php echo $html->link(__("Home",true),'/'); ?>
</li>


<li><?php echo __("Freedom Fone",true);?>
<ul>

<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("About",true),'/about'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>

<li>
<?php echo $html->link(__("Architecture",true),'/architecture'); ?>
</li>

<li>
<?php echo $html->link(__("Functionality",true),'/functionality'); ?>
</li>


<li>
<?php echo $html->link(__("Download",true),'http://www.freedomfone.org/page/downloads',array('target'=>'blank')); ?>
</li>

<li>
<?php echo $html->link(__("Read more",true),'http://www.freedomfone.org',array('target'=>'blank')); ?>
</li>


<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>


<li><?php echo __("Poll",true);?>
<ul>
<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("Manage polls",true),'/polls/'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>

<li>
<?php echo $html->link(__("Other SMS",true),'/bin/'); ?>
</li>


<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>


<li><?php echo __("Leave-a-Message",true);?>
<ul>
<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("Inbox",true),'/messages/'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>

<li>
<?php echo $html->link(__("Archive",true),'/messages/archive'); ?>
</li>


<li>
<?php echo $html->link(__("Tags",true),'/tags/'); ?>
</li>

<li>
<?php echo $html->link(__("Categories",true),'/categories/'); ?>
</li>

<li>
<?php echo $html->link(__("IVR Menu",true),'/lm_menus/settings'); ?>
</li>


<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>



<li><?php echo __("Voice menus",true);?>
<ul>
<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("Voice menus",true),'/ivr_menus'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>

<li>
<?php echo $html->link(__("Menu options",true),'/nodes/index'); ?>
</li>

<li>
<?php echo $html->link(__("Monitoring",true),'/monitor_ivr'); ?>
</li>


<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>



<li><?php echo __("Callback",true);?>
<ul>
<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("Callbacks",true),'/callback/index'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>

<li>
<?php echo $html->link(__("Settings",true),'/callback_settings/index'); ?>
</li>

<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>


<li><?php echo __("Dashboard",true);?>
<ul>

<li>
<?php echo $html->image('menu/corner_inset_left.png',array('class'=>'corner_inset_left')); ?>
<?php echo $html->link(__("System Health",true),'/processes'); ?>
<?php echo $html->image('menu/corner_inset_right.png',array('class'=>'corner_inset_right')); ?>
</li>


<li>
<?php echo $html->link(__("What's running?",true),'/processes/software'); ?>
</li>

<li>
<?php echo $html->link(__("Hardware",true),'/hardware'); ?>
</li>


<li>
<?php echo $html->link(__("Call data records",true),'/cdr'); ?>
</li>

<li>
<?php echo $html->link(__("Statistics",true),'/cdr/overview'); ?>
</li>


<li class='last'>
<?php echo $html->image('menu/corner_left.png',array('class'=>'corner_left')); ?>
<?php echo $html->image('menu/dot.gif',array('class'=>'middle'));?>
<?php echo $html->image('menu/corner_right.png',array('class'=>'corner_right'));?>
</li>
</ul>
</li>



<li>
<a href='https://dev.freedomfone.org/' target='_blank'><?php echo $html->image('menu/menu_mid_svn.png',array('style'=>'float:left'));?></a>
</li>


<li class='logo'>
<?php echo $html->image('menu/menu_right_long.png',array('style'=>'float:left'));?>
</li>

</ul>
</div>
