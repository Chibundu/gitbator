<?php

/**
 * This is the model class for table "{{proposalResponse}}".
 *
 * The followings are the available columns in table '{{proposalResponse}}':
 * @property integer $id
 * @property string $message
 * @property integer $status
 * @property string $sentTime
 * @property integer $proposal_id
 */
class ProposalResponse extends CActiveRecord
{
	const READ = 0;
	const UNREAD = 1;	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProposalResponse the static model class
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
		return '{{proposalResponse}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('proposal_id', 'required'),
			array('status, proposal_id', 'numerical', 'integerOnly'=>true),
			array('message', 'length', 'max'=>1500),
			array('sentTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, message, status, sentTime, proposal_id', 'safe', 'on'=>'search'),
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
			'message' => 'Message',
			'status' => 'Status',
			'sentTime' => 'Sent Time',
			'proposal_id' => 'Proposal',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('sentTime',$this->sentTime,true);
		$criteria->compare('proposal_id',$this->proposal_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}