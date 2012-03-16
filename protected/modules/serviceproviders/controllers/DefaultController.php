<?php
Yii::import('ext.components.data.*');
class DefaultController extends Controller
{
	public $layout = 'column1';
	public function accessRules()
	{
		return array(
		array(
			'allow',
			'roles'=>array('sp-teammember','sp-teamleader'),
		),
		array(		
			'deny',
			'users'=>array('*'),			
			),
		);
	}
	public function filters()
	{
		return array('accessControl');
	}
	
	public function actionIndex()
	{			
			
		$email = Yii::app()->user->id;
		
		$jobData = new JobData($email);
		$messageData = new MessageData($email);		
		$serviceProvider = Miscellaneous::getServiceProvider();
		
		$ratings = $serviceProvider->rating;
		
		$paymentData = new PaymentData($email);
		$dashboard = array(
			'jobsInProgress'=>$jobData->getJobsInProgress(),
			'completedJobs'=>$jobData->getJobsCompleted(),
			'activeJobProposals'=>$jobData->getActiveJobProposalCount(),
			'jobRequests'=>$jobData->getJobRequestCount(),
			'inbox'=>$messageData->getInboxCount(),
			'jobRequestAlerts'=>$jobData->getJobRequestAlertCount(),
			'proposalMessages'=>$messageData->getProposalMessageCount(),
			'ratings'=>$ratings,
			'accountBalance'=>$paymentData->getPurseBalance(),
			'earnings'=>$paymentData->getTotalEarnings(),
			'escrowedFunds'=>$paymentData->getTotalEscrowedFunds(),
			'subscriptionPackage'=>$serviceProvider->subscriptionPackage,
			'lastLoggedIn'=>Miscellaneous::getTeamMember()->lastLoggedIn,
			'accountType'=>$serviceProvider->accountType,
		);		
		
		$this->render('index',array('dashboard'=>$dashboard));
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	*/
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}