<?php 

$this->widget('ext.indicator.Tracker.ProgressTracker', array(
		'levels'=>array('Address Data', 'Register Services', 'Other Information', 'Company Details'),
));

$baseUrl = Yii::app()->request->baseUrl;

?>

<div class = "row-fluid">
	<div class = "span4">
		<h1>Address</h1>
	</div>
</div>

<div class = "row-fluid">
	<div class = "span7 prepend-top">
		<?php $this->widget('ext.SimpleFlash', array('message'=>'<h3>Let\'s start with your profile and make it real Hot!</h3>
		It will take a few minutes of your time, but it is worth the effort. You get more jobs when your profile is complete.'))?>
	</div>
</div>

<div class ="row-fluid">
<div class = "span7 prepend-top">



<h3>Physical Address</h3>

<p class = "help-block">Please enter your address below. All fields marked <span class="required">*</span> are required</p>

<?php $form = $this->beginWidget('BootActiveForm', array(	
					'enableAjaxValidation'=>true,
	 				 'id'=>'address-form',
));?>
 <?php echo $form->textFieldRow($address,'firstline', array('class'=>'span12'));?>
	 <?php echo $form->textFieldRow($address,'secondline', array('class'=>'span12'));?>
	 <?php echo $form->textFieldRow($address,'city', array('class'=>'span12'));?>	
	 <?php echo $form->dropDownListRow($address,'province',Yii::app()->params['provinces']);?>	
	 <?php echo $form->dropDownListRow($address,'country', CountryUtility::$countries)?>
<hr>
<h3>Postal Address</h3>
 	<?php echo $form->textFieldRow($postal_address,'firstline', array('class'=>'span12'));?>
	 <?php echo $form->textFieldRow($postal_address,'secondline', array('class'=>'span12'));?>
	  <?php echo $form->textFieldRow($postal_address,'postalCode', array('class'=>'span12'));?>
	 <?php echo $form->textFieldRow($postal_address,'city', array('class'=>'span12'));?>	
	 <?php echo $form->dropDownListRow($postal_address,'province',Yii::app()->params['provinces']);?>	
	 <?php echo $form->dropDownListRow($postal_address,'country', CountryUtility::$countries)?>
	<p class="form-actions">
	<?php echo CHtml::submitButton("Save & Continue", array('class'=>'nice gold radius button'));?>
	 </p>
<?php $this->endWidget(); ?>
</div>
</div>