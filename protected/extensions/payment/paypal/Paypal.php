<?php
class Paypal {
	
	public $action  = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
	
	public $confirm_page = "ext.payment.paypal.ConfirmPage";
	
	public $method = "post";
	
	public $configuration = array(			
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'cmd',
							'value'=>"_s-xclick"
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'hosted_button_id',
							'generate-data'=>'hosted_button_id',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'image',
							'name'=>'submit',
							'src'=>"https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif",
							'border'=>"0",
							"alt"=>"PayPal - The safer, easier way to pay online!",							
					)
			),
			array(
					'tag'=>'img',
					'htmlOptions'=>array(
							'border'=>'0',
							'src'=>'https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif',
							'width'=>"1",
							'height'=>'1'
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'first_name',
							'generate-data'=>'firstname',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'last_name',
							'generate-data'=>'lastname',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'email',
							'generate-data'=>'email',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'address1',
							'generate-data'=>'firstline',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'address2',
							'generate-data'=>'secondline',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'city',
							'generate-data'=>'city',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'country',
							'generate-data'=>'country_code',
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'zip',
							'generate-data'=>'postalCode',
					)
			), 
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'cancel_return',
							'value'=>'http://thevcubator.com/payments/paypal_cancel?',
							'append'=>array(
									'poi'=>'poi',
							),
					)
			),
			array(
					'tag'=>'input',
					'htmlOptions'=>array(
							'type'=>'hidden',
							'name'=>'return',
							'value'=>'http://thevcubator.com/paypal_success.php?sandbox=1',
							'append'=>array(
									'poi'=>'poi',
							),
					)
			),
		);
	
	
	
	

}

?>