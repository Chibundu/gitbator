<?php

Yii::import('ext.payment.Payfast');

class ConfirmPage extends CWidget {
	
	/**
	 * a PaymentGateway object with necessary configuration
	 * @var Payfast
	 */
	public $payfast;
	
	public function run()
	{
		$this->render('confirm_page', $this->payfast);
	}

}

?>