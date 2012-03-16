<?php
$this->breadcrumbs=array(
	'Settings',
);?>
<h2>Overview</h2>


<div class="row-fluid prepend-top">
<div class="span6">
Currency in use: <b><?php echo $currency;?></b>
</div>
<div class="span6">
 <?php echo CHtml::link('<i class = "icon-pencil"></i>', array('settings/currency'), array('data-original-title'=>'Change',  'rel'=>'tooltip'))?>
</div>
</div>

<div class="row-fluid prepend-top">
<div class="span6">
Timezone: <b><?php echo $timezone;?></b>
</div>
<div class="span6">
 <?php echo CHtml::link('<i class = "icon-pencil"></i>', array('settings/timezone'), array('data-original-title'=>'Change',  'rel'=>'tooltip'))?>
</div>
</div>

	

<div class="row-fluid prepend-top">
<div class="span6">
Timezone: <b><?php echo $timezone;?></b>
</div>
<div class="span6">
 <?php echo CHtml::link('<i class = "icon-pencil"></i>', array('settings/timezone'), array('data-original-title'=>'Change',  'rel'=>'tooltip'))?>
</div>
</div>

<div class="row-fluid prepend-top">
<div class="span6">
Availability Settings
</div>
<div class="span6">
 <?php echo CHtml::link('<i class = "icon-pencil"></i>', array('settings/availability'), array('data-original-title'=>'Change',  'rel'=>'tooltip'))?>
</div>
</div>