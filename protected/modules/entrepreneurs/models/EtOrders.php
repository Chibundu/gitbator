<?php

/**
 * This is the model class for table "{{etOrders}}".
 *
 * The followings are the available columns in table '{{etOrders}}':
 * @property integer $id
 * @property double $amount
 * @property integer $status
 * @property string $create_time
 * @property string $lastModified
 * @property integer $qty
 * @property double $unit_price
 * @property string $handler
 * @property double $discount
 * @property string $description
 * @property string $item
 * @property integer $users_id
 * @property integer $currencies_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Currencies $currencies
 */
class EtOrders extends CActiveRecord
{
	const PENDING = 1;
	const PAID = 2;
	const FULFILLED = 3;
	const CANCELLED = 0;
	const FAILED = -1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EtOrders the static model class
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
		return '{{etOrders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, currencies_id', 'required'),
			array('status, qty, users_id, currencies_id', 'numerical', 'integerOnly'=>true),
			array('amount, unit_price, discount', 'numerical'),
			array('description', 'length', 'max'=>256),
			array('item', 'length', 'max'=>45),
			array('create_time, lastModified, handler', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, amount, status, create_time, lastModified, qty, unit_price, handler, discount, description, item, users_id, currencies_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'users_id'),
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
			'status' => 'Status',
			'create_time' => 'Create Time',
			'lastModified' => 'Last Modified',
			'qty' => 'Qty',
			'unit_price' => 'Unit Price',
			'handler' => 'Handler',
			'discount' => 'Discount',
			'description' => 'Description',
			'item' => 'Item',
			'users_id' => 'Users',
			'currencies_id' => 'Currencies',
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
		$criteria->compare('qty',$this->qty);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('handler',$this->handler,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('currencies_id',$this->currencies_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors()
	{
		return array(
					'timestamps'=>array(
								'class'=>'zii.behaviors.CTimestampBehavior',
								'updateAttribute'=>'lastModified',
								'createAttribute'=>'create_time',
								'setUpdateOnCreate'=>true,
							),
				);
	}
}