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
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{		
		$username = $this->username;
		$role = NULL;
		$user = NULL;
		$role_model = Roles::model()->findByAttributes(array('username'=>$username));
		
		if($role_model != NULL)
		{			
			$role = $role_model->role;
			if($role == Roles::TeamLeader || $role == Roles::TeamMember)
			{
				$user = SpAuth::model()->with('teammember', 'teammember.serviceProvider')->findByAttributes(array('username'=>$username));
				
				if(($returnUrl = Yii::app()->user->returnUrl) == Yii::app()->request->baseUrl. '/index.php'){		
					Yii::app()->user->returnUrl = array('/serviceproviders');		
				}
			}
			else if($role == Roles::Enterpreneur)
			{
				
				$user = EtAuth::model()->with('users')->findByAttributes(array('username'=>$username));
				
				if(($returnUrl = Yii::app()->user->returnUrl) == Yii::app()->request->baseUrl. '/index.php'){				
					Yii::app()->user->returnUrl = array('/entrepreneurs');
				}
			}
		}
		 
		if($user == NULL)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->errorCode=self::ERROR_NONE;						
		}
		return !$this->errorCode;
	}
	
}