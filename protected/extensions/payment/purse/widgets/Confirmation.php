<?php

/**
 * A confirmation form for orders
 * @author Mbagwu Chibundu
 *
 */
class Confirmation extends CWidget {	
	

	public $orderConfig;
	
	
	/**
	 *The url to process the order
	 * @var string
	 */
	public $orderFulfillmentUrl = '';
	
	/**
	 * The method used by the form i.e GET or POST. Defaults to post
	 * @var unknown_type
	 */
	public $method = 'post';
	
	public $cancel_literal = '_';
	
	public $cancel_url = '';
	
	public $payer_details = '';
	
	public $hosted_button_id = '';

	/**
	 * (non-PHPdoc)
	 * @see CWidget::run()
	 */
	public function run()
	{		
		
		$this->render('confirmationForm', array(
				'orders'=> $this->orderConfig['orders'], 
				'action'=>$this->orderFulfillmentUrl, 
				'method'=>$this->method,
				'cancel_literal'=>$this->cancel_literal,
				'cancel_url'=>$this->cancel_url,
				));
	}

}

?>