<?php

class OrderEvent extends CEvent {
	
	public $payment;
	
	/**	 
	 * Object representing order
	 * @var Order
	 */
	public $model;
	
	public function __construct(Payments $payment)
	{
		$this->payment = $payment;
		
		if($this->payment!=NULL)
		{
			if(substr($payment->payer, 0, 2) == 'sp')
			{
				$this->model = SpOrder::model()->findByPk($payment->order_id);					
			}
		}
	}	
	
}

?>