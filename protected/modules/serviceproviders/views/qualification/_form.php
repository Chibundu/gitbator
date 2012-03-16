
<div class = "span10">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'qualification-form',
	'enableAjaxValidation'=>false,
));	
?>

	<p class="help-block append-bottom">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model,'qualificationCategory_id', CHtml::listData(QualificationCategory::model()->findAll(), 'id', 'name'), array('class'=>'span10')); ?>
	<?php echo $form->textFieldRow($model,'qual',array('class'=>'span10','maxlength'=>45)); ?>
	<?php echo $form->dropDownListRow($model,'teammember_id', $model->qualHolders, array('class'=>'span10','maxlength'=>45)); ?>
	
	<?php echo $form->textFieldRow($model,'institution',array('class'=>'span10','maxlength'=>45)); ?>

	<?php echo $form->dropDownListRow($model,'sfrom',RecentYearRange::$years, array('class'=>'span10')); ?>

	<?php echo $form->dropDownListRow($model,'sto',RecentYearRange::$years, array('class'=>'span10')); ?>

	<?php echo $form->textFieldRow($model,'ref',array('class'=>'span10','maxlength'=>128)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span12')); ?>	
	
	<span class="help-block offset-by-two">A brief description(256 characters) of this qualification(Optional).</span>

	<div class="form-actions prepend-top">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'nice gold button')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
