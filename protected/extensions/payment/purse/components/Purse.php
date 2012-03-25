<?php
/**
 * Handles all necessary functions of the VPurse, especially payment and receipt of funds
 * @author Mbagwu Chibundu
 * 
 *
 */
class Purse extends CComponent {
	
	/**
	 * Issues payment from a users purse
	 * @param int $order_id the order id
	 * @param string $user_type The type of user: SP for Service Provider, ENT for Entrepreneur
	 * @param string $successMessage
	 * @param string $errorMessage
	 */
	public function pay($order_id, $user_type, $successMessage = '', $errorMessage = '')
	{
		
		if($user_type == "SP")
		{
			$order = SpOrder::model()->with('serviceprovider')->findByPk($order_id);
			
			if($order == NULL)
			{
				if($errorMessage != '')
				{
					Yii::app()->user->setFlash('error', $errorMessage);
				}
				return false;
			}
			else 
			{
			
				$amountToPay = $order->amount;
				$serviceprovider = $order->serviceprovider;
				
				$currency = $serviceprovider->currency_id;
				$balance = $serviceprovider->purse;
				
				//if the currency of the purse differs from that of the order, then convert the currency of the order to that of the purse
				if($currency != $order->currencies_id)
				{
					$from = Currencies::model()->findByPk($order->currencies_id)->code;
					$to = Currencies::model()->findByPk($currency)->code;
					$amountToPay = CurrencyConverter::convert($from, $order->amount, $to);
				}
				
				//check if user has enough v-cash to pay
				if($balance > $amountToPay)
				{
				
					$serviceprovider->purse = $balance - $amountToPay;
					$serviceprovider->save(false);
					$order->status = SpOrder::PAID;
					$order->save(false);
					
					$payment = new SpPayments();
					$payment->spOrder_id = $order->id;
					$payment->method = SpPayments::PURSE;
					$payment->amount = $amountToPay;
					$payment->status = SpPayments::PAID;
					$payment->save(false);
					
					if($successMessage != '')
					{
						Yii::app()->user->setFlash('success', $successMessage);
					}
					
					return true;
				}
				else 
				{
					Yii::app()->user->setFlash('error', '<h3>Insufficient Funds</h3> Cannot proceed with requested payments because your VPurse balance is too low.<p style = "padding-top: 5px;">'.CHtml::link('Load your V-purse &raquo;', array('payment/loadVPurse'), array('class'=>'btn')).'</p>');
					return false;
				}

				
			}
		}
	}

}

?>