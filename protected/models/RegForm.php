<?php

class RegForm extends CFormModel {
	public $firstname;
	public $lastname;	
	public $email;
	public $phone;
	public $country;
	public $country_code;
	public $account_type;
	
	public $password;
	public $password_repeat;
	
	public function rules()
	{
		return array(
			array('firstname, lastname, email, password, phone, country_code, account_type', 'required'),
			array('firstname, lastname', 'match', 'pattern'=>'/^\w{2,20}$/'),
			//country must be a 2 letter code
			array('country, country_code, account_type', 'match', 'pattern'=>'/^\w{2,3}$/'),
			array('password', 'compare', 'compareAttribute'=>'password_repeat'),
			array('password', 'length', 'max'=>20),
			array('password_repeat', 'safe'),		
			array('email','email'),	
			array('email', 'isUnique'),		
		);
	}
	
/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'firstname'=>Yii::t('forms','First Name'),
			'lastname'=>Yii::t('forms','Surname'),
			'email'=>Yii::t('forms','E-mail'),
			'phone'=>'Mobile Phone',
			'country'=>Yii::t('forms','Country'),
			'country_code'=>Yii::t('forms','Int\'l calling code'),
			'account_type'=>Yii::t('forms', 'Account Type'),
			'password'=>Yii::t('forms', 'Password'),
			'password_repeat'=>Yii::t('forms', 'Repeat Password'),
		);
	}
	
	/**	 
	 * This returns the default account types
	 */
	public function getDefaultAcctTypes()
	{
		array('ent'=>'Entrepreneur','SPF'=>'Service Provider(Freelancer)', 'SPC'=>'Service Provider (Company)', 'mt'=>'Mentor', 'pt'=>'Partner');
	}
	
	public function isUnique($attribute, $params)
	{	
		if($this->account_type == 'SPC' || $this->account_type == 'SPF')
		{
			if(SpAuth::model()->exists('username=:email', array(':email'=>$this->email)))
			{				
				$this->addError('email', 'Sorry this email has already been registered as a Service Provider');					
			}				
		}
		
	}
	
		
}

?>