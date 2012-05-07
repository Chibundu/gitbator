<?php

/**
 * This is the model class for table "{{escrows}}".
 *
 * The followings are the available columns in table '{{escrows}}':
 * @property integer $id
 * @property double $amount
 * @property string $meansOfPayment
 * @property integer $status
 * @property double $transaction_charge
 * @property integer $currencies_id
 * @property string $payer
 * @property string $payee
 * @property integer $created_on
 * @property integer $last_modified
 *
 * The followings are the available model relations:
 * @property Currencies $currencies
 */
class Escrows extends CActiveRecord
{
	const RETURNED = -1;
	const UNRELEASED = 0;
	const RELEASED = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Escrows the static model class
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
		return '{{escrows}}';
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
			array('status, currencies_id, created_on, last_modified', 'numerical', 'integerOnly'=>true),
			array('amount, transaction_charge', 'numerical'),
			array('meansOfPayment', 'length', 'max'=>20),
			array('payer, payee', 'length', 'max'=>15),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, amount, meansOfPayment, status, transaction_charge, currencies_id, payer, payee, created_on, last_modified', 'safe', 'on'=>'search'),
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
			'amount' => 'Amount',
			'meansOfPayment' => 'Means Of Payment',
			'status' => 'Status',
			'transaction_charge' => 'Transaction Charge',
			'currencies_id' => 'Currencies',
			'payer' => 'Payer',
			'payee' => 'Payee',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('meansOfPayment',$this->meansOfPayment,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('transaction_charge',$this->transaction_charge);
		$criteria->compare('currencies_id',$this->currencies_id);
		$criteria->compare('payer',$this->payer,true);
		$criteria->compare('payee',$this->payee,true);
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('last_modified',$this->last_modified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors()
	{
		return array(
 		 		'CTimestampBehavior' => array(
  				'class' => 'zii.behaviors.CTimestampBehavior',
  				'createAttribute' => 'created_on',
  				'updateAttribute' => 'last_modified',
  			)
		);
	}
}