<?php

/**
 * This is the model class for table "{{payments}}".
 *
 * The followings are the available columns in table '{{payments}}':
 * @property integer $id
 * @property string $for
 * @property double $amount
 * @property string $meansOfPayment
 * @property integer $status
 * @property double $transaction_charge
 * @property string $url_stack
 * @property integer $currencies_id
 * @property string $payer
 * @property string $payee
 * @property integer $order_id
 * @property integer $created_on
 * @property integer $last_modified
 * @property string $callback
 *
 * The followings are the available model relations:
 * @property Currencies $currencies
 */
class Payments extends CActiveRecord
{
	const BEING_PROCESSED = 0;
	const COMPLETED = 1;
	const CANCELLED = -1;
	const FAILED = -2;
	const ERROR = -3;	
	
	public $type;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Payments the static model class
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
		return '{{payments}}';
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
			array('status, currencies_id, order_id, created_on, last_modified', 'numerical', 'integerOnly'=>true),
			array('amount, transaction_charge', 'numerical'),
			array('for', 'length', 'max'=>128),
			array('meansOfPayment', 'length', 'max'=>11),
			array('payer, payee', 'length', 'max'=>15),
			array('url_stack', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, for, amount, meansOfPayment, status, transaction_charge, url_stack, currencies_id, payer, payee, order_id, created_on, last_modified', 'safe', 'on'=>'search'),
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
			'currencies' => array(self::BELONGS_TO, 'Currencies', 'currencies_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'for' => 'For',
			'amount' => 'Amount',
			'meansOfPayment' => 'Means Of Payment',
			'status' => 'Status',
			'transaction_charge' => 'Transaction Charge',
			'url_stack' => 'Url Stack',
			'currencies_id' => 'Currencies',
			'payer' => 'Payer',
			'payee' => 'Payee',
			'order_id' => 'Order',
			'created_on' => 'Created On',
			'last_modified' => 'Last Modified',
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
		$criteria->compare('for',$this->for,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('meansOfPayment',$this->meansOfPayment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('transaction_charge',$this->transaction_charge);
		$criteria->compare('url_stack',$this->url_stack,true);
		$criteria->compare('currencies_id',$this->currencies_id);
		$criteria->compare('payer',$this->payer,true);
		$criteria->compare('payee',$this->payee,true);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('last_modified',$this->last_modified);

		return new CActiveDataProvider(get_class($this), array(
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