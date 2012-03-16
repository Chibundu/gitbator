<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'qual',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'sfrom',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'sto',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'ref',array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'isVerified',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'serviceProviders_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'qualificationCategory_id',array('class'=>'span5')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
