<?php

/**
 * This is the model class for table "{{otherservices}}".
 *
 * The followings are the available columns in table '{{otherservices}}':
 * @property integer $id
 * @property string $services
 * @property string $description
 * @property integer $serviceproviders_id
 * @property integer $servicecategories_id
 *
 * The followings are the available model relations:
 * @property OtherServicesRates[] $otherServicesRates
 * @property Serviceproviders $serviceproviders
 * @property Servicecategories $servicecategories
 */
class Otherservices extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Otherservices the static model class
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
		return '{{otherservices}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id, servicecategories_id', 'required'),
			array('serviceproviders_id, servicecategories_id', 'numerical', 'integerOnly'=>true),
			array('services', 'length', 'max'=>128),
			array('description', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, services, description, serviceproviders_id, servicecategories_id', 'safe', 'on'=>'search'),
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
			'otherServicesRates' => array(self::HAS_MANY, 'OtherServicesRates', 'otherservices_id'),
			'serviceproviders' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
			'servicecategories' => array(self::BELONGS_TO, 'Servicecategories', 'servicecategories_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'services' => 'Services',
			'description' => 'Description',
			'serviceproviders_id' => 'Serviceproviders',
			'servicecategories_id' => 'Servicecategories',
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
		$criteria->compare('services',$this->services,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('servicecategories_id',$this->servicecategories_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}