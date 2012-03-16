<?php
/** 
 * Represents an activation request
 * @author Mbagwu Chibundu
 *
 */
	class ActivationReq extends CFormModel
	{
		public $req;		
		public $type;
		public $code;
		
		
		public function rules()
		{
			return array(
				array('req, type, code', 'required'),
				array('req', 'email'),				
				array('type','length', 'min'=>2, 'max'=>2),				
				array('code', 'authenticate'),
			);	
		}
		
		public function attributeLabels()
		{
			return array(
				'isAvailable'=>'',
				'isWorkOnWeekends'=>'',
			);
		}
		
		public function authenticate($attributes, $params)
		{			
			if($this->type == 'sp')
			{				
				
				$email = $this->req;
				$spAuth = SpAuth::model()->findByAttributes(array('username'=>$email));
				if($spAuth == NULL)
				{
					$this->addError('email', 'The specified account does not exist!');					
				}
				else
				{
					
					$t = $spAuth->teammember;
					
					if($t != NULL){
						
						$sp = $t->serviceProvider;
						$code = $this->code;
						$salt = $spAuth->salt;				
					 
						if($code != md5($salt.$sp->activationCode))				
						{
							$this->addError('code', 'The activation code supplied is wrong!');						
						}
						else
						{						
							if(!$sp->isActivated){
								$sp->isActivated = true;
								$verification = $sp->verification;
								$verification->email = true;
								$verification->save(false);
								$sp->save(false);
							}
							else
							{								
								Yii::app()->user->setFlash('block-message info', '<h3>Account Active</h3>Thank you! Your email has already been verified.');								
							}
						}
					}
					else
					{
						$this->addError('email', 'Email does not exist on our database!');
					}
				}
			}
			else 
			{
				$this->addError('type', 'Wrong Type');
			}
		}
		
		
		
		
	}
?>