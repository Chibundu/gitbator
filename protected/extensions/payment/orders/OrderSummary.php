<?php
/**
 * Generic Order Confirmation Form Display
 * @author Mbagwu Chibundu
 *
 */
class OrderSummary extends CWidget
{
	/**
	 * An array containing order info.
	 * This array must be 2-dimension i.e It must be an array of arrays
	 * Second, each of the inner arrays must have the following keys:
	 * item
	 * description
	 * quantity
	 * currency_id
	 * currency_symbol	 
	 * unit_price
	 * discount
	 * @var array
	 */
	public $orders;

	public $user_type;
	
	public $user_id;

	
	public function run ()
	{		
		$this->render('summary', array('orders'=>$this->orders));
	}	

}
?>