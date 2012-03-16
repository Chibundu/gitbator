<?php
$this->breadcrumbs = array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Verifications'=>array('verifications'),
	'Verify Identity'
); 
$baseUrl = Yii::app()->request->baseUrl;

$countries =  CountryUtility::$countries;
$teamLeader = $sp->teamLeader;
?>
<h2>Verify  Identity</h2>
<p class="help-block">Please enter the your Passport/Id number and your Nationality of <?php echo $teamLeader->firstname.' '.$teamLeader->lastname?></p>
<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
<?php $this->widget('ext.pixelmatrix.EUniform', array('selector'=>':file')); ?>
<div class="row-fluid prepend-top">
	<div class="span8">
		
			<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
			 array('htmlOptions' =>array('enctype'=>'multipart/form-data')));
			 ?>
						
			<?php echo $form->fileFieldRow($verification,'passport_img', array('class'=>'span8'));?>
			<?php echo $form->fileFieldRow($verification,'cc_img', array('class'=>'span8'));?>
			<?php echo $form->fileFieldRow($verification,'bills_img', array('class'=>'span8'));?>			
			
			<?php echo $form->dropDownListRow($verification,'nationality', $countries, array('class'=>'span8'))?>
			
			<div class="form-actions">
			<?php echo CHtml::submitButton('Request Verification',array('class'=>'nice gold radius button')); ?>
			</div>
			
			<?php $this->endWidget()?>
			
		
	</div>
</div>
