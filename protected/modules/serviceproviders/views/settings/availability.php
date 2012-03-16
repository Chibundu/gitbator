<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Settings'=>array('/serviceproviders/settings'),
	'Availibility',
);
?>
<h2>Availability</h2>

<?php
if(Yii::app()->user->hasFlash('block-message error')){ 
	$this->widget('ext.bootstrap.widgets.BootAlert', array('keys'=>'block-message error'));
}
?>
<?php
if(Yii::app()->user->hasFlash('block-message success')){ 
	$this->widget('ext.bootstrap.widgets.BootAlert', array('keys'=>'block-message success'));
}
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm');?>
<div class = "prepend-top append-bottom row-fluid">
<span class = "note">Please set your availability to receive jobs on the Vcubator and click the <b>Update</b> button below</span>
</div>
<div class="row-fluid">
	<div class="span12 append-bottom">
	<?php echo CHtml::radioButton('isAvailable', $model->isAvailable, array('value'=>'Yes'));?> Yes, I'm available to receive jobs on the Vcubator
	</div>
</div>
<div class = "row-fluid">	
	<div class="span12 append-bottom">
	<?php echo CHtml::radioButton('isAvailable', !$model->isAvailable,  array('value'=>'No'));?>No, I'm not available to receive jobs on the Vcubator at the moment
	</div>
</div>




<hr />

<h5>Work Hours</h5>
<?php foreach($availabilities as $i=>$availability):?>

	
		<div class = "row-fluid append-bottom">
			<div class="span1">
			<?php echo $form->checkBox($availability, "[$i]isAvailable");?>
			</div>
			<div class="span2">
			<?php echo $availability->dayLiteral; ?>
			</div>
			<div class = "span3">
			<?php $this->widget('ext.jui_timepicker.JTimePicker', array(
				'model'=>$availability,
				'attribute'=>"[$i]start",
				'htmlOptions'=>array('class'=>'span3'),
			));?>
			</div>
			<div class = "span3">
			<?php $this->widget('ext.jui_timepicker.JTimePicker', array(
				'model'=>$availability,
				'attribute'=>"[$i]end",
			'htmlOptions'=>array('class'=>'span3'),
			));?>
			</div>	
		</div>
		
	
<?php endforeach;?>
<div class = "row-fluid">
<p class="form-actions">
	<?php echo CHtml::submitButton('Update', array('class'=>'nice gold radius button'));?>
</p>
</div>
<?php $this->endWidget(); ?>



