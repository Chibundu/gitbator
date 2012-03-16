<?php

class EmailController extends Controller
{
	public $layout = 'profile';
	public function filters()
	{		
		return array(
			'accessControl',		
		);
	}	
	
	
	public function accessRules()
	{
		return array(			
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions				
				'roles'=>array('sp-teamleader','sp-teammember'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex() {
		$sp = Miscellaneous::getServiceProvider ();
		$teamLeader = $sp->teamLeader;
		$email = $oldEmail = $teamLeader->email;
		
		if (Yii::app ()->user->checkAccess ( 'sp-teamleader' )) {
			if (isset ( $_POST ['Teammembers'] )) {
				
				$teamLeader->attributes = $_POST ['Teammembers'];
				if ($teamLeader->validate ( array ('email' ) )) {
					$email = $teamLeader->email;
					if ($email != $oldEmail) {
						$auth = SpAuth::model ()->findByAttributes ( array ('username' => $oldEmail ) );
						if ($auth != null) {
							$auth->username = $email;
							$auth->save ( false );
						}
						
						//delete the role and create a new one with the new email
						if (Roles::model ()->exists ( 'username=:email', array ('email' => $oldEmail ) )) {
							$role = Roles::model ()->findByAttributes ( array ('username' => $oldEmail ) );
							$role->delete ();
						}
						
						//we revoke access to the former email and grant access to the new email
						$authManager = Yii::app ()->authManager;
						
					
						$role = new Roles ();
						$role->username = $email;
						$role->role = Roles::TeamLeader;
						$role->save ( false );
						$auth->username = $teamLeader->email;
						$verification = $sp->verification;
						$verification->email = 0;
						$verification->isEmailCodeSent = 0;
						$verification->save ( false );
						$teamLeader->save ( false );		
						$authManager->assign ( 'sp-teamleader', $email );
						$authManager->revoke ( 'sp-teamleader', $oldEmail );				
					}
					Yii::app ()->user->setFlash ( 'success', 'Your email has been changed! We however require you to verify your email. Please click on the verifications link in the profile menu' );		
				}
			
			}
		} 

		else 
		{		
			Yii::app ()->user->setFlash ( 'error', 'You do not have permission to carry out this action!' );
			
			
		}
		
		
		$this->render ( 'updateEmail', array ('teamLeader' => $teamLeader, 'email' => $email ) );
	}	
	
	public function actionUpdateEmail()
	{	
		$sp = Miscellaneous::getServiceProvider();
		
		$teamLeader = $sp->teamLeader;	
		$oldEmail = $teamLeader->email;
		
		if(isset($_POST['Teammembers']))
		{
			
			if(Yii::app ()->user->checkAccess ( 'sp-teamleader')){
	
				$teamLeader->attributes = $_POST['Teammembers'];
				if($teamLeader->validate(array('email')))
				{
					$email = $teamLeader->email;
					$auth = SpAuth::model()->findByAttributes(array('username'=>$oldEmail));
					if($auth!=null){	
						$auth->username = $email;
						$auth->save(false);							
					}
							
					//delete the role and create a new one with the new email
					if(Roles::model()->exists('username=:email', array('email'=>$oldEmail)))
					{
						$role = Roles::model()->findByAttributes(array('username'=>$oldEmail));
						$role->delete();
					}
							
					//we revoke access to the former email and grant access to the new email
					$authManager = Yii::app()->authManager;
					
												
					$authManager->assign('sp-teamleader', $email);
					$authManager->revoke('sp-teamleader', $oldEmail);						
					$role = new Roles();
					$role->username = $email;
					$role->role = Roles::TeamLeader;
					$role->save(false);
					$auth->username = $teamLeader->email;
					$verification = $sp->verification;
					$verification->email = 0; 
					$verification->isEmailCodeSent = 0;
					$verification->save(false);
					$teamLeader->save(false);
					Yii::app()->user->setFlash('success','Your email has been changed! We however require you to verify your email. Please click on the verifications link in the profile menu');
					$this->redirect(array('index'));					
					
				}
			}
			else
			{
				Yii::app()->user->setFlash('error','You do not have permission to carry out this action!');
				$this->redirect(array('index'));
			}
		}		 
		$this->renderPartial('_emailform', array('model'=>$teamLeader));
	}

}