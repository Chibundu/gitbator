<div class="row">
<div class="span5">
<?php
$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Contact Us</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>

<div class="form">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note prepend-top append-bottom">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'name', array('class'=>'span5'));?>

	<?php echo $form->textFieldRow($model, 'email', array('class'=>'span5'));?>

	<?php echo $form->textFieldRow($model, 'subject', array('class'=>'span5'));?>

	<?php echo $form->textAreaRow($model, 'body', array('class'=>'span5','rows'=>6, 'columns'=>50));?>

	<?php if(CCaptcha::checkRequirements()): ?>
	<?php echo $form->captchaRow($model, 'verifyCode', array('class'=>'span5'));?>
	<?php endif; ?>

	<div class="form-actions">
	<?php echo CHtml::submitButton('Submit', array('class'=>'medium nice radius gold button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
</div>
</div>