<?php

class ServicesController extends Controller
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
				'actions'=>array('getServices'),
				'users'=>array('*'),
			),			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions				
				'roles'=>array('sp-teamleader','sp-teammember'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model = new Services();//figure head model
		$otherService = new Otherservices();
		$sp = Miscellaneous::getServiceProvider();			
							
			
		$myServices = $sp->services;	
		$cat_id = 0;
		if(count($myServices)>0)
		{
			$cat_id = $myServices['0']->category->id;//picking up the first item to use as the primary service category					
		}
		$profilePoints = $sp->profilePoints;		
		//we handle any occurence OtherServices model
		if(isset($_POST['Otherservices']))
		{			
			$myOtherServices = $sp->otherservices;
			if(count($myOtherServices)+ count($myServices) >= Yii::app()->params['maxServices'])
			{
				Yii::app()->user->setFlash('error','You have exceeded the limit of services that can be added.');	
				$this->redirect('index');			
			}
			else
			{
				$otherService = new Otherservices();
				$otherService->attributes = $_POST['Otherservices'];			
				$otherService->serviceproviders_id = Miscellaneous::getSpId();
				if($otherService->save())
				{
					Yii::app()->user->setFlash('success', 'New service successfully added');
					$this->redirect('index');		
				}	
				else
				{								
					$errors = $otherService->getErrors();
					if(!empty($errors))
					{
						$error_string = "Please correct the following errors: <ul>";
						foreach ($errors as $error) {
							$error_string.= "<li>".$error[0]."</li>";
						}
						$error_string .= "</ul>";
					}
					Yii::app()->user->setFlash('error',$error_string);
				}
			}

			if(!$profilePoints->isServices)
			{
				$profilePoints->save(false);
			}
		}
		if(isset($_POST['Services']))
		{	
			$myOtherServices = $sp->otherservices;
			$myServices = $sp->services;			
			$spId = Miscellaneous::getSpId();
			$myServiceIds = new CList($sp->myServiceIds);				
			$services = $_POST['Services'];
			$connection = Yii::app()->db;			
			
			$command1 = $connection->createCommand("DELETE FROM {{providers_services}} WHERE serviceproviders_id = ".$spId);
			$command2 = $connection->createCommand("INSERT INTO {{providers_services}} (serviceproviders_id,services_id) VALUES (".$spId.", :sId)");
			
			
			foreach ($services as $service)
			{
				//remove unselected ids
				if($myServiceIds->contains($service['id']) && !$service['selected'])
				{
					$myServiceIds->remove($service['id']);
				}
				//add selected ones that have not yet been added
				if((!$myServiceIds->contains($service['id'])) && $service['selected'])
				{
					$myServiceIds->add($service['id']);
				}
			}
			
			if((count($myServiceIds)+count($myOtherServices))> Yii::app()->params["maxServices"])
			{
				Yii::app()->user->setFlash('error','You have exceeded the limit of services that can be added. You can replace a service by removing it (click on remove below) and then adding any other service you choose');				
			}
			else
			{
				Yii::app()->user->setFlash('success','New services have been successfully added!');
				$command1->execute();
				foreach ($myServiceIds as $sId)
				{
					$command2->bindParam(':sId', $sId);
					$command2->execute();
				}
				unset(Yii::app()->session['selectedCategory']);
				$this->redirect('index');				
			}
			if(!$profilePoints->isServices)
			{
				$profilePoints->save(false);
			}
				
				
		}
			
		
		
		$categories = CHtml::listData(Servicecategories::model()->findAll(), 'id', 'name');
		$this->render('update',array(
			'model'=>$model,
			'categories'=>$categories,
			'cat_id'=>$cat_id,
			
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{		
		if(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			$id = 0;
			if(isset($_GET['id']))
				$id = $_GET['id'];
			$connection = Yii::app()->db;
			$spId = Miscellaneous::getSpId();
			$command1 = $connection->createCommand("DELETE FROM {{providers_services}} WHERE serviceproviders_id = ".$spId." AND services_id = :sId");
			$command1->bindParam('sId', $id);
			$command1->execute();
			$this->redirect('index');
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionDeleteOtherServices()
	{		
		if(isset($_GET['id']) && is_numeric($_GET['id']))
		{
			$id = 0;
			if(isset($_GET['id']))
				$id = $_GET['id'];
			Otherservices::model()->findByPk($id)->delete();		
			
			$this->redirect('index');
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
		$services = $sp->services;
		$otherServices = $sp->otherservices;
		$this->render('index',array('services'=>$services,'otherServices'=>$otherServices));
	}

	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Services::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='services-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionGetServices($id)
	{		
		if(Yii::app()->user->checkAccess('sp-teammember')){
			Yii::app()->session['selectedCategory'] = $id;
			$myServiceIds = Miscellaneous::getServiceProvider()->myServiceIds;
			$category = Servicecategories::model()->findByPk($id);			
			$services = $category->services;	
			$this->renderPartial('_selectServices',array('services'=>$services,'myServiceIds'=>$myServiceIds,'category'=>$category->name));			
		}
		else
		{
			echo 'You are not authorized to carry out the requested action. Please log in';
		}
		
	}
	
}
