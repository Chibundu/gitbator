<?php

/**
 * This is the model class for table "{{proposals}}".
 *
 * The followings are the available columns in table '{{proposals}}':
 * @property string $cost
 * @property string $cost_type
 * @property string $duration
 * @property string $duration_type
 * @property string $startDate
 * @property string $resource
 * @property string $note
 * @property integer $jobRequests_id
 *
 * The followings are the available model relations:
 * @property Proposalmessage[] $proposalmessages
 * @property Proposalresponse[] $proposalresponses
 * @property Jobrequests $jobRequests
 */
class Proposals extends CActiveRecord
{
	const FIXED_COST = 1;
	const HOURLY_RATE = 2;
	const DAYS = 1;
	const HOURS = 2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Proposals the static model class
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
		return '{{proposals}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jobRequests_id', 'required'),
			array('jobRequests_id', 'numerical', 'integerOnly'=>true),
			array('cost, cost_type, duration, duration_type, resource', 'length', 'max'=>45),
			array('note', 'length', 'max'=>1500),
			array('startDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cost, cost_type, duration, duration_type, startDate, resource, note, jobRequests_id', 'safe', 'on'=>'search'),
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
			'proposalmessages' => array(self::HAS_MANY, 'ProposalMessage', 'proposal_id'),
			'proposalresponses' => array(self::HAS_MANY, 'ProposalResponse', 'proposal_id'),
			'jobRequests' => array(self::BELONGS_TO, 'JobRequests', 'jobRequests_id'),
			'responseCount'=>array(self::STAT, 'ProposalResponse', 'proposal_id', 'condition'=>'status='.ProposalResponse::UNREAD),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cost' => 'Cost',
			'cost_type' => 'Cost Type',
			'duration' => 'Duration',
			'duration_type' => 'Duration Type',
			'startDate' => 'Start Date',
			'resource' => 'Resource',
			'note' => 'Note',
			'jobRequests_id' => 'Job Requests',
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

		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('cost_type',$this->cost_type,true);
		$criteria->compare('duration',$this->duration,true);
		$criteria->compare('duration_type',$this->duration_type,true);
		$criteria->compare('startDate',$this->startDate,true);
		$criteria->compare('resource',$this->resource,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('jobRequests_id',$this->jobRequests_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}