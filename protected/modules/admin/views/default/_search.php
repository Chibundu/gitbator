<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'businessName',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'businessRegNo',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'businessRegType',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'displayName',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'tagline',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'vatNo',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'taxNo',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textAreaRow($model,'pic',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'accountType',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'regYear',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'overview',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'paymentTerms',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'subscriptionPackage',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'earningsToDate',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rating',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'purse',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sizerange_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'currency_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'created_on',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'lastModified',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'timeZone',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'isAvailable',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'isActivated',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'activationCode',array('class'=>'span5','maxlength'=>9)); ?>

	<div class="actions">
		<?php echo CHtml::submitButton('Search',array('class'=>'btn primary')); ?>
	</div>

<?php $this->endWidget(); ?>
