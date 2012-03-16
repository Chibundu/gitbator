<h1><?php echo Yii::t('general', 'Login'); ?></h1>
<div class = "subheading append-bottom">
<h3>Don't have an account? <?php echo CHtml::link('Create an Account', array('/site/register')); ?></h3>
</div>
<div class = "row">
<div class = "span5">
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'reg-form',
	'enableAjaxValidation'=>true,
)); ?>
<p class="note append-bottom"><?php echo Yii::t('forms', 'Fields with ')?>
<span class="required">*</span><?php echo Yii::t('forms', ' are required.')?>
</p>
	<?php echo $form->textFieldRow($model, 'username', array('class'=>'span4'));?>		
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span4'));?>
	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

<div class = "prepend-top form-actions">
<?php echo CHtml::submitButton('Submit', array('class'=>'nice gold medium radius button'));?>
</div>

<?php $this->endWidget(); ?>
</div>

</div> 






<?php
Yii::app()->clientScript->registerScript('pop_ups','
	var pop = $(".pop");
	if(pop.length)
	{
		pop.each(function(){
			$(this).popover();
		});				
	}
', CClientScript::POS_READY); 
?>
