<?php

class TeamController extends Controller
{	

	public $layout='profile';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(			
			array('allow',
				'actions'=>array('index','update','delete','create'),
				'roles'=>array('sp-teammember','sp-teamleader')
			),			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		if (Yii::app ()->user->checkAccess ( 'sp-teamleader' )) {
			
			$sp = Miscellaneous::getServiceProvider ();
			$sp->refresh ();
			
			$model = new Teammembers ( 'create' );
			$model->serviceproviders_id = $sp->id;
			
			if (count ( $sp->teamMembers ) < 4) {
				$this->performAjaxValidation ( $model );
				
				if (isset ( $_POST ['Teammembers'] )) {
					$model->attributes = $_POST ['Teammembers'];					
					 
					if ($model->validate ()) {						
						$model->storeSkills();								
						$profile_picture = '';
						if (isset ( $_FILES ['Teammembers'] ['name'] ['profile_picture'] ) && $_FILES ['Teammembers'] ['name'] ['profile_picture'] != '') {
							$profile_picture = (time ()) . "_" . $_FILES ['Teammembers'] ['name'] ['profile_picture'];								
							$model->profile_picture = $profile_picture;
							$path = Miscellaneous::getProfilePicturePath () . $model->profile_picture;
							$thumbnailPath = Miscellaneous::getProfileThumbnailPath () . $model->profile_picture;
							if (CUploadedFile::getInstance ( $model, 'profile_picture' )->saveAs ( $path )) {
								if (copy ( $path, $thumbnailPath )) {
									$thumbnail = Yii::app ()->image->load ( $thumbnailPath );
									$thumbnail->resize ( 50, 50 )->quality ( 100 );
									$thumbnail->save ();
								}
								
								$imageSize = getimagesize($path);
								$width = $imageSize[0];
								$height = $imageSize[1];						
								
								if($width > 210 || $height > 150)
								{							
									$profile_picture = Yii::app()->image->load($path);
									$profile_picture->resize(210,150)->quality(100);
									$profile_picture->save();
								}						
								
							}
						}	
						
						if ($model->save ( false )) {
							$authManager = Yii::app()->authManager;
							
							$spAuth = new SpAuth();
							$email = $model->email;
							$spAuth->username = $email;
							$spAuth->password = $model->password;
							$spAuth->encryptPassword();
							$spAuth->teammembers_id = $model->id;
							$spAuth->save(false);	

							$role = new Roles();
							$role->username =$email;
							$role->role = Roles::TeamMember;
							$role->save(false);	
							$authManager->assign('sp-teammember', $email);
							
							$model->refresh();
							Yii::app ()->user->setFlash ( 'success', 'Teammember added successfully!' );
							$this->redirect ( array ('index' ) );
						}
					
					}
					else 
					{	
											
						Yii::app ()->user->setFlash ( 'error', 'An error occured! See details below' );
					}
				}
			} 
			else
			{
				Yii::app ()->user->setFlash ( 'error', 'Sorry, You cannot add more than 4 team members!' );
				$this->redirect ( 'index' );
			}
		} 
		else
		{
			Yii::app ()->user->setFlash ( 'error', 'Only the team leader can add new team members!' );
			$this->redirect ( 'index' );
		}
		$this->render ( 'create', array ('model' => $model ) );
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate() {		
		
		if(isset($_GET['id']) && is_numeric($_GET ['id'])){
			
			$model = $this->loadModel ( $_GET ['id'] );
		}
		else
		{
			$model = Miscellaneous::getServiceProvider()->teamLeader;
		}
		
		$model->retrieveSkills();
		$oldPic = $model->profile_picture;
		$params = array ('teammember' => $model );
		
		//for delete
		$isTeamLeader = Yii::app ()->user->checkAccess ( 'sp-teamleader' );
		$oldEmail = $model->email;
		if (isset ( $_GET ['remove'] )) {
			
			if ($isTeamLeader) {
				if ($oldEmail != Miscellaneous::getTeamMember()->email) {
					
					//delete old auth data
					$this->deleteOldAuthDetails($oldEmail);
					
					$connection = Yii::app ()->db;
					$command = $connection->createCommand("DELETE FROM {{teammemberskills}} WHERE teammembers_id = ".$model->id);					
					$command->execute();
					
					$quals = $model->qualifications;
					foreach($quals as $qual)
					{
						$qual->delete();
					}
					
					$model->delete ();
					Yii::app ()->user->setFlash ( 'success', 'successfully deleted!' );
					Miscellaneous::getTeamMember()->refresh ();
					$this->redirect ( array ('index' ) );
				} else {
					Yii::app ()->user->setFlash ( 'error', 'You cannot delete your own account!' );
					$this->redirect ( array ('index' ) );
				}
			} else {
				Yii::app ()->user->setFlash ( 'error', 'Only the team leader can remove other team members' );
				$this->redirect ( array ('index' ) );
			}
		
		}
		
		//for actual update
		else if (Yii::app ()->user->checkAccess ( 'sp-editTeam', $params )) {
			$this->performAjaxValidation ( $model );
			
			if (isset ( $_POST ['Teammembers'] )) {				
				
				$model->attributes = $_POST ['Teammembers'];
				
				
				//rename any uploaded file for uniqueness
					if (isset ( $_FILES ['Teammembers'] ['name'] ['profile_picture'] ) && $_FILES ['Teammembers'] ['name'] ['profile_picture'] != '') {
						$profile_picture = (time ()) . "_" . $_FILES ['Teammembers'] ['name'] ['profile_picture'];
						$model->profile_picture = $profile_picture;						
					}
					
				
				
				if ($model->save ()) {
					$email = $model->email;
					$user = Yii::app()->user;
					//we update old email in {{authdetails}}
					if($oldEmail!=$email)
					{						
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
						if($user->checkAccess('sp-teamleader') && $oldEmail == $user->id)
						{							
							$authManager->assign('sp-teamleader', $email);
							$authManager->revoke('sp-teamleader', $oldEmail);						
							$role = new Roles();
							$role->username = $email;
							$role->role = Roles::TeamLeader;
							$role->save(false);
						
						}
						else
						{
							
							
							$role = new Roles();
							$role->username = $email;							
							$role->role = Roles::TeamMember;
							$role->save(false);	
											
							$authManager->assign('sp-teammember', $email);
							$authManager->revoke('sp-teammember', $oldEmail);
									
						}
						
					}				
					
					$model->storeSkills();
					$profile_picture = (time ()) . "_" . $_FILES ['Teammembers'] ['name'] ['profile_picture'];
					
					$path = Miscellaneous::getProfilePicturePath () . $model->profile_picture;
					$thumbnailPath = Miscellaneous::getProfileThumbnailPath () . $model->profile_picture;					
					
					if (isset ( $_FILES ['Teammembers'] ['name'] ['profile_picture'] ) && $_FILES ['Teammembers'] ['name'] ['profile_picture'] != '') {
						
						@unlink(Miscellaneous::getProfilePicturePath().$oldPic);
						@unlink(Miscellaneous::getProfileThumbnailPath().$oldPic);
						
						if (CUploadedFile::getInstance ( $model, 'profile_picture' )->saveAs ( $path )) {
							if (copy ( $path, $thumbnailPath )) {
								$thumbnail = Yii::app ()->image->load ( $thumbnailPath );
								$thumbnail->resize ( 50, 50 )->quality ( 100 );
								$thumbnail->save ();
							}
							
							$imageSize = getimagesize($path);
							$width = $imageSize[0];
							$height = $imageSize[1];						
							
							if($width > 210 || $height > 150)
							{							
								$profile_picture = Yii::app()->image->load($path);
								$profile_picture->resize(210,150)->quality(100);
								$profile_picture->save();
							}
							
						}
					}
					Miscellaneous::getTeamMember()->refresh ();
					Yii::app ()->user->setFlash ( 'success', 'You have successfully updated your record!' );
					$this->redirect ( array ('index' ) );
				
				} else {
					Yii::app ()->user->setFlash ( 'error', 'Could not update. See errors below' );
				}
			}
		
		} else {
			Yii::app ()->user->setFlash ( 'error', 'You can only modify your own record if you are not the team leader!' );
			$this->redirect ( array ('index' ) );
		}
		
		$this->render ( 'update', array ('model' => $model ) );
	
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$teammembers = Teammembers::model()->findAllByAttributes(array('serviceproviders_id'=>Miscellaneous::getSpId()));
		
		$this->render('index', array('teammembers'=>$teammembers));
	}

	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Teammembers::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='teammembers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	private function deleteOldAuthDetails($email)
	{
		$authManager = Yii::app()->authManager;
		$authManager->revoke('sp-teammember', $email);
		//delete the role and create a new one with the new email
		if(Roles::model()->exists('username=:email', array('email'=>$email)))
		{
			$role = Roles::model()->findByAttributes(array('username'=>$email));
			$role->delete();
		}
		//Teammembers::model()->deleteAllByAttributes(array('email'=>'email'));
		SpAuth::model()->deleteAllByAttributes(array('username'=>$email));			
	}
	
	
}
