<?php
/** 
 * @author WORKSTATION
 * 
 * 
 */
class MessageData extends CComponent {
	public $id;	
	public $command;
	function __construct($email) {	
		$connection = Yii::app()->db;
		$this->command = $connection->createCommand("SELECT sp.id AS id FROM {{serviceproviders}} sp JOIN {{teammembers}} tm ON 
		sp.id = tm.serviceproviders_id WHERE tm.email = :email");
		$this->command->bindParam(":email",$email, PDO::PARAM_STR);
		$row = $this->command->queryRow();
		$this->id = $row['id'];
	}
	public function getInboxCount()
	{
		$inboxCount = 0;
		$this->command->reset();
		$this->command->setText("SELECT id from {{spMessages}} WHERE serviceproviders_id = :id AND type = ".SpMessages::IN." AND status = ". SpMessages::UNREAD);
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$inboxCount = count($rows);
		return $inboxCount;
	}
	public function getProposalMessageCount()
	{
		$proposalMessageCount = 0;
		$jobRequests = JobRequests::model()->findAllByAttributes(array('serviceproviders_id'=>$this->id));
		foreach ($jobRequests as $jobRequest)
		{
			//Each Job Request has a single proposal
			$proposal = Proposals::model()->findByPk($jobRequest->id);
			if($proposal !== null)
			{				
				$proposalMessageCount += $proposal->responseCount;
			}			
		}
		return $proposalMessageCount;
	}	
	
}

?>