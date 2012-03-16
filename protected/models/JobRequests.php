<?php

/**
 * This is the model class for table "{{jobRequests}}".
 *
 * The followings are the available columns in table '{{jobRequests}}':
 * @property integer $id
 * @property integer $status
 * @property string $note
 * @property integer $serviceproviders_id
 * @property integer $jobs_id
 */
class JobRequests extends CActiveRecord
{
	const NOT_CONSIDERED = 0;
	const REJECTED = 1;	
	const ACCEPTED = 2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return JobRequests the static model class
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
		return '{{jobRequests}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id, jobs_id', 'required'),
			array('status, serviceproviders_id, jobs_id', 'numerical', 'integerOnly'=>true),
			array('note', 'length', 'max'=>1500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, note, serviceproviders_id, jobs_id', 'safe', 'on'=>'search'),
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
			'note' => 'Note',
			'serviceproviders_id' => 'Serviceproviders',
			'jobs_id' => 'Jobs',
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
		$criteria->compare('note',$this->note,true);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('jobs_id',$this->jobs_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}