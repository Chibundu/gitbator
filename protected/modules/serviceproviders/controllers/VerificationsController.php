<?php
class VerificationsController extends Controller
{	
	public $layout = 'profile';
	public function filters()
	{		
		return array(
			'accessControl',		
		);
	}	
	
	
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
	public function actions()
	{
		return array(
			'confirm'=>array(
				'class'=>'application.components.payment.actions.Confirm',
				'controller'=>$this,				
				'actionType'=>'typeA',							
			),
			'cancel'=>array(
				'class'=>'application.components.payment.actions.Cancel',										
			),
		);
	}
	
	
	public function actionIndex($page=1)
	{		
		$page_size = Yii::app()->params['PageSize'];
		
		$sp = Miscellaneous::getServiceProvider();	
		
		$count = $sp->verificationCount;
		$verifications = $sp->verifications;
		
					
		$pages = new CPagination(count($sp->qualifications) + 3);	
							
			
		$pages->setPageSize($page_size);
		
		if($page == 1){
			$qual = $sp->qualifications(array('limit'=>($page_size - 3)));
		}
		else
		{
			$qual = $sp->qualifications(array('limit'=>($page_size), 'offset'=>($pages->offset - 3)));
		}	

	

		$this->render('index', array(			
			'pages'=>$pages,		
			'count'=>$count,
			'verifications'=>$verifications,
			'qual'=>$qual,			
			'page'=>$page
		));
	}
	
	public function actionIdentity()
	{
		$sp = Miscellaneous::getServiceProvider();	
		$verification = $sp->verification;		
		
		$verification->setScenario('verify_identity');
		if(isset($_POST['Verifications']))
		{	
			if(isset($_FILES['Verifications']['name']['cc_img'])){				
				if($verification->cc_img)
				{																		
					@unlink(Miscellaneous::getIdentityDocsPath().$verification->cc_img);	
				}				
				$_FILES['Verifications']['name']['cc_img'] = $sp->prefixedId.'_'.'cc_'.$_FILES['Verifications']['name']['cc_img'];				
			}		
			if(isset($_FILES['Verifications']['name']['passport_img'])){
				if($verification->passport_img)
				{
					@unlink(Miscellaneous::getIdentityDocsPath().$verification->passport_img);
				}
				$_FILES['Verifications']['name']['passport_img'] = $sp->prefixedId.'_'.'passports_'.$_FILES['Verifications']['name']['passport_img'];				
			}
			
			if(isset($_FILES['Verifications']['name']['bills_img'])){
				if($verification->bills_img)
				{
					@unlink(Miscellaneous::getIdentityDocsPath().$verification->bills_img);
				}
				$_FILES['Verifications']['name']['bills_img'] = $sp->prefixedId.'_'.'bills_'.$_FILES['Verifications']['name']['bills_img'];					
			}	
											
			$verification->attributes = $_POST['Verifications'];		
			
			if(isset($_FILES['Verifications']['name']['passport_img'])){		
					$verification->passport_img = CUploadedFile::getInstance($verification, 'passport_img');
			}
			if(isset($_FILES['Verifications']['name']['cc_img'])){
				$verification->cc_img = CUploadedFile::getInstance($verification, 'cc_img');
			}
			if(isset($_FILES['Verifications']['name']['bills_img'])){
				$verification->bills_img = CUploadedFile::getInstance($verification, 'bills_img');
			}
			
			
			if($verification->save())
			{				
				$verification->cc_img->saveAs(Miscellaneous::getIdentityDocsPath().$verification->cc_img->name);
				$verification->passport_img->saveAs(Miscellaneous::getIdentityDocsPath().$verification->passport_img->name);
				$verification->bills_img->saveAs(Miscellaneous::getIdentityDocsPath().$verification->bills_img->name);	
				
				
				$verification->isIdentityRequestSent = true;
								
				$order = new SpOrder();					
				$order->currencies_id = Yii::app()->params['identity_verification']['currency'];				
				$order->serviceproviders_id = $sp->id;
				$order->qty = 1;
				$order->unit_price = Yii::app()->params['identity_verification']['amount'];
				
				$order->amount = $order->qty * $order->unit_price;
				$order->handler = 'OrderHandlers::identityVerification';
					
				$order->save(false);			
				$spOrderId = $order->id;			
				$vId = $verification->serviceproviders_id;
				$table = '{{verifications_has_tbl_spOrder}}';
				
				$payment = new Payments();
				$payment->amount = $order->amount;
				$payment->currencies_id = $order->currencies_id;
				$payment->payer = $sp->prefixedId;	
				$payment->for = "Identity Verification";
				$payment->order_id = $spOrderId;
				$payment->url_stack = '/serviceproviders/verifications/index';					
				
				if(!Miscellaneous::exists('spOrder_id', 'spOrder_id=:spOrderId', array(':spOrderId'=>$spOrderId), $table))
				{
					Miscellaneous::executeInsert(array('spOrder_id'=>$spOrderId, 'verifications_id'=>$vId), $table);
				}
				
				$pt = Yii::app()->paymentTransaction;
				$event = new PaymentEvent($payment);
				$event->url_stack = $this->createUrl('serviceproviders/verifications/identity');
				$event->controller = $this;
				$event->callback = 'confirm';
				
				//trigger a payment transaction
				$pt->create($event);								
			}				
		}
		
		$this->render('verifyIdentity', array('sp'=>$sp, 'verification'=>$verification));
	}
	
	public function actionSendSMS()
	{
		$sp = Miscellaneous::getServiceProvider();
		$mobile = $sp->teamLeader->phone;
		$verification = $sp->verification;
		$timing = '';
		if($verification->sentTimeForPhoneCode!=NULL)
		{
			$timing = 'on '.date('d F,Y H:i');
			
		}
		if(!$verification->isPhoneCodeSent){					
			
			$verification->phone_code = $phone_code = Miscellaneous::generateRandom(6);
			if($this->sendSMS($mobile, "Your verification code is: $phone_code")){
				$verification->isPhoneCodeSent = true;
				$verification->sentTimeForPhoneCode = time();
				echo "We have sent an SMS containing a verification code to $mobile. If you have received it, please enter into the box below.";
			}
			else{
				echo 'It appears that this mobile number is incorrect as we are not able to send the SMS at the moment.';
			}
			$verification->save(false);				
			
		}
		else
		{
			echo "We have already sent a verification code to $mobile $timing";
		}	
	}
	
	public function actionSendEmail()
	{
		$sp = Miscellaneous::getServiceProvider();
		$email = $sp->teamLeader->email;
		$verification = $sp->verification;
		$timing = '';
		if($verification->sentTimeForEmailCode!=NULL)
		{
			$timing = 'on '.date('d F,Y H:i');
			
		}
		if(!$verification->isEmailCodeSent){					
			
			$verification->email_code = $email_code = Miscellaneous::generateRandom(9);
			if($this->sendEmail($email,$email_code)){
				$verification->isEmailCodeSent = true;
				$verification->sentTimeForEmailCode = time();
				echo 'We have sent an Email containing a verification code to $email. If you have received it, please enter into the box below!';
			}
			else
			{
				echo 'It appears that the email address is incorrect as we are unable to send the verification code to it';
			}
			
			$verification->save(false);				
			
		}
		else
		{
			echo "We have already sent a verification code to $email $timing";
		}	
	}
	
	public function actionEmail()
	{
		$sp = Miscellaneous::getServiceProvider();
		$email = $sp->teamLeader->email;
		$verification = $sp->verification;
		$verification->setScenario('verify_email');	
		
		if(isset($_POST['Verifications']))
		{			
			$verification->attributes = $_POST['Verifications'];
			if($verification->validate())
			{
				if($verification->email_code == $verification->email_code_entered)
				{
					$verification->email = true;
					$verification->save(false);
					$auth = Authdetails::model()->findByAttributes(array('username'=>email));
					if($auth != NULL){
						$auth->isActivated = true;
						$auth->save(false);
					}
					Yii::app()->user->setFlash('success', $email.' has been successfully verified!');
					$this->redirect('index');
				}
				else
				{
					Yii::app()->user->setFlash('error', 'The verification code entered is wrong');
				}
			}
		}
		
		$this->render('verifyEmail', array('verification'=>$verification,'email'=>$email));
	}
	
	/**	 
	 * orchestrates verification of Teamleader's primary phone number
	 */
	public function actionMobile()
	{
		$sp = Miscellaneous::getServiceProvider();
		$mobile_num = $sp->teamLeader->phone;
		$verification = $sp->verification;
		$verification->setScenario('verify_phone');		
		if(isset($_POST['Verifications']))
		{			
			$verification->attributes = $_POST['Verifications'];
			if($verification->validate())
			{
				if($verification->phone_code == $verification->phone_code_entered)
				{
					$verification->phone = true;
					$verification->save(false);
					Yii::app()->user->setFlash('success', $mobile_num.' has been successfully verified!');
					$this->redirect('index');
				}
				else
				{
					Yii::app()->user->setFlash('error', 'The verification code entered is wrong');
				}
			}
		}
		
		$this->render('verifyMobile', array('verification'=>$verification,'mobile_num'=>$mobile_num));
	}
	
	public function actionQualification($id)
	{		
		$qual = Qualification::model()->findByPk($id);
		
		if($qual==null)
		{
			throw new CHttpException(404,'Please do not repeat this request again!');
		}
	
		
		if(isset($_POST['submit']))
		{
		
			$qual->isVerificationRequestSent = true;
			$qual->save(false);
			Yii::app()->user->setFlash('success', 'Your verification request for '. $qual->qual.' was successfully sent!');
			$this->redirect(array('index'));
		}
		$this->render('verifyQualification', array('qual'=>$qual));
	}
	
	
	private function sendSMS($gsm, $messagetext)
	{
		$username = Yii::app()->params['clickatell_username'];
		$password = Yii::app()->params['clickatell_password'];		
		$api_id = Yii::app()->params['clickatell_api_id'];		
		$clickatell = new Clickatell($username, $password, $api_id);
		$response = $clickatell->sendSingleSMS($gsm, $messagetext);
		return $response;	
	}
	
	private function sendEmail($email, $activation_code)
	{
		$message = "To verify your email account, please <a href=http://thevcubator.com/site/activate/?req=".$email."&type=sp&code=".md5($salt.$activation_code).">click here</a>";
		
	 	$from = "registration@thevcubator.com";
 		$recipient = $email;
 		$subject = "Activation Code";
 		$mailheaders = "MIME-Version: 1.0\r\n";
 		$mailheaders .= "Content-type: text/html; charset=utf-8\r\n";
 		$mailheaders .= "From: $from\r\n";
		if(mail($recipient, $subject, $message, $mailheaders))
		{
			return true;
		}
		return false;
		
	}

}