<?php

class PublicController extends Controller
{
	public $layout = 'profile';
	public function filters()
	{
		return array('accessControl');
	}
	public function accessRules()
	{		return array(			
			array('allow', 'roles'=>array('sp-teamleader','sp-teammember')),
			array('deny', 'users'=>array('*'))
		);
	}
	public function actionIndex($displayName)
	{	
		$displayName = urldecode($displayName);
		
		$sp = Serviceproviders::model()->findByAttributes(array('displayName'=>$displayName));
				
		$this->render('index', array('sp'=>$sp));
	}
	
		
	
}

?>