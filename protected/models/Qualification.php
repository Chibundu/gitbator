<?php

/**
 * This is the model class for table "{{qualification}}".
 *
 * The followings are the available columns in table '{{qualification}}':
 * @property integer $id
 * @property string $qual
 * @property string $sfrom
 * @property string $sto
 * @property string $ref
 * @property string $institution
 * @property string $description 
 * @property integer $isVerified
 * @property integer $teammember_id
 * @property integer $serviceProviders_id
 * @property integer $qualificationCategory_id
 * @property integer $lastModified
 * @property integer $isVerificationRequestSent
 * @property integer $create_on
 * The followings are the available model relations:
 * @property Serviceproviders $serviceProviders
 * @property Qualificationcategory $qualificationCategory
 */
class Qualification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Qualification the static model class
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
		return '{{qualification}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceProviders_id, qualificationCategory_id,', 'required'),
			array('qualificationCategory_id, teammember_id, institution, qual, sto, ref','required','on'=>'create'),			
			array('qualificationCategory_id, teammember_id, institution, qual, sto, ref','required','on'=>'update'),
			array('isVerified, serviceProviders_id, qualificationCategory_id', 'numerical', 'integerOnly'=>true),
			array('qual, sfrom, sto', 'length', 'max'=>45),
			array('ref', 'length', 'max'=>128),
			array('description', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, qual, sfrom, sto, ref, institution, description, isVerified, teammember_id, serviceProviders_id, qualificationCategory_id', 'safe', 'on'=>'search'),
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
			'serviceProviders' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceProviders_id'),
			'qualificationCategory' => array(self::BELONGS_TO, 'Qualificationcategory', 'qualificationCategory_id'),
			'holder'=>array(self::BELONGS_TO, 'Teammembers', 'teammember_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'qual' => 'Qualification',
			'sfrom' => 'Year Commenced',
			'sto' => 'Year Awarded',
			'ref' => 'Reference Number',
			'teammember_id'=>'Qualification Holder',
			'institution'=>'Awarding Institution',
			'description' => 'Description',
			'isVerified' => 'Verified',			
			'serviceProviders_id' => 'Service Providers',
			'qualificationCategory_id' => 'Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('qual',$this->qual,true);
		$criteria->compare('sfrom',$this->sfrom,true);
		$criteria->compare('sto',$this->sto,true);
		$criteria->compare('ref',$this->ref,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('isVerified',$this->isVerified);
		$criteria->compare('serviceProviders_id',$this->serviceProviders_id);
		$criteria->compare('qualificationCategory_id',$this->qualificationCategory_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['PageSize'],
				'pageVar'=>'page',
			),
			'sort'=>array(
				'defaultOrder'=>'lastModified DESC',
				'sortVar'=>'sort',				
			),
		));
	}
	
	public function getQualHolders()
	{
		$teammembers  = Teammembers::model()->findAll();
		$qualHolders = array();
		foreach($teammembers as $teammember)
		{
			$qualHolders[$teammember->id] = $teammember->firstname. ' ' .$teammember->lastname;
		}
		return $qualHolders;
	}
	public function behaviors()
	{	
		return array(
			'timestamps'=>array(
				'class'=>'zii.behaviors.CTimestampBehavior',
				'createAttribute'=>'created_on',
				'updateAttribute'=>'lastModified',
				'setUpdateOnCreate'=>true,
		),
		);
	}
	public function getVerificationIcon()
	{
		if($this->isVerified)
		{
			return '<a href = "#" data-original-title="verified" rel="tooltip"><i class = "icon-ok"></i></a>';
		}
		else if($this->isVerificationRequestSent)
		{
			return '<a href = "#" data-original-title="pending" rel="tooltip"><i class = "icon-repeat"></i></a>';
		}
		else 
			return '<a href = "#" data-original-title="unverified" rel="tooltip"><i class = "icon-remove-sign"></i></a>';
	}
}