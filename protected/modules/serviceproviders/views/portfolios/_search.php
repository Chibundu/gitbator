<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tag',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textAreaRow($model,'resource_location',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'Description',array('class'=>'span5','maxlength'=>512)); ?>

	<?php echo $form->textFieldRow($model,'serviceproviders_id',array('class'=>'span5')); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
