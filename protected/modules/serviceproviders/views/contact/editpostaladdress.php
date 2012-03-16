<?php
$this->breadcrumbs = array(
						'Service Providers'=>array('/serviceproviders'),
						'Contact'=>array('profile/contact'),
						'Postal Address',						
					);
 ?>
 <div class="row-fluid">
 <div class="span10">
	 <h2 class="append-bottom">Update Postal Address</h2>
 	<?php $this->widget('ext.SimpleFlash'); ?> 	
 	
	 <?php $form = $this->beginWidget("ext.bootstrap.widgets.BootActiveForm", array(
	 									'enableAjaxValidation'=>true,
	 									 'id'=>'addresses-form',
	 ));?>	 
	 
	 <?php echo $form->textFieldRow($postal_address,'firstline',array('class'=>'span10'));?>
	 <?php echo $form->textFieldRow($postal_address,'secondline', array('class'=>'span10'));?>
	 <?php echo $form->textFieldRow($postal_address,'postalCode');?>
	 <?php echo $form->textFieldRow($postal_address,'city', array('class'=>'span10'));?>	
	 <?php echo $form->dropDownListRow($postal_address,'province',Yii::app()->params['provinces']);?>	
	<?php echo $form->dropDownListRow($postal_address,'country', CountryUtility::$countries)?>
	
	<div class="well">
		<?php echo CHtml::submitButton('Update',array('class'=>'gold nice radius button')); ?>
	</div>
	
	 <?php $this->endWidget();?>
 	
 </div>
 </div>