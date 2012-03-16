<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
		
	public function authenticate()
	{
		$user = Authdetails::model()->findByAttributes(array('username'=>$this->username));
					
		if($user === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;		
	
		else if(!$user->validatePassword($this->password))
				$this->errorCode=self::ERROR_PASSWORD_INVALID;		
		else
		{							
			$this->errorCode=self::ERROR_NONE;
			Miscellaneous::grantAccess($user);								 
		}
		return $this->errorCode==self::ERROR_NONE;
	}
	public function activate($code)
	{		 
		$user = Authdetails::model()->findByAttributes(array('username'=>$this->username,'activation_code'=>$code));		
				
		if($user !== null)
		{
			if($user->isActivated)
			{
				Yii::app()->user->setFlash('info','Your account is already active!');
			}
			else
			{
				$user->isActivated=true;
				$user->save(false);
				Yii::app()->user->setFlash('success','Welcome to the Vcubator. Your email has been verified.');
			}				
			$this->errorCode=self::ERROR_NONE;
			Miscellaneous::grantAccess($user);			
			
			$sp = Serviceproviders::model()->findByAttributes(array('email'=>$this->username));
			if($sp!==NULL){
				$verification = $sp->verification;
				$verification->email = true;
				$verification->save(false);
			}				
			
			return true;
		}	
		
		return false;
	}
	public function getId()
	{		
		return $this->username;		
	}
	
	
}