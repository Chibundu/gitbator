

<h1><?php echo Yii::t('general', 'Register'); ?></h1>
<h3>Already have an account? <?php echo CHtml::link('Login', array('/site/login')); ?></h3>
<div class = "row prepend-top">
<div class = "span6">
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'reg-form',
	'enableAjaxValidation'=>true,
)); ?>
<p class="note append-bottom"><?php echo Yii::t('forms', 'Fields with ')?><span class="required">*</span><?php echo Yii::t('forms', ' are required.')?></p>
<?php echo $form->dropDownListRow($model, 'account_type', array('ET'=>'Entrepreneur', 'SPF'=>'Service Provider (Freelancer)', 'SPC'=>'Service Provider (Company)', 'MT'=>'Mentor', 'PT'=>'Partner'), array('class'=>'medium pop','data-content'=>'How do you intend participating on the Vcubator. Please select the option which will most match your new role on the Vcubator.', 'data-original-title'=>"Account Type"))?>
<?php echo $form->textFieldRow($model, 'firstname', array('class'=>'span5 pop', 'data-content'=>'Please enter your first name here.', 'data-original-title'=>"First Name"));?> 
<?php echo $form->textFieldRow($model, 'lastname', array('class'=>'span5 pop', 'data-content'=>'Please enter your surname here.', 'data-original-title'=>"Surname"));?>
<?php echo $form->textFieldRow($model, 'email', array('class'=>'span5 pop','data-content'=>'Please enter a valid email by which we may contact you.', 'data-original-title'=>"Email"));?>
<div class="row">
	<div class="span2">
		<?php echo $form->dropDownListRow($model, 'country_code', CountryUtility::$intl_code, array('class'=>'span2 pop','data-content'=>'Please select the right international country code for your country. e.g 27 for South Africa.', 'data-original-title'=>"How to enter your Mobile Number"))?>
	</div>
	<div class="span3">
		<?php echo $form->textFieldRow($model, 'phone', array('class'=>'span3 pop','data-content'=>'Please enter a valid mobile number by which we may contact you. Please leave out the international code and the preceding zero. For example 787274356', 'data-original-title'=>"Phone"));?>
	</div>	
</div>
<div class="row">
<div class="span5 muted tip">Please select your international calling code from the dropdown box and then enter your mobile phone number without preceding zero.(e.g 787274456)</div>

</div>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span5 pop', 'data-content'=>'Please enter a strong password here. Write it down somewhere so that you can use it to log in.', 'data-original-title'=>"Password"));?>
<?php echo $form->passwordFieldRow($model, 'password_repeat', array('class'=>'span5 pop', 'data-content'=>'Please repeat the password you entered in the previous box.', 'data-original-title'=>"Password"));?>
<?php echo $form->dropDownListRow($model, 'country', CountryUtility::$countries, array('class'=>'medium pop', 'data-content'=>'Please enter your country of residence', 'data-original-title'=>"Country"))?>

<div class = "form-actions prepend-top">
<?php echo CHtml::submitButton('Submit', array('class'=>'nice gold medium radius button'));?>
</div>

<?php $this->endWidget(); ?>
</div>
<div class = "span6">
<div class = "row">
<div class = "span4" style = "float: right;"> 
<div class = "splash panel">		
  <h2><?php echo Yii::t('general', 'Instant access to world class Virtual Business Incubation...');?></h2>
	<ul>
		<li><?php echo Yii::t('general', 'Get your business off the ground')?></li>
		<li><?php echo Yii::t('general','Guarantee the success of your business');?></li>
		<li><?php echo Yii::t('general','Gain access to funding');?></li>
		<li><?php echo Yii::t('general','Get quality services at discounted rates');?></li>
		<li><?php echo Yii::t('general','Enjoy high quality mentoring');?></li>									
	</ul>	
</div>	
</div> 			
</div>
</div>
</div> 






<?php
$cs = Yii::app()->clientScript;

$cs->registerScript('pop_ups','
	var pop = $(".pop");
	if(pop.length)
	{
		pop.each(function(){
			$(this).popover();
		});				
	}
', CClientScript::POS_READY); 
?>



