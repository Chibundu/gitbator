<?php

/**
 * This is the model class for table "{{service_rates}}".
 *
 * The followings are the available columns in table '{{service_rates}}':
 * @property integer $id
 * @property double $charge
 * @property double $discount
 * @property integer $serviceproviders_id
 * @property integer $rate_type_id
 *
 * The followings are the available model relations:
 * @property Serviceproviders $serviceproviders
 * @property RateType $rateType
 */
class ServiceRates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ServiceRates the static model class
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
		return '{{service_rates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id, rate_type_id', 'required'),
			array('serviceproviders_id, rate_type_id', 'numerical', 'integerOnly'=>true),
			array('charge, discount', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, charge, discount, serviceproviders_id, rate_type_id', 'safe', 'on'=>'search'),
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
			'rateType' => array(self::BELONGS_TO, 'RateType', 'rate_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'charge' => 'Charge',
			'discount' => 'Discount',
			'serviceproviders_id' => 'Serviceproviders',
			'rate_type_id' => 'Rate Type',
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
		$criteria->compare('charge',$this->charge);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('rate_type_id',$this->rate_type_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}