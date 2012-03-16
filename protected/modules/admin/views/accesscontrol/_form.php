<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'authitem-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'standout'),
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>64)); ?>

	<?php echo $form->dropDownListRow($model,'type',Authitem::types(),array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'bizrule',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textAreaRow($model,'data',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
