<?php

class PaymentController extends Controller
{
	public $layout = 'column1';
	
	public function accessRules()
	{
		return array(
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
	
	public function actionLoadVPurse()
	{
		$this->render('loadVPurse');
	}
	// Uncomment the following methods and override them if needed

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',			
		);
	}
/**
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}