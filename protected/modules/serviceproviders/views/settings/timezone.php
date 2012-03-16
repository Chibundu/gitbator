<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Settings'=>array('/serviceproviders/settings'),
	'Timezone',
);
$timezones = Yii::app()->params['timezones'];

?>
<div class = "row-fluid">
<div class="span10">
<h2 class="append-bottom">My Timezone: <?php echo $model->formattedTimeZone ?></h2>
<?php
$this->widget('ext.bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm'); 
?>
<?php 

echo $form->dropDownListRow($model, 'timeZone', $timezones); ?>
<p class="form-actions">
<?php
echo CHtml::submitButton('Submit', array('class'=>'nice gold radius button'));
?>
</p>
<?php 
$this->endWidget(); 
?>
</div>

</div>