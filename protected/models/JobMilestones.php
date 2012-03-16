<?php

/**
 * This is the model class for table "{{jobMilestones}}".
 *
 * The followings are the available columns in table '{{jobMilestones}}':
 * @property integer $id
 * @property string $Milestone
 * @property string $JOBStatus
 * @property double $amountToBeReleased
 * @property integer $tbl_jobs_id
 */
class JobMilestones extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return JobMilestones the static model class
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
		return '{{jobMilestones}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_jobs_id', 'required'),
			array('tbl_jobs_id', 'numerical', 'integerOnly'=>true),
			array('amountToBeReleased', 'numerical'),
			array('Milestone, jobStatus', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, Milestone, jobStatus, amountToBeReleased, tbl_jobs_id', 'safe', 'on'=>'search'),
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
			'Milestone' => 'Milestone',
			'jobStatus' => 'Status',
			'amountToBeReleased' => 'Amount To Be Released',
			'tbl_jobs_id' => 'Tbl Jobs',
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
		$criteria->compare('Milestone',$this->Milestone,true);
		$criteria->compare('Status',$this->Status,true);
		$criteria->compare('amountToBeReleased',$this->amountToBeReleased);
		$criteria->compare('tbl_jobs_id',$this->tbl_jobs_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}