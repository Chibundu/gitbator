<?php

/** 
 * @author Mbagwu Chibundu
 * 
 * 
 */
class PaymentData extends CComponent{
	public $command;
	public $connection;
	public $id;	
	public $prefix;
	public $sp;
	
	function __construct($email)
	{
		$this->connection = Yii::app()->db;
		$this->command = $this->connection->createCommand("SELECT sp.id AS id FROM {{serviceproviders}} sp JOIN {{teammembers}} tm ON 
		sp.id = tm.serviceproviders_id WHERE tm.email = :email");
		$this->command->bindParam(":email",$email, PDO::PARAM_STR);
		$row = $this->command->queryRow();
		$this->id = $row['id'];
		$this->sp = Serviceproviders::model()->findByPk($this->id);
		
	}

	public function getPurseBalance()
	{
		$purseBalance = 0;
		$this->command->reset();
		$this->command->setText("SELECT purse FROM {{serviceproviders}} WHERE id = :id");
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$row = $this->command->queryRow();
		$purseBalance = $row['purse'];		
		return $purseBalance;
	}
	public function getTotalEscrowedFunds()
	{
		$escrowedFunds = 0;
		$payee = $this->prefix.$this->id;		
		$this->command->reset();
		$this->command->setText("SELECT SUM(amount) as escrow FROM {{escrows}} WHERE payee = :payee");				
		$this->command->bindParam(":payee", $payee, PDO::PARAM_STR);
		$row = $this->command->queryRow();
		if(is_array($row) && $row['escrow']!= NULL)
		{			
			return $row['escrow'];
		}
		return 0.0; 
								
	}
	public function getTotalEarnings()
	{
		return $this->sp->earningsToDate;
	}
}

?>