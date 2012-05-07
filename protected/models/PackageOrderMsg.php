<?php

/**
 * This is the model class for table "{{package_order_msg}}".
 *
 * The followings are the available columns in table '{{package_order_msg}}':
 * @property integer $id
 * @property string $message
 * @property integer $create_time
 * @property integer $last_modified
 * @property integer $type
 * @property string $associated_resource
 * @property integer $etOrders_id
 *
 * The followings are the available model relations:
 * @property EtOrders $order
 */
class PackageOrderMsg extends CActiveRecord
{
	const REQUIREMENT = 1;
	const NORMAL = 2;
	const RESPONSE = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PackageOrderMsg the static model class
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
		return '{{package_order_msg}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message', 'required'),
			array('create_time, last_modified, type, etOrders_id', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'min'=>2, 'max'=>512),
			array('associated_resource', 'file', 'types'=>'jpg,gif,png,pdf,doc,docx,xls,xlsx, zip', 'on'=>'upload', 'tooLarge'=>'The file you are trying to upload is to large. Consider zipping it. Max size allowed is {limit}', 'wrongType'=>'We only allow the following file types (extensions): {extensions}'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, message, create_time, last_modified, type, associated_resource, etOrders_id', 'safe', 'on'=>'search'),
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
			'order' => array(self::BELONGS_TO, 'EtOrders', 'etOrders_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message' => 'Message',
			'create_time' => 'Create Time',
			'last_modified' => 'Last Modified',
			'type' => 'Type',
			'associated_resource' => 'Associated Resource',
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
		$criteria->compare('message',$this->message,true);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('last_modified',$this->last_modified);
		$criteria->compare('type',$this->type);
		$criteria->compare('associated_resource',$this->associated_resource,true);
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
						'createAttribute'=>'create_time',
						'updateAttribute'=>'last_modified',
						'setUpdateOnCreate'=>true,
				),
		);
	}
}