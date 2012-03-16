<?php
$this->breadcrumbs = array(
	'Profile'=>array('profile/'),
	'Verifications'=>array('verifications'),
	'Verify Identity'
); 
$baseUrl = Yii::app()->request->baseUrl; 
?>
<div class = "row-fluid prepend-top">
	<div class = "span12">
		<h2>Verify <u><i><?php echo $email; ?></i></u></h2>
	</div>
</div>
<div class = "row-fluid prepend-top">
<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
</div>
<div class="row-fluid prepend-top">	
<?php echo CHtml::ajaxLink('<i class = "icon-share-alt"></i>Send Verification Link', array('verifications/sendEmail'), array('update'=>'#notice'), array('class'=>'btn'));?>	
</div>

