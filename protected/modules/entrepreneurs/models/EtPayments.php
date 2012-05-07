<?php

/**
 * This is the model class for table "{{etPayments}}".
 *
 * The followings are the available columns in table '{{etPayments}}':
 * @property integer $id
 * @property double $amount
 * @property integer $created_on
 * @property integer $last_modified
 * @property integer $status
 * @property string $gateway_status
 * @property integer $method
 * @property integer $etOrders_id
 *
 * The followings are the available model relations:
 * @property EtOrders $etOrders
 */
class EtPayments extends CActiveRecord
{
	const PURSE = 1;
	const PAYPAL = 2;
	const PAYFAST = 3;
	
	const PENDING = 1;
	const PAID = 2;
	const FAILED = -1;
	const CANCELED = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EtPayments the static model class
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
		return '{{etPayments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('etOrders_id', 'required'),
			array('created_on, last_modified, status, method, etOrders_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('gateway_status', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, amount, created_on, last_modified, status, gateway_status, method, etOrders_id', 'safe', 'on'=>'search'),
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
			'etOrders' => array(self::BELONGS_TO, 'EtOrders', 'etOrders_id'),
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
			'created_on' => 'Created On',
			'last_modified' => 'Last Modified',
			'status' => 'Status',
			'gateway_status' => 'Gateway Status',
			'method' => 'Method',
			'etOrders_id' => 'Et Orders',
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
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('last_modified',$this->last_modified);
		$criteria->compare('status',$this->status);
		$criteria->compare('gateway_status',$this->gateway_status,true);
		$criteria->compare('method',$this->method);
		$criteria->compare('etOrders_id',$this->etOrders_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors()
	{
		return array(
				'timestamps'=>array(
						'class'=>'zii.behaviors.CTimestampBehavior',
						'createAttribute'=>'created_on',
						'updateAttribute'=>'last_modified',
						'setUpdateOnCreate'=>true,
						),
		);
	}
}