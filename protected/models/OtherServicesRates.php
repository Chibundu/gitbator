<?php

/**
 * This is the model class for table "{{other_services_rates}}".
 *
 * The followings are the available columns in table '{{other_services_rates}}':
 * @property integer $id
 * @property double $charge
 * @property double $discount
 * @property integer $otherservices_id
 * @property integer $rate_type_id
 *
 * The followings are the available model relations:
 * @property Otherservices $otherservices
 * @property RateType $rateType
 */
class OtherServicesRates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OtherServicesRates the static model class
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
		return '{{other_services_rates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('otherservices_id, rate_type_id', 'required'),
			array('otherservices_id, rate_type_id', 'numerical', 'integerOnly'=>true),
			array('charge, discount', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, charge, discount, otherservices_id, rate_type_id', 'safe', 'on'=>'search'),
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
			'otherservices' => array(self::BELONGS_TO, 'Otherservices', 'otherservices_id'),
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
			'otherservices_id' => 'Otherservices',
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
		$criteria->compare('otherservices_id',$this->otherservices_id);
		$criteria->compare('rate_type_id',$this->rate_type_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}