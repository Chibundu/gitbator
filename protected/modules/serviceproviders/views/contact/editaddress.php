<?php
$this->breadcrumbs = array(	
						'Contact'=>array('profile/contact'),
						'Physical Address',						
					);
 ?>
 <div class="row-fluid">
 <div class="span10">
	 <h2 class="append-bottom">Update Physical Address</h2>
	 <?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>	 
	 <?php $form = $this->beginWidget("ext.bootstrap.widgets.BootActiveForm", array(
	 									'enableAjaxValidation'=>true,
	 									 'id'=>'addresses-form',
	 ));?>
	 <?php echo $form->textFieldRow($model,'firstline', array('class'=>'span10'));?>
	 <?php echo $form->textFieldRow($model,'secondline', array('class'=>'span10'));?>
	 <?php echo $form->textFieldRow($model,'city', array('class'=>'span10'));?>	
	 <?php echo $form->dropDownListRow($model,'province',Yii::app()->params['provinces']);?>	
	 <?php echo $form->dropDownListRow($model,'country', CountryUtility::$countries)?>
	 
	 
	
	 <div class="well">
		<?php echo CHtml::submitButton('Update',array('class'=>'gold nice radius button')); ?>
	</div>
	 <?php $this->endWidget();?>
</div>
 </div>