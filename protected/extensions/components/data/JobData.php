<?php

/** 
 * @author WORKSTATION
 * 
 * 
 */
class JobData extends CComponent {	
	public $command;
	public $connection;
	public $id;	
	
	/**	 
	 * Creates a new instance of Job data
	 * @param UserIdentity $user
	 */
	function __construct($email) {		
		$this->connection = Yii::app()->db;
		$this->command = $this->connection->createCommand("SELECT sp.id AS id FROM {{serviceproviders}} sp JOIN {{teammembers}} tm ON 
		sp.id = tm.serviceproviders_id WHERE tm.email = :email");
		$this->command->bindParam(":email",$email, PDO::PARAM_STR);
		$row = $this->command->queryRow();
		$this->id = $row['id'];
		
	}
	public function getJobsInProgress()
	{
		$jobsInProgress = 0;
		$this->command->reset();
		$this->command->setText("SELECT id from {{jobs}} WHERE users_id = :id AND jobStatus = ".Jobs::IN_PROGRESS);
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$jobsInProgress = count($rows);
		return $jobsInProgress;
	}
	public function getJobsCompleted()
	{
		$completedJobs = 0;
		$this->command->reset();
		$this->command->setText("SELECT id from {{jobs}} WHERE users_id = :id AND jobStatus = ".Jobs::COMPLETED);
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$completedJobs = count($rows);
		return $completedJobs;	
	}
	/**
	 * Returns the number of posted jobs which have received a proposal
	 */
	public function getActiveJobProposalCount()
	{
		$activejobProposals = 0;
		$this->command->reset();
		$this->command->setText("SELECT id from {{jobs}} WHERE users_id = :id AND jobStatus = ".Jobs::ACTIVE_PROPOSALS);
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$activejobProposals =  count($rows);
		return $activejobProposals;
	}
	
	/**
	 * Returns the total number of job request to the service provider logged in
	 */
	public function getJobRequestCount()
	{
		$jobRequestCount = 0;
		$this->command->reset();
		$this->command->setText("SELECT jobs_id FROM {{jobRequests}} WHERE serviceproviders_id=:id");
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$jobRequestCount = count($rows);
		return $jobRequestCount;
	}
	/**	 
	 * Returns the total number of unread job request alerts
	 */
	public function getJobRequestAlertCount()
	{
		$jobRequestAlertCount = 0;
		$alertCount = 0;
		$this->command->reset();
		$this->command->setText("SELECT jobs_id FROM {{jobRequests}} WHERE serviceproviders_id=:id and status = ".JobRequests::NOT_CONSIDERED);
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$jobRequestAlertCount = count($rows);
		return $jobRequestAlertCount;
	}	
	
	private function getJobRequestIds()
	{
		$this->command->reset();
		$this->command->setText("SELECT jobs_id FROM {{jobRequests}} WHERE serviceproviders_id=:id");
		$this->command->bindParam(":id", $this->id, PDO::PARAM_STR);
		$rows = $this->command->queryAll();
		$ids = array();
		foreach ($rows as $row)
		{
			$ids[]=$row['jobs_id'];
		}		
		return $ids;
	}
}

?>