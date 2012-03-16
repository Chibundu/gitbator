<?php

/**
 * This is the model class for table "{{spMessages}}".
 *
 * The followings are the available columns in table '{{spMessages}}':
 * @property integer $id
 * @property string $status
 * @property string $type
 * @property string $message
 * @property integer $serviceproviders_id
 */
class SpMessages extends CActiveRecord
{
	//message types
	/**
	 * Inbox messages
	 * @var Integer
	 */
	const IN = 1;
	/**
	 * Sent messages
	 * @var Integer
	 */
	const OUT = 2;
	/**
	 * Messages that have been read 
	 * @var Integer
	 */
	//message status
	const UNREAD = 1;
	/**
	 * Ignored messages 
	 * @var Integer
	 */
	const READ = 2;
	/**
	 * Messages to be read 
	 * @var Integer
	 */
	
	const IGNORE = 3;
	/**
	 * Sent Message
	 * @var Integer
	 */
	const SENT = 4;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return SpMessages the static model class
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
		return '{{spMessages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id', 'required'),
			array('serviceproviders_id, status, type', 'numerical', 'integerOnly'=>true),			
			array('message', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, type, message, serviceproviders_id', 'safe', 'on'=>'search'),
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
			'status' => 'Status',
			'type' => 'Type',
			'message' => 'Message',
			'serviceproviders_id' => 'Serviceproviders',
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
		$criteria->compare('status',$this->status,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}