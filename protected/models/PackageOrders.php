<?php

/**
 * This is the model class for table "{{package_orders}}".
 *
 * The followings are the available columns in table '{{package_orders}}':
 * @property integer $id
 * @property integer $status
 * @property string $requirements
 * @property integer $users_id
 * @property integer $serviceproviders_id
 * @property integer $orders_id
 * @property integer $start_count
 * @property integer $packages_id
 *
 * The followings are the available model relations:
 * @property EtOrders $order
 * @property Packages $package
 * @property Serviceproviders $serviceprovider
 * @property Users $entrepreneur
 */
class PackageOrders extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PackageOrders the static model class
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
		return '{{package_orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, serviceproviders_id, orders_id, packages_id', 'required'),
			array('status, users_id, serviceproviders_id, orders_id, start_count, packages_id', 'numerical', 'integerOnly'=>true),
			array('requirements', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, requirements, users_id, serviceproviders_id, orders_id, start_count, packages_id', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'EtOrders', 'orders_id'),
			'package' => array(self::BELONGS_TO, 'Packages', 'packages_id'),
			'serviceprovider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
			'entrepreneur' => array(self::BELONGS_TO, 'Users', 'users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => 'Status',
			'requirements' => 'Requirements',
			'users_id' => 'Users',
			'serviceproviders_id' => 'Serviceproviders',
			'orders_id' => 'Orders',
			'start_count' => 'Start Count',
			'packages_id' => 'Packages',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('requirements',$this->requirements,true);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('orders_id',$this->orders_id);
		$criteria->compare('start_count',$this->start_count);
		$criteria->compare('packages_id',$this->packages_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}