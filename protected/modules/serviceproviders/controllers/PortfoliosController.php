<?php

class PortfoliosController extends Controller
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
			array('allow',			
				'roles'=>array('sp-teamleader','sp-teammember'),
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
		$teammember = Miscellaneous::getTeamMember();
		$model = $this->loadModel($id);
		if(Yii::app()->user->checkAccess('sp-accountOwner', array('sp_id'=>$model->serviceproviders_id))){		
			$this->render('view',array(
				'model'=>$model,
			));
		}
	}	


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Portfolios('create');

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Portfolios']))
		{		
			$sp = Miscellaneous::getServiceProvider();
			$model->attributes=$_POST['Portfolios'];
			$model->serviceproviders_id = $sp->id;
			
			if(isset($_FILES['Portfolios']['name']['resource_location']))
			{
				$model->resource_location = (time()).'_'.$_FILES['Portfolios']['name']['resource_location'];
				$model->size = $_FILES['Portfolios']['size']['resource_location']/(1024 *1024);
			}
			
			if(($sp->portfolioSize + $model->size) <= Yii::app()->params['maxPortfolioSize']){				
				
				if($model->save()){
					
					$profilePoints = $sp->profilePoints;
					if(!$profilePoints->isPortfolio)
					{
						$profilePoints->isPortfolio = true;
						$profilePoints->save(false);
					}
					
					$path = Miscellaneous::getPortfolioPath().$model->resource_location;					
					$croppedPath = Miscellaneous::getCroppedPortfolioPath().$model->resource_location;
					
					if(CUploadedFile::getInstance($model, 'resource_location')->saveAs($path)&& $model->resourceIsImage)
					{
						if(copy($path, $croppedPath))
						{
							$image = Yii::app()->image->load($croppedPath);
							$image->resize(400,400)->quality(100)->sharpen(50);
							$image->save();
							
						}
					}
					
					
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Sorry your work sample could not be uploaded because your portfolio size exceeded the 
				maximum allowed ('.Yii::app()->params['maxPortfolioSize']. ' MB.)');
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
	public function actionUpdate()
	{
		$teammember = Miscellaneous::getTeamMember();
		
		if(isset($_GET['id']) && is_numeric($_GET['id'])){
			
			$id = $_GET['id'];
			$model=$this->loadModel($id);
			$oldPortfolioItem = $model->resource_location;
			
			if(!Yii::app()->user->checkAccess('sp-accountOwner', array('sp_id'=>$model->serviceproviders_id))){		
				throw new CHttpException(404, 'You do not have permission to carry out this action. Please do not repeat this request!');
			}
		}
		else
		{
			throw new CHttpException(404, 'Please do not repeat this request!');
		}
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Portfolios']))
		{	
			$newFileSize = 0;
			$formerFileSize = $model->size;
			if(isset($_FILES['Portfolios']['name']['resource_location']) && $_FILES['Portfolios']['name']['resource_location'] != '')
			{
				if($_FILES['Portfolios']['name']['resource_location'] != ''){
					$model->resource_location = (time()).'_'.$_FILES['Portfolios']['name']['resource_location'];
					$newFileSize = $model->size = $_FILES['Portfolios']['size']['resource_location']/(1024 *1024);
				}
			}
				
			$model->attributes=$_POST['Portfolios'];
			$sp = Miscellaneous::getServiceProvider();
			if(($sp->portfolioSize - $formerFileSize + $newFileSize) <= Yii::app()->params['maxPortfolioSize']){		
				
				if($model->save()){
					if(isset($_FILES['Portfolios']['name']['resource_location']))
					{
						if($_FILES['Portfolios']['name']['resource_location'] != ''){
							@unlink(Miscellaneous::getPortfolioPath().$oldPortfolioItem);
							@unlink(Miscellaneous::getCroppedPortfolioPath().$oldPortfolioItem);
							
							$path = Miscellaneous::getPortfolioPath().$model->resource_location;
							$croppedPath = Miscellaneous::getCroppedPortfolioPath().$model->resource_location;
							
							if(CUploadedFile::getInstance($model, 'resource_location')->saveAs($path) && $model->resourceIsImage)
							{											
								if(copy($path, $croppedPath)){
									$image = Yii::app()->image->load($croppedPath);
									$image->resize(400,400)->quality(100)->sharpen(50);
									$image->save();
								}
							}
						}
					}
					$this->redirect(array('view','id'=>$model->id));
				}
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Sorry your work sample could not be uploaded because your portfolio size exceeded the 
				maximum allowed ('.Yii::app()->params['maxPortfolioSize']. ' MB.)');
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{	
		$teammember = Miscellaneous::getTeamMember();			
			
		if(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			$id = $_GET['id'];
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			if($model){
			
				$spId = $model->serviceproviders_id;
				if(Yii::app()->user->checkAccess('sp-accountOwner', array('sp_id'=>$spId)) && Yii::app()->user->checkAccess('sp-teamleader')){
					$model->delete();	
					$portfolioItems = Portfolios::model()->findAllByAttributes(array('serviceproviders_id'=>$spId));
										
					if(empty($portfolioItems))
					{
						$sp = Miscellaneous::getServiceProvider();
						$profilePoints = $sp->profilePoints;
						$profilePoints->isPortfolio = false;
						$profilePoints->save(false);				
					}	
					
					
					//delete resource
					@unlink(Miscellaneous::getPortfolioPath().$model->resource_location);
					@unlink(Miscellaneous::getCroppedPortfolioPath().$model->resource_location);		
					$this->redirect('index');
				}
				else
				{
					Yii::app()->user->setFlash('error', 'Only team members with administrative privileges can delete from the portolio!');
					$this->redirect('index');
				}
			}
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
		$portfolio = $sp->portfolio;
		$this->render('index',array('portfolio'=>$portfolio));
	}	



	public function actionShow($id)
	{
		$model = Portfolios::model()->findByAttributes(array('id'=>$id));
		$this->redirect(Miscellaneous::getRelativePortfolioPath().$model->resource_location);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Portfolios the data model based on the primary key given in the GET variable
	 */
	public function loadModel($id)
	{
		$model=Portfolios::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='portfolios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
	
}
