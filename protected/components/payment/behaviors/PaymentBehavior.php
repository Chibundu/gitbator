<?php
class PaymentBehavior extends CBehavior {
	public function events()
	{
		$legacy_events = parent::events();
		
		$new_events = array(
			'onSuccess'=>'success',
			'onCancel'=>'cancel',
			'onFail'=>'fail',	
			'onCreate'=>'create',	
			'onPaymentOptionSelected'=>'paymentOptionSelected',
			'onPaymentComplete'=>'paymentComplete',		
			'onPaymentNotYetReceived'=>'paymentNotYetReceived',
			'onPaymentError'=>'paymentError',
			'onPaymentFail'=>'paymentFail',				
		);
		
		return CMap::mergeArray($legacy_events, $new_events);		
	}	
	
	/**	 
	 * Handles successful payment events
	 * @param PaymentEvent $event
	 */
	public function success($event)
	{
		echo "\n\n{$event->model->amount}\n\n";
	}
	
	/**	 
	 * Handles payment cancellation events
	 * @param PaymentEvent $event
	 */
	public function cancel($event)
	{
		$model = $event->model;
		$order_id = $model->order_id;
		if($order_id > -1)
		{
			if(substr($model->payer, 0, 2) == 'sp'){
				$spOrder_model =SpOrder::model();
				$table = '{{verifications_has_tbl_spOrder}}';
				if($spOrder_model->exists('id=:id', array(':id'=>$order_id)))
				{
					Miscellaneous::executeDelete('spOrder_id=:id', array(':id'=>$order_id), $table);
					$spOrder_model->findByPk($order_id)->delete();
				}	
			}
		}		
		$payment = Payments::model()->deleteByPk($event->model->id);	
		Yii::app()->user->setFlash('error', 'You have cancelled your order for '. $event->model->for);	
		$event->controller->redirect(array($event->model->url_stack));
	}
	
	/**	 
	 * Handles payment failure events
	 * @param PaymentEvent $event
	 */
	public function fail($event)
	{
		
	}	
	
	/**	 
	 * Handles payment creation events
	 * @param PaymentEvent $event
	 */
	public function create($event)
	{	
		$event->model->save(false);
		$this->showPaymentOptions($event);									
	}
	
	
	/**	 
	 * Shows the confirmation page that submits to the payment gateway
	 * @param PaymentEvent $event
	 */
	public function paymentOptionSelected($event)
	{	$model = $event->model;	
		$model->save(false);	
		$order = null;	
		$order_id = $model->order_id;
		if($order_id > -1)
		{
			if(substr($model->payer, 0, 2) == 'sp'){
				$order = SpOrder::model()->findByPk($order_id);					
			}
		}		
		$event->controller->render($this->getOwner()->confirmPage, array('payment'=>$model, 'order'=>$order));
	}
	
	/**	 
	 * Displays the payment options
	 * @param PaymentEvent $event 
	 */
	public function showPaymentOptions(PaymentEvent $event)
	{		
		$options = $this->getOwner()->paymentOptions;
		$brands = $this->getOwner()->brands;	
		$transactionCharge = $this->getOwner()->transactionCharge;
		$currency = Currencies::model()->findByPk($event->model->currencies_id)->symbol;
		$cancel_url = $event->url_stack;
		$event->controller->render('application.components.payment.views.paymentOptions', array('model'=>$event->model, 'action'=>$event->callback, 'options'=>$options, 'brands'=>$brands, 'transactionCharge'=>$transactionCharge, 'currency'=>$currency, 'cancel_url'=>$cancel_url));
		Yii::app()->end();
	}	
	
	/**	 
	 * Processes a payment completed event
	 * @param PaymentEvent $event
	 */
	public function paymentComplete(PaymentEvent $event)
	{
		
		$payment = $event->model;
		//mark order as completed
		$payment->status = Payments::COMPLETED;
		$payment->save(false);	
		if($payment->order_id > -1){			
			$orderEvent = new OrderEvent($payment);
			$order = $orderEvent->model;
			$order->status = Order::PAID;
			$order->save(false);
			$handler = $order->handler;
			if($handler != NULL && $handler != ''){
				$handler_array = explode('::', $handler);				
				$obj = trim($handler_array[0]);
				$method = trim($handler_array[1]);		
				
				$order->process($obj, $method);
			}		
		}		
		Yii::app()->user->setFlash('success', 'Thank You. Your order for: '. $event->model->for. ' has been received and is currently being processed');
	}
	
	/**	 
	 * Handles payment received events
	 * @param PaymentEvent $event
	 */
	public function paymentConfirmed(PaymentEvent $event)
	{		
		$payment = $event->model;		
		$payment->status = Payments::COMPLETED;
		$payment->save(false);		
	}
	
	/**	 
	 * Handles payment error event
	 * @param PaymentEvent $event
	 */
	public function paymentError(PaymentEvent $event)
	{
		Yii::app()->user->setFlash('error', $event->error);						
	}	
	
	/**	 
	 * Handles event raised when a PENDING status is received from the payment gateway
	 * @param PaymentEvent $event
	 */
	public function paymentNotYetReceived(PaymentEvent $event)
	{
		$event->model->status = Payments::BEING_PROCESSED;
		$event->model->save(false);
		Yii::app()->user->setFlash('warning', 'Thank you for you order. Your payment is still being processed; as soon as we can confirm payment, we will process your order.');
			
	}
	
	/**	 
	 * Handles event raised when a FAIL status is received from the payment gateway.
	 * @param PaymentEvent $event
	 */
	public function paymentFail(PaymentEvent $event)
	{
		$event->model->status = Payments::FAILED;
		$event->model->save(false);
		Yii::app()->user->setFlash('error', 'Sorry, we cannot confirm your payment at this time! Please try again later.');				
	}	
	
}

?>