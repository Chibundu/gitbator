<?php

class DefaultController extends Controller
{
	public $layout = 'column1';
	
	public function accessRules()
	{
		return array(
				array(
						'allow',
						'actions'=>array('error'),
						'users'=>array('*'),
				),
				array(
						'allow',
						'roles'=>array('entrepreneur'),
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
		$this->render('index');
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
			else{				
				$this->render('error', $error);
			}
		}
	}
}