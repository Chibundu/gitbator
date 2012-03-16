<div class = "row-fluid prepend-top">
	<div class = "span12">
		<h2>Verify <u><i><?php echo $mobile_num; ?></i></u></h2>
	</div>
</div>
<div class = "row-fluid prepend-top">
	<div class = "span7">
	<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
	</div>
</div>
<div class="row-fluid prepend-top">
	<div class = "span7">
	<?php echo CHtml::ajaxLink('<i class = "icon-share-alt"></i>Send Verification Code', array('verifications/sendSMS'), array('update'=>'#notice'), array('class'=>'btn'));?>
	</div>	
</div>

<div class = "row-fluid prepend-top">
	<div class = "span8">
	<div class = "row-fluid">
		<div class = "span8">
			<p class="help-block">Please enter the verification code sent to <?php echo $mobile_num; ?></p>
			<p id="notice" class="note errorMessage prepend-top"></p>
		</div>
	</div>
	<div class = "row-fluid">
	
	<?php 
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm');
	?>
	<?php echo $form->textFieldRow($verification,'phone_code_entered', array('class'=>'span4'))?>
	<p class="form-actions">
	<?php echo CHtml::submitButton('Submit', array('class'=>'nice gold radius button'));?>
	</p>
	<?php $this->endWidget()?>
	</div>
	</div>
</div>