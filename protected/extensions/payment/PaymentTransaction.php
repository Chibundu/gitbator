<?php
/** 
 * Payment Transaction defines the data and events necessary to carry out a payment transaction on the Vcubator
 * @author Chibundu Mbagwu
 *
 */
class PaymentTransaction extends CApplicationComponent {
	/**	 
	 * The model handling the payment
	 * @var CModel
	 */
	public $model;
	
	/**	 
	 * The available payment options
	 * @var array
	 */
	public $paymentOptions;
	
	/**	 
	 * Images displayed beside each payment option
	 * @var array
	 */
	public $brands;
	
	/**	 
	 * Parameters to calculate the transaction charge<br> Array keys include:<br> 
	 * add - the value here is added to the cost of the product or service compute the transaction charge<br>
	 * multiply - the value here is multiplied with the cost of the product or service to compute the transaction charge
	 * @var array
	 */
	public $transactionCharge;
	
	/**	 
	 * The alias path to the page that handles payment confirmation
	 * @var string
	 */
	public $confirmPage;
	
	/**	 
	 * an array of key=>values gateway-specific configuration details, classed in types - typeA, typeB, etc
	 * 
	 * e.g 'gatewayConfig'=>array(
	 *		'typeA' => array(
	 *			'paypal'=> array(
	 *				array('tag'=>'form', 'action'=>'https://www.paypal.com/cgi-bin/webscr', 'method'=>'post', 'closetag'),						
	 *				array('tag'=>'input', 'type'=>'hidden', 'name'=>'cmd', 'value'=>"_s-xclick"),
	 *				array('tag'=>'input', 'type'=>'hidden', 'name'=>'hosted_button_id', 'value'=>"3GJTXLML7RNKW"),
	 *				array('tag'=>'input', 'type'=>'image', 'name'=>'submit', 'src'=>"https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif", 'border'=>"0", "alt"=>"PayPal - The safer, easier way to pay online!", 'value'=>"3GJTXLML7RNKW"),
	 *				array('tag'=>'img', 'border'=>'0', 'src'=>'https://www.paypalobjects.com/en_US/i/scr/pixel.gif', 'width'=>"1", 'height'=>'1'),
	 *			),
	 *			'payfast'=>array(),
	 *			'purse'=>array(),
	 *		)
	 *	),		
	 * @var array
	 */
	public $gatewayConfig;
	
	public function __construct()
	{
		$this->attachBehavior('handlePayment', new PaymentBehavior());
	}
	
	/**	 
	 * Raised on the attempted payment
	 * @param PaymentEvent $event
	 */	
	public function onCreate($event)
	{
		$this->raiseEvent('onCreate', $event);
	}
	
	/**	 
	 * Raised when the payment was successful
	 * @param PaymentEvent $event
	 */
	public function onSuccess($event)
	{
		$this->raiseEvent('onSuccess', $event);
	}
	
	/**	 
	 * Raised when a payment transaction is cancelled
	 * @param PaymentEvent $event
	 */
	public function onCancel($event)
	{
		$this->raiseEvent('onCancel', $event);
	}
	
	/**	 
	 * Raised if a payment transaction fails
	 * @param PaymentEvent $event
	 */
	public function onFail($event)
	{
		$this->raiseEvent('onFail', $event);
	}
	
	/**	 
	 * Raised when a payment option is selected
	 */
	public function onPaymentOptionSelected($event)
	{
		$this->raiseEvent('onOptionSelected', $event);
	}	
	
	
	/**
	 * Raised when payment is completed
	 */
	public function onPaymentComplete($event)
	{
		$this->raiseEvent('onPaymentComplete', $event);
	}
	
	/**	 
	 * Raised when the we receive a FAIL status from the payment gateway
	 * @param PaymentEvent $event
	 */
	public function onPaymentFail($event)
	{
		$this->raiseEvent('onPaymentFail', $event);
	}
	
	/**	 
	 * Raised when we receive a PENDING status from the payment gateway
	 * @param PaymentEvent $event
	 */
	public function onPaymentNotYetReceived($event)
	{
		$this->raiseEvent('onPaymentNotYetReceived', $event);
	}
	
	/**	 
	 * Raised when there's an error related to the current payment event
	 * @param PaymentEvent $event
	 */
	public function onPaymentError($event)
	{
		$this->raiseEvent('onPaymentError', $event);
	}
}

?>