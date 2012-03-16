<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'picture',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'cost',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'cost_type',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'delivery',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'instructions',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'serviceproviders_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'servicecategories_id',array('class'=>'span5')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
