<?php

class PaypalCancel extends CAction {
	
	public $controller; 
	
	public function run()
	{		
		$enc = new Encryption();
		$payment_id = $enc->decryptData(urldecode($_GET['payment_id']), Yii::app()->params['enc_key']);				 
		$payment = Payments::model()->findByPk($payment_id);		
		if($payment)
		{			
			$event = new PaymentEvent($payment);
			$event->controller = $this->controller;
			$pt = new PaymentTransaction();
			$pt->cancel($event);
		}
	}
}

?>