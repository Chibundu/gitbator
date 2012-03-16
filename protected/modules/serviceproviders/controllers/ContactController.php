<?php

class ContactController extends Controller
{
	
	public $layout = 'profile';
	
	public function actionIndex()
	{
		$address = SpAddresses::model()->findByAttributes(array('serviceProviders_id'=>Miscellaneous::getSpId()));
		$postal_address = SpPostalAddresses::model()->findByAttributes(array('serviceproviders_id'=>Miscellaneous::getSpId()));
				
		$this->render('address', array('address'=>$address, 'postal_address'=>$postal_address));
	}
	public function actionEditAddress()
	{			
		$sp = Miscellaneous::getServiceProvider();
		$address = SpAddresses::model()->findByAttributes(array('serviceProviders_id'=>$sp->id));
				
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate(array($address));
			Yii::app()->end();
		}
		if(isset($_POST['SpAddresses']))
		{			
			$address->attributes = $_POST['SpAddresses'];			
			if($address->save())
			{
				$profilePoints = $sp->profilePoints;
				if(!$profilePoints->isAddress)
				{
					$profilePoints->isAddress = true;
					$profilePoints->save(false);
				}
				Yii::app()->user->setFlash('success','Physical address was successfully updated');
				$this->redirect(array('contact/'));
			}
			else
			{				
				Yii::app()->user->setFlash('error', 'Address was not updated! See error below.');
			}
		}
		$this->render('editaddress', array('model'=>$address));
	}
	public function actionEditPostalAddress()
	{
		$postal_address = SpPostalAddresses::model()->findByAttributes(array('serviceproviders_id'=>Miscellaneous::getSpId()));
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate(array($postal_address));
			Yii::app()->end();
		}
		if(isset($_POST['SpPostalAddresses']))
		{			
			$postal_address->attributes = $_POST['SpPostalAddresses'];
			if($postal_address->save())
			{				
				Yii::app()->user->setFlash('success','Postal address was successfully updated');
				$this->redirect(array('contact/'));
			}
			else
			{
				Yii::app()->user->setFlash('error', 'Postal address was not updated! See error below.');
			}
		}
		$this->render('editpostaladdress', array('postal_address'=>$postal_address));
	}
	
	public function filters()
	{
		return array('accessControl');
	}
	public function accessRules()
	{
		return array(
			array('allow', 'roles'=>array('sp-teamleader','sp-teammember')),
			array('deny', 'users'=>array('*'))
		);
	}	
	

	
}