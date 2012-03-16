<?php

class SettingsController extends Controller
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
	
	public function actionCosting()
	{
		$this->render('costing');
	}

	public function actionCurrency()
	{
		$sp = Miscellaneous::getServiceProvider();		
		
		if(isset($_POST['Serviceproviders']))
		{	
			$sp->attributes = $_POST['Serviceproviders'];
			if($sp->validate(array('currency_id')))
			{
				if($sp->save(false))
				{
					Yii::app()->user->setFlash('success','Currency Setting was successfully updated');
				}
				else
				{
					Yii::app()->user->setFlash('error','Currency Setting could not be updated at this time');
				}
			}
			else
			{
				Yii::app()->user->setFlash('error','Currency Setting could not be updated at this time');
			}	
			
		}		
		
		
		$this->render('currency', array('model'=>$sp));
	}
	public function actionTest()
	{
		$s = '07';
		echo (int)$s;
		
	}
	public function actionOverview()
	{
		$sp = Miscellaneous::getServiceProvider();
		$c= $sp->currency;
		$timezone = $sp->formattedTimeZone;
		$currency = $c->code.' (<i>'.$c->literal.'</i>)';
		$this->render('index', array('currency'=>$currency, 'timezone'=>$timezone));
	}

	public function actionTimezone()
	{
		$sp = Miscellaneous::getServiceProvider();
		if(isset($_POST['Serviceproviders']))
		{
			$sp->attributes = $_POST['Serviceproviders'];
			if($sp->validate(array('timeZone')))
			{
				if($sp->save(false))
				{					
					Yii::app()->user->setFlash('success','Time Zone Setting was successfully updated');
				}
				else
				{
					Yii::app()->user->setFlash('error','Time Zone Setting could not be updated at this time');
				}
			}
			else
			{
				Yii::app()->user->setFlash('error','Time Zone Setting could not be updated at this time');
			}			
		}
		$this->render('timezone', array('model'=>$sp));
	}
	public function actionAvailability()
	{
		$sp = Miscellaneous::getServiceProvider();
		$availabilities = $sp->availabilities;
		$model = new AvailabilityForm();
		
		if(isset($_POST['Availability']))
		{	
			$overwrite = false;
			if(isset($_POST['isAvailable']))
			{
				if($_POST['isAvailable'] != 'Yes')
				{
					$overwrite = true;
				}
			}		
			$valid = true;
			$error_message = 'Some settings could not be saved. The Following errors occured:<br><ul>';			
			foreach ($availabilities as $i=>$availability)
			{
				if(isset($_POST['Availability'][$i]))
				{
					$availability->attributes = $_POST['Availability'][$i];							
				}
				
				if(!$availability->validate())
				{
					$valid = false;
					$errors = $availability->errors;
					foreach ($errors as $attribute=>$message)
					{
						foreach ($message as $m)
							$error_message.="<li>$availability->dayLiteral: $m</li>";
					}					
				}
				else
				{
					if($overwrite)
						$availability->isAvailable = false;
					$availability->save(false);
				}
			}
			if(!$valid)
			{
				Yii::app()->user->setFlash('block-message error', $error_message);
			}
			else
			{
				Yii::app()->user->setFlash('block-message success', 'You have successfully updated your availability settings');
			}			
		}
		
		foreach ($availabilities as $availability)
		{
			if($availability->isAvailable)
			{
				$model->isAvailable = true;
				break;
			}
		}
		
		
		$this->render('availability', array('availabilities'=>$availabilities, 'model'=>$model));
	}

	public function actionPayment()
	{
		$sp = Miscellaneous::getServiceProvider();
		$myServices = $sp->services;
		$myOtherServices = $sp->otherservices;
		$this->render('payment', array('myServices'=>$myServices, 'myOtherServices'=>$myOtherServices));
	}
	
	public function actionSetPricing()
	{
		if(isset($_POST['id'])){
			$id = $_POST['id'];
			$service = Services::model()->findByAttributes(array('id'=>$id));
			$pf = new paymentSettingsForm();
			$pf->service_id = $id;
			$pf->serviceprovider_id = Miscellaneous::getSpId();
				
		}
		else 
			throw new CHttpException(403, 'You are not authorized to carry out this action! Please do not repeat this request again.');
		
		$this->render('setPricing', array('service'=>$service,'pf'=>$pf));
		
	}
	
	/*public function actionGetPaymentTypeForm($type, $form)
	{
		if(isset($_POST['type']) && isset($_POST['form']))
		{
			$type = $_POST['type'];
			$form = CJSON::decode($_POST['form'], false);
			echo $form; exit;
		}
		else
		{
			throw  new CHttpException(403,'Forbidden');
		}
		if($type==1 && $form!=null)
		{
			
			echo CHtml::activeTextField($pf, 'value');
			echo CHtml::activeTextField($model, 'discount');
			echo CHtml::submitButton('Set', array('class'=>'primary btn'));
		}
	}*/
	
}