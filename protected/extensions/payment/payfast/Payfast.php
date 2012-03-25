<?php


class Payfast {
	/**
	 * The url to post the form to.
	 */
	public $action  = 'https://www.payfast.co.za/eng/process';	
	
	/**
	 *The confirm page
	 */
	public $confirm_page = "ext.payment.payfast.ConfirmPage";
	
	public $method = "post";
		
	public $configuration = array(		
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'merchant_id',
								 'value'=>'10090544',								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'merchant_key',
								 'value'=>'kldm5ulwuqjke',								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'return_url',
								 'value'=>'http://thevcubator.com/payment/finished',								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'cancel_url',
								 'value'=>'http://thevcubator.com/payment/cancelled',								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'notify_url',
								 'value'=>'http://thevcubator.com/payment/notify'								 
							)
						),
				//transaction specific data
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'name_first',
								 'generate-data'=>'firstname',								 								 
							)
						),	
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'name_last',
								 'generate-data'=>'lastname',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'email_address',
								 'generate-data'=>'email',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'m_payment_id',
								 'generate-data'=>'payment_id',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'amount',
								 'generate-data'=>'amount',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'item_name',
								 'generate-data'=>'item_name',															 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'item_description',
								 'generate-data'=>'item_description',															 
							)
						),						
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'email_confirmation',
								 'value'=>'1',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'confirmation_address',
								 'generate-data'=>'confirmation_address',								 								 
							)
						),
						array(
							'tag'=>'input', 
							'htmlOptions'=>array(
								'type'=>'hidden',
								 'name'=>'signature',
								 'generate-data'=>'security_signature',																 
							)
						),										
		);	
	

}

?>