<?php

/**
 * This is the model class for table "{{verifications}}".
 *
 * The followings are the available columns in table '{{verifications}}':
 * @property integer $email
 * @property integer $phone
 * @property integer $identity
 * @property string $email_code
 * @property string $phone_code
 * @property boolean $isPhoneCodeSent
 * @property boolean $isIdentityRequestSent
 * @property integer $sentTimeForPhoneCode
 * @property integer $sentTimeForEmailCode
 * @property string $identity_code
 * @property string $nationality
 * @property boolean $isEmailCodeSent
 * @property integer $serviceproviders_id
 * @property CUploadedFile $passport_img
 * @property CUploadedFile $bills_img
 * @property CUploadedFile $cc_img
 * 
 * The followings are the available model relations:
 * @property Serviceproviders $serviceprovider
 */
class Verifications extends CActiveRecord
{
	const UNVERIFIED = 0;
	const VERIFIED = 1;

	
	/**
	 * @var supported image types
	 */
	public $imageTypes = 'jpg,png,gif'; 
	public $phone_code_entered;
	public $email_code_entered;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Verifications the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{verifications}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id', 'required'),
			array('email_code_entered','required','on'=>'verify_email'),
			array('phone_code_entered','required','on'=>'verify_phone'),			
			array('passport_img, bills_img, cc_img', 'file','maxSize'=>5242880,'types'=>$this->imageTypes, 'on'=>'verify_identity'),					
			array('nationality','length','max'=>'100'),				
			array('phone_code_entered', 'safe'),
			array('email, phone, identity, serviceproviders_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email, phone, identity, nationality, serviceproviders_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'serviceprovider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'phone' => 'Phone',
			'identity' => 'Identity',
			'identity_code'=>'Passport/Id Number',
			'serviceproviders_id' => 'Serviceproviders',
			'phone_code_entered'=>'Verification Code',
			'email_code_entered'=>'Verification Code',
			'passport_img'=>'Passport',
			'bills_img'=>'Bills',
			'cc_img'=>'Certificate of Incorporation',			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('email',$this->email);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('identity',$this->identity);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getVerifiedCount()
	{
		//check whether email, phone and identity are verified
		$sp = Miscellaneous::getServiceProvider();
		$verified = 0;
		if($this->email == Verifications::VERIFIED)
		{
			$verified++;
		}
		if($this->identity == Verifications::VERIFIED)
		{
			$verified++;
		}
		if($this->identity == Verifications::VERIFIED)
		{
			$verified++;
		}
		return $verified+=count($sp->verifiedQualifications);
	}
	
	public function getUnverifiedCount()
	{
		$unverified = 0;
		if($this->email == Verifications::UNVERIFIED)
		{
			$unverified++;
		}
		if($this->identity == Verifications::UNVERIFIED)
		{
			$unverified++;
		}
		if($this->identity == Verifications::UNVERIFIED)
		{
			$unverified++;
		}
		return ($unverified + Miscellaneous::getServiceProvider()->uqCount);	
	}
	
	public function getPendingCount()
	{
		if($this->identity == self::UNVERIFIED && $this->isIdentityRequestSent){
			return (Miscellaneous::getServiceProvider()->pqCount + 1);
		}
		else
		{
			return Miscellaneous::getServiceProvider()->pqCount;
		}
	}
	
	
}