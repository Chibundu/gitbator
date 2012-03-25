<?php
Yii::import('ext.components.payment.options.Option');
Yii::import('ext.components.payment.payfast.Payfast');
Yii::import('ext.components.payment.paypal.Paypal');

class Display extends CWidget {
	
	public $options;
	
	public function run()
	{
		
		if($this->options != Null)
		{			
			$options = $this->options;
		}
		else 
		{			
			$options = $this->getDefaults();			
		}	
		
		$this->render('display', array('options'=>$options));
	}
	
	private function getDefaults()
	{
		$baseUrl = Yii::app()->request->baseUrl;
		
		return array(
					array(
						'name'=>'purse',
						'graphic'=>"$baseUrl/images/purse.png",
					),
					array(
						'name'=>'paypal',
						'graphic'=>"$baseUrl/images/paypal.png",
					
					),
					array(
						'name'=>'payfast',
						'graphic'=>"$baseUrl/images/credit_cards.png"					
					),
				
				);	
		
	}

}

?>