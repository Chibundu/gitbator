<?php

/**
 * This is the model class for table "{{spOrder}}".
 *
 * The followings are the available columns in table '{{spOrder}}':
 * @property integer $id
 * @property double $amount
 * @property integer $status
 * @property integer $create_time
 * @property integer $lastModified
 * @property integer $serviceproviders_id
 * @property integer $currencies_id
 * @property double $qty
 * @property double $unit_price
 * @property string $handler
 */
class Order extends CActiveRecord
{
	const PENDING = 0;
	const CANCELLED = -1; 
	const CONFIRMED = 1;
	const PAID = 2;
	const DELIVERED = 3;	
	/**
	 * Returns the static model of the specified AR class.
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
			array('currencies_id', 'required'),
			array('status, create_time, lastModified, currencies_id', 'numerical', 'integerOnly'=>true),
			array('amount, $qty, $unit_price', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, handler, amount, status,qty, unit_price, create_time, lastModified, currencies_id', 'safe', 'on'=>'search'),
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
			'currencies_id' => 'Currencies',
			'qty'=>'Quantity',
			'unit_price'=>'Unit Price',
			'handler'=>'Handler',
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
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('lastModified',$this->lastModified);		
		$criteria->compare('currencies_id',$this->currencies_id);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('unit_price',$this->unit_price);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors()
	{
		return array(
			'timestamps'=>array(
				'class'=>'zii.behaviors.CTimestampBehavior',
				'createAttribute'=>'create_time',
				'updateAttribute'=>'lastModified',
				'setUpdateOnCreate'=>true,
			),
			'orderBehaviour'=>array(
				'class'=>'application.components.payment.behaviors.OrderBehavior'
			),
		);
	}
}