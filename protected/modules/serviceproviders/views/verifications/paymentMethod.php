<?php
$this->breadcrumbs = array(	
	'Payment'
); 
$baseUrl = Yii::app()->request->baseUrl;
?>
<h3>Payment Method</h3>
<p class="hint note">Please select your prefered method of payment</p>
<div class="row prepend-top">
<?php $this->widget("application.components.Payment.widgets.PaymentOptionsWidget");?>
</div>