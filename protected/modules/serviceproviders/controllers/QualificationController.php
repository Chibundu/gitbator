<?php

class QualificationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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
			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions				
				'roles'=>array('sp-teammember','sp-teamleader'),
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
	public function actionCreate()
	{
		$model=new Qualification('create');
		
		if(isset($_GET['id'])){			
			$id = $_GET['id'];
			if(!get_magic_quotes_gpc())
				$id = addslashes($_GET['id']);
			$model->teammember_id = $id;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Qualification']))
		{			
			$model->attributes=$_POST['Qualification'];
			$sp = Miscellaneous::getServiceProvider();
			$model->serviceProviders_id = $sp->id;
			if($model->save()){
				$profilePoints = $sp->profilePoints;
				if(!$profilePoints->isQualification)
				{
					$profilePoints->isQualification = true;
					$profilePoints->save(false);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(Yii::app()->user->checkAccess('sp-accountOwner',array('sp_id'=>$model->serviceProviders_id))){
		
			$model->setScenario('update');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

			if(isset($_POST['Qualification']))
			{
				$model->attributes=$_POST['Qualification'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}
		else
		{
			throw new CHttpException(404,'Invalid Request. Please do not repeat this request!');	
		}		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('sp-accountOwner',array('sp_id'=>$model->serviceProviders_id)))
		{
			
			$spId = $model->serviceProviders_id;
			
			$model->delete();
			
			$qualifications = Qualification::model()->findAllByAttributes(array('serviceProviders_id'=>$spId));
			
			if(empty($qualifications))
			{				
				$sp = Miscellaneous::getServiceProvider();
				$profilePoints = $sp->profilePoints;
				$profilePoints->isQualification = false;
				$profilePoints->save(false);								
			}
			
			// we only allow deletion via POST request
			

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		$sp = Miscellaneous::getServiceProvider();
		$qualifications = $sp->qualifications;
		
		$numQual = count($sp->qualifications);				
		$numVerifiedQual = count($sp->verifiedQualifications);		
		$numUnverifiedQual = count($sp->unverifiedQualifications);	
		$numPendingQual = count($sp->pendingQualifications);	
		$stat = array('numQual'=>$numQual,'numVerifiedQual'=>$numVerifiedQual,'numUnverifiedQual'=>$numUnverifiedQual, 'numPendingQual'=>$numPendingQual);
		$model = new Qualification('search');
		
		if(isset($_GET['Qualification']))
			$model->attributes = $_GET['Qualification'];
		$this->render('index', array('model'=>$model,'stat'=>$stat));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Qualification('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Qualification']))
			$model->attributes=$_GET['Qualification'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Qualification::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='qualification-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
