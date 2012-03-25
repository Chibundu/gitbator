<?php
Yii::import('ext.payment.paypal.Paypal');

/**
 * A confirmation form for orders
 * @author Mbagwu Chibundu
 *
 */
class Confirmation extends CWidget {
	
	
	public $orderConfig;	
	
	
	public $orderFulfillmentUrl = '';

	public $cancel_literal = 'Cancel Order';
	
	public $cancel_url = '';
	
	public $payer_details = array();
	
	public $hosted_button_id = '';
	
	 
	

	/**
	 * (non-PHPdoc)
	 * @see CWidget::run()
	 */
	public function run()
	{		
		
		$paypal = new Paypal();		
		
		$orderConfig = $this->orderConfig;		
		
		$this->render('confirmationForm', array(
				'orders'=>$orderConfig['orders'],
				'configuration'=>$paypal->configuration, 
				'action'=>$paypal->action, 
				'method'=>$paypal->method,			
				'cancel_literal'=>$this->cancel_literal,
				'cancel_url'=>$this->cancel_url,
				'payer_details'=>$this->payer_details,
				'hosted_button_id'=>$this->hosted_button_id,
				'poi'=>OrderHelper::getPOI($orderConfig['user_type'], OrderHelper::takeOrders($orderConfig)),
				));
	}

}

?>