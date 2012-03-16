<?php

/**
 * This is the model class for table "{{profile_pts}}".
 *
 * The followings are the available columns in table '{{profile_pts}}':
 * @property integer $isAddress
 * @property integer $isPortfolio
 * @property integer $isQualification
 * @property integer $isServices
 * @property integer $isCompanyDetails
 * @property integer $isOtherInfo
 * @property integer $isProfilePic
 * @property integer $serviceproviders_id
 *
 * The followings are the available model relations:
 * @property Serviceproviders $serviceproviders
 */
class ProfilePts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilePts the static model class
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
		return '{{profile_pts}}';
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
			array('isAddress, isPortfolio, isProfilePic, isQualification, isServices, isCompanyDetails, isOtherInfo, serviceproviders_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('isAddress,isProfilePic, isPortfolio, isQualification, isServices, isCompanyDetails, isOtherInfo, serviceproviders_id', 'safe', 'on'=>'search'),
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
			'serviceproviders' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'isAddress' => 'Is Address',
			'isPortfolio' => 'Is Portfolio',
			'isQualification' => 'Is Qualification',
			'isServices' => 'Is Services',
			'isCompanyDetails' => 'Is Company Details',
			'isOtherInfo' => 'Is Other Info',
			'isProfilePic' => 'Is Profile Picture',
			'serviceproviders_id' => 'Serviceproviders',
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

		$criteria->compare('isAddress',$this->isAddress);
		$criteria->compare('isPortfolio',$this->isPortfolio);
		$criteria->compare('isQualification',$this->isQualification);
		$criteria->compare('isServices',$this->isServices);
		$criteria->compare('isCompanyDetails',$this->isCompanyDetails);
		$criteria->compare('isOtherInfo',$this->isOtherInfo);
		$criteria->compare('isProfilePic',$this->isProfilePic);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}