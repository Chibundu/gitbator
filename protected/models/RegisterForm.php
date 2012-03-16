<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegisterForm extends CFormModel
{		
	public $password;/** string, password */	
	public $firstname;/** string, firstname */
	public $lastname;/** string, lastname */
	public $postal_code; /** numerical, postalcode */
	public $email;/** string, brief email */
	public $mobile; /** int, mobile number */
	public $landline; /** int, landline */
	public $sex;/** string, male or female? */
	public $dob;/** date, date of birth */
	public $industry;/** string, industry */
	public $street;/** string, street */
	public $city;/** string, city */
	public $province;/** string, province */
	public $business_name;/** string, business name */
	public $website; /** string, website if any */
	public $business_description;/** string, brief business description */
	public $isBusinessRegistered;/** boolean, the funding required*/	
	public $hasAgreedToTerms; /** boolean, must agree to terms */
	
	

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('firstname, lastname, password, email, sex, dob, industry, street, city, province, business_name, isBusinessRegistered, hasAgreedToTerms','required'),	
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'isBusinessRegistered'=>'Is this business registered?',
			'dob'=>'Date of Birth',
			'business_name'=>'Name of Business',
			'hasAgreedToTerms'=>'I agree to these terms'
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function registerandauthenticate()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
