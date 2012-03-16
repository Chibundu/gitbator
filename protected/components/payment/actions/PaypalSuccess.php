<?php

class PaypalSuccess extends CAction {
	
	public $controller;
	
	public function run()
	{
		$payment_id =  urldecode($_GET['payment_id']);
		$enc = new Encryption();		
		$payment_id = $enc->decryptData($payment_id, Yii::app()->params['enc_key']);
		$payment_id = CHtml::encode($payment_id);
		echo $payment_id; exit;
		$payment = Payments::model()->findByPk($payment_id);
		$event = new PaymentEvent($payment);
		$pt = new PaymentTransaction();
		$pt->paymentCompleted();
	}

}

?>