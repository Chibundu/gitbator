<?php
class PaymentGateway extends CApplicationComponent {	
	
	private $_gateway;
	
	private $_action = '';
	
	private $_method = 'post';
	
	private $_id = 'confirm_payments';
	
	public $config;
	
	public function __construct($gateway, $config)
	{	
		if(!is_array($config) || empty($config) || empty($config['config'])){
			throw new CException('Gateway Configuration missing');
			exit;
		}
		else if(empty($config['action']))
		{
			throw new CException('No action specified for payment gateway');
			exit;
		}
					
		$this->config = $config['config'];	
		$this->setGateway($gateway);
	}
	
	/**	 
	 * Sets payment gateway
	 * @param string $gateway
	 */
	public function setGateway($gateway)
	{
		$this->_gateway = $gateway;
	}
	
	/**	 
	 * gets payment gateway
	 */
	public function getGateway()
	{
		return $this->_gateway;	
	}
	
	/**	 
	 * gets the entire form element to be dispatched to payment gateway	 
	 */
	public function getConfirmForm()
	{
		$form='<form method = "'.$this->_method.'" action="'.$this->_action.'" id="'.$this->_id.'">';
	
		foreach ($this->config as $c)
		{
			$form.='<input type="hidden" name="'.$c['name'].'" value="'.$c['value'].'">';
		}	
		
		$form.='</form>';

		return $form;
	}
	
	 
	
}

?>