<?php
$this->breadcrumbs = array(
						'Service Providers'=>array('/serviceproviders'),
						'Contact'=>array('profile/contact'),
						'Physical Address',						
					);
 ?>
 <div class="row-fluid">
 <div class="span12">
	 <h3>Update Primary Email</h3>
	 <?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>	 
	 <?php $form = $this->beginWidget("ext.bootstrap.widgets.BootActiveForm", array(
	 									'enableAjaxValidation'=>true,
	 									 'id'=>'email-form',
	 ));?>
	 <?php echo $form->textFieldRow($model,'email', array('class'=>'span8'));?>
	 <?php echo CHtml::submitButton('<i class = "icon-share-alt"></i>Update', array('class'=>'btn')); ?>	 
	 <?php $this->endWidget();?>
</div>
 </div>