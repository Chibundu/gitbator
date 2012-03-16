<?php

/**
 * This is the model class for table "{{rate_type}}".
 *
 * The followings are the available columns in table '{{rate_type}}':
 * @property integer $id
 * @property string $rateType
 *
 * The followings are the available model relations:
 * @property OtherServicesRates[] $otherServicesRates
 * @property ServiceRates[] $serviceRates
 */
class RateType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RateType the static model class
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
		return '{{rate_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rateType', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rateType', 'safe', 'on'=>'search'),
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
			'otherServicesRates' => array(self::HAS_MANY, 'OtherServicesRates', 'rate_type_id'),
			'serviceRates' => array(self::HAS_MANY, 'ServiceRates', 'rate_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rateType' => 'Rate Type',
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
		$criteria->compare('rateType',$this->rateType,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}