<?php
Yii::import('ext.payment.payfast.Payfast');

/**
 * A confirmation form for orders
 * @author Mbagwu Chibundu
 *
 */
class Confirmation extends CWidget {
	
	
	public $orderConfig;	
	
	public $orderFulfillmentUrl = '';

	public $cancel_literal = '_';
	
	public $cancel_url = '';
	
	public $payer_details = array();
	
	public $hosted_button_id = '';
	 
	

	/**
	 * (non-PHPdoc)
	 * @see CWidget::run()
	 */
	public function run()
	{		
		
		$payfast = new Payfast();		
		
		$orderConfig = $this->orderConfig;
		
		$order_ids = OrderHelper::takeOrders($orderConfig);		
		
		$this->render('confirmationForm', array(
				'order_ids'=>$order_ids,
				'orderConfig'=>$orderConfig,				
				'configuration'=>$payfast->configuration, 
				'action'=>$payfast->action, 
				'method'=>$payfast->method,				
				'cancel_literal'=>$this->cancel_literal,
				'cancel_url'=>$this->cancel_url,
				'payer_details'=>$this->payer_details,
				)
		);
		
	}

}

?>