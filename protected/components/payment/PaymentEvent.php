<?php


class PaymentEvent extends CModelEvent {
	/**	 
	 * The payment model
	 * @var Payments
	 */
	public $model;	
	/**	 
	 * The controller processing the payment
	 * @var CController
	 */
	public $controller;
	
	/**	 
	 * Action to call back for further processing
	 * @var string
	 */	
	public $callback;
	
	/**	 
	 * The url the back button will point to
	 * @var string
	 */
	public $url_stack;
	/**	 
	 * The model to handle payment
	 * @param CModel $model
	 */
	
	/**	 
	 * error message
	 * @var string
	 */
	public $error;
	
	public function __construct(CModel $model)
	{
		$this->model = $model;
	}
}

?>