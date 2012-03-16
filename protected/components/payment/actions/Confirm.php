<?php

class Confirm extends CAction {
	/**	 
	 * Controller to which this action is attached
	 * @var CController
	 */	
	public $controller;
	
	/**	 
	 * This represents the class of gateway action; for example, a buy button on paypal and all
	 * it's variants in other gateway
	 * @var string
	 */
	public $actionType = '';
	
	public function run()
	{
		if(isset($_POST['payment_id'])){			
			$id = $_POST['payment_id'];
		}
		else
		{			
			$sp = Miscellaneous::getServiceProvider();
			$pId = $sp->prefixedId;
			$id = Payments::model()->findByAttributes(array('payer'=>$pId, 'status'=>Payments::BEING_PROCESSED))->id;
		}
		
		$payment = Payments::model()->findByPk($id);

		if($payment){
		if(isset($_POST['Payment_Option']))		
			$payment->meansOfPayment = CHtml::encode($_POST['Payment_Option']);
		$payment->type = $this->actionType;

	
		$event = new PaymentEvent($payment);
		$event->controller = $this->controller;
						 
		$pt = Yii::app()->paymentTransaction;
		$cancel_url ='';
		
		if(isset($_POST['cancel']))
		{
			if(isset($_POST['cancel']))			
			$cancel_url = CHtml::encode($_POST['cancel_url']);
			$event->url_stack = $cancel_url;
			$pt->cancel($event);			
		}
		else
		{
			$pt->paymentOptionSelected($event);	
		}
		}
		else
		{
			$this->controller->redirect(array($this->controller->id.'/'.$this->controller->defaultAction->id));
		}
	}

}

?>