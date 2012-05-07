<?php

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
						'img'=>"purse.png",
					),
					array(
						'name'=>'paypal',
						'img'=>"paypal.png",
					
					),
					array(
						'name'=>'payfast',
						'img'=>"credit_cards.png",					
					),
				
				);	
		
	}

}

?>