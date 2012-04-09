<?php

class SiteController extends Controller
{
	public $layout = 'main';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'foreColor'=>0XD0A113,		
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{		
		$this->layout = 'splash';
		
		$this->render('index');
	}
	public function actionRegister()	
	{	
		
		$reg = new RegForm();
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='reg-form')
		{
			echo CActiveForm::validate($reg);
			Yii::app()->end();
		}		
		
		if(isset($_POST['RegForm']))
		{				
			$reg->attributes = $_POST['RegForm'];
			if($reg->validate())
			{				
				$authManager = Yii::app()->authManager;
				$account_type = $reg->account_type;
				if($account_type == 'SPC' || $account_type == 'SPF'){										
					Yii::import('serviceproviders.models.*');
					$sp = new Serviceproviders();
					$sp->currency_id = 3;
					$sp->activationCode = $activation_code =  Miscellaneous::generateRandom(9);
					$sp->accountType = ($account_type == 'SPC')?'company':'freelancer';
					$sp->save(false);		
					$sp_id = $sp->id;	
						
					
					$role = new Roles();
					$role->username = $reg->email;
					$role->role = Roles::TeamLeader;
					$role->save(false);	
					
					$authManager->assign('sp-teamleader', $reg->email);			
					
					$tm = new Teammembers();
					$tm->firstname = $reg->firstname;
					$tm->lastname = $reg->lastname;
					$tm->email = $reg->email;
					$tm->phone = CountryUtility::$intl_code[$reg->country_code].$reg->phone;					
					$tm->isTeamLeader = true;					
					$tm->serviceproviders_id = $sp_id;
					$tm->save(false);				
					
					$spAuth = new SpAuth();
					$email = $reg->email;
					$spAuth->username = $email;
					$spAuth->password = $reg->password;
					$spAuth->encryptPassword();
					$salt = $spAuth->salt;					
					$spAuth->teammembers_id = $tm->id;							

					$address = new SpAddresses();
					$address->serviceProviders_id = $sp_id;
					$address->country = $reg->country;
					$address->save(false);
					
					$postal_address = new SpPostalAddresses();
					$postal_address->serviceproviders_id = $sp_id;
					$postal_address->country = $reg->country;
					$postal_address->save(false);
					
					$spAuth->save(false);
					
					$user = Yii::app()->user;
					Yii::app()->session['welcome']= "Welcome on the Vcubator. Please verify your email.";
					
					
					$this->sendActivationMail($email, $activation_code, $salt);
					
					$login =  new LoginForm();
					$login->username = $reg->email;
					$login->password = $reg->password;
					
					$user->returnUrl = Yii::app()->request->baseUrl.'/serviceproviders/profile';
					
					if($login->login()){
						$this->redirect($user->returnUrl);
					}			
					
				}
				else if($account_type == 'ET')
				{
					Yii::import('entrepreneurs.models.*');
					$user = new Users();
					$user->firstname = $reg->firstname;
					$user->lastname = $reg->lastname;
					$user->email = $reg->email;
					$user->phone = $reg->phone;
					$user->save(false);
					
					$address = new Addresses();
					$address->users_id = $user->id;
					$address->country = $reg->country;
					$address->save(false);
					
					$auth = new EtAuth();
					$auth->users_id = $user->id;
					$auth->username = $reg->email;
					$auth->password = $reg->password;
					$auth->encryptPassword();
					$auth->save(false);
					
					$role = new Roles();
					$role->username = $reg->email;
					$role->role = Roles::Enterpreneur;
					$role->save(false);
						
					$authManager->assign('entrepreneur', $reg->email);
					
					$login =  new LoginForm();
					$login->username = $reg->email;
					$login->password = $reg->password;
					
					Yii::app()->user->returnUrl = Yii::app()->baseUrl.'/entrepreneurs/';
					
					if($login->login()){
						$this->redirect(Yii::app()->user->returnUrl);
					}
					else
					{
						echo 'hee'; exit;
					}
				}			
									
			}
					
		}
		else
		{
			$location = Miscellaneous::getLocation();
						
			$country = $location['country'];			
			$country = array_search($country, CountryUtility::$countries);
						
			$reg->country = $country;
			if(isset(CountryUtility::$intl_code[$country]))
			{		
				$reg->country_code = $country;			
			}
		}		
		
		$this->render('register', array('model'=>$reg));
	}
	
	public function actionTest()
	{
		$array = CountryUtility::$intl_code;
		asort($array);
		foreach ($array as $key=>$value)
		{
			echo "'$key'=>'$value', <br>";
		}
	}
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}	
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**	 
	 * Sends the a mail containing a link for activation
	 * @param string $email
	 * @param string $password
	 * @param string $activation_code
	 * @param string $salt
	 */
	private function sendActivationMail($email, $activation_code, $salt)
	{
		$message = "Thank you for signing up on the Vcubator.<br /> To activate your account please, <a href=\"http://thevcubator.com/site/activate/?req=".$email."&type=sp&code=".md5($salt.$activation_code)."\">Click Here</a>
		.";
		if(YII_DEBUG === false)
		{
			$from = "registration@thevcubator.com";
 			$recipient = $email;
 			$subject = "Activation Code";
 			$mailheaders = "MIME-Version: 1.0\r\n";
 			$mailheaders .= "Content-type: text/html; charset=utf-8\r\n";
 			$mailheaders .= "From: $from\r\n";
			mail($recipient, $subject, $message, $mailheaders);			
		}		
		else
		{
			Yii::trace($message, "registration");		
		}
	}
	
	/**
	 * carries out the activation of an account
	 */
	public function actionActivate()
	{
		if(isset($_GET['req']) && isset($_GET['type']) && isset($_GET['code'])){
			
			$req = $_GET['req'];
			$type = $_GET['type'];
			$code = $_GET['code'];
			
			$activationReq = new ActivationReq();
			$activationReq->req = $req;
			$activationReq->type = $type;
			$activationReq->code = $code;
			
			$user = Yii::app()->user;
			if($activationReq->validate())
			{					
				$this->redirect(array('/serviceproviders/'));
			}
			else
			{
				$user->setFlash('block-message error', '<h2>Activation Error</h2>Sorry we cannot verify your email at this time!');
			}
			
			$this->render('activate');			
		}
		
	}

	
}