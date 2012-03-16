<?php
class OrderBehavior extends CActiveRecordBehavior {

	/**	 
	 * Changes the status of an order to CANCELLED
	 */
	protected function cancel()
	{
		$this->getOwner()->status = Order::CANCELLED;
		$this->getOwner()->save(false);
	}
	
	/**	 
	 * Changes the status of an order to CONFIRMED
	 */
	protected  function confirm()
	{		
		$this->getOwner()->status = Order::CONFIRMED;
		$this->getOwner()->save(false);
	}
	
	/**	 
	 * This method processes an order by calling the method of an object or class 
	 * @return boolean whether the order has been processed or not; depends on whether 
	 * the order has been processed
	 * @param mixed $obj could be a string - the name of a class whose static method will be called or
	 * an object whose method will be called
	 * @param string $method the name of the method
	 * @param mixed $params a string or array of values to be passed by reference
	 */
	protected function process($obj, $method, $params = null)
	{			
		if($this->getOwner()->status >= Order::CONFIRMED)
		{					
			if(is_array($params) && !empty($params)){				
				call_user_func_array(array($obj, $method), $params);
			}
			else {				
				call_user_func(array($obj, $method));
			}
			
			return true;
		}
		
		return false;
	}

}

?>