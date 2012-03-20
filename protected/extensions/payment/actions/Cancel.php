<?php

class Cancel extends CAction {
	
	public function run()
	{
		if(isset($_GET['id']))
		{
			$id = CHtml::encode($_GET['id']);
			$payment = Payments::model()->findByPk($id);
			$url = $payment->url_stack;
			$order_id = $payment->order_id;
			if($order_id > -1)
			{
				if(substr($payment->payer, 0, 2) == 'sp'){
					$table = '{{verifications_has_tbl_spOrder}}';
					Miscellaneous::executeDelete('spOrder_id=:id', array(':id'=>$order_id), $table);
					SpOrder::model()->findByPk($order_id)->delete();					
				}
			}
			$payment->delete();
			$this->controller->redirect(array($url));
		}
	}

}

?>