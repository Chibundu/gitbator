<?php
/** 
 * Attaches a purse field to any active record 
 * if it doesn't already have one as well as other functionality * 
 * @author Chibundu
 */
class PurseBehavior extends CActiveRecordBehavior {
	/**	 
	 * the field that represents the purse, N.B it must of the DOUBLE type 
	 * @var string
	 */
	public $purse_attribute = 'purse';
	
	
	//ensures that all new records have a purse balance of zero
	public function beforeSave($event)
	{
		if($this->getOwner()->getIsNewRecord() && $this->purse_attribute !== NULL)
		{
			$this->getOwner()->{$this->purse_attribute} = 0.0;
		}
	}
	/**	 
	 * Adds a value to the purse
	 * @param double $amount
	 */
	public function addToPurse($amount)
	{
		$balance = $this->getOwner()->{$this->purse_attribute};
		$this->getOwner()->{$this->purse_attribute} += $amount;
		if($this->getOwner()->save(false))
		{
			return true;
		}		
		return false;
	}
	
	/**	
	 * Deducts a value from purse
	 * @param double $amount
	 */
	public function deductFromPurse($amount)
	{
		$balance = $this->getOwner()->{$this->purse_attribute};
		$this->getOwner()->{$this->purse_attribute} -= $amount;
		if($this->getOwner()->save(false)){
			return true;
		}
		return false;		
	}
	
	
	
}

?>