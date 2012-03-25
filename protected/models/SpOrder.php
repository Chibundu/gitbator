<?php

/**
 * This is the model class for table "{{spOrder}}".
 *
 * The followings are the available columns in table '{{spOrder}}':
 * @property integer $id
 * @property double $amount
 * @property integer $status
 * @property string $create_time
 * @property string $lastModified
 * @property integer $serviceproviders_id
 * @property integer $currencies_id
 * @property integer $qty
 * @property double $unit_price
 * @property string $handler
 * @property double $discount
 * @property string $description
 * @property string $item
 *
 * The followings are the available model relations:
 * @property Qualification[] $tblQualifications
 * @property Currencies $currencies
 * @property Serviceproviders $serviceprovider
 * @property SpPayments[] $spPayments
 * @property Verifications[] $tblVerifications
 */
class SpOrder extends CActiveRecord
{
	const PENDING = 1;
	const PAID = 2;
	const CANCELLED = 0;
	const FAILED = -1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpOrder the static model class
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
		return '{{spOrder}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, serviceproviders_id, currencies_id', 'required'),
			array('status, serviceproviders_id, currencies_id, qty', 'numerical', 'integerOnly'=>true),
			array('amount, unit_price, discount', 'numerical'),
			array('handler', 'length', 'max'=>128),
			array('description', 'length', 'max'=>256),
			array('item', 'length', 'max'=>45),
			array('lastModified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, amount, status, create_time, lastModified, serviceproviders_id, currencies_id, qty, unit_price, handler, discount, description, item', 'safe', 'on'=>'search'),
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
			'qualificationsWithOrders' => array(self::MANY_MANY, 'Qualification', '{{qualification_has_tbl_spOrder}}(spOrder_id, qualification_id)'),
			'currencies' => array(self::BELONGS_TO, 'Currencies', 'currencies_id'),
			'serviceprovider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
			'spPayments' => array(self::HAS_MANY, 'SpPayments', 'spOrder_id'),
			'verificationsWithOrders' => array(self::MANY_MANY, 'Verifications', '{{verifications_has_tbl_spOrder}}(spOrder_id, verifications_id)'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'status' => 'Status',
			'create_time' => 'Create Time',
			'lastModified' => 'Last Modified',
			'serviceproviders_id' => 'Serviceproviders',
			'currencies_id' => 'Currencies',
			'qty' => 'Qty',
			'unit_price' => 'Unit Price',
			'handler' => 'Handler',
			'discount' => 'Discount',
			'description' => 'Description',
			'item' => 'Item',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('lastModified',$this->lastModified,true);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('currencies_id',$this->currencies_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('handler',$this->handler,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('item',$this->item,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}