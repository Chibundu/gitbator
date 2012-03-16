<?php

/**
 * This is the model class for table "{{jobs}}".
 *
 * The followings are the available columns in table '{{jobs}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property double $rating
 * @property string $amount
 * @property string $dateOfCreation
 * @property integer $jobStatus
 * @property integer $users_id
 * @property string $currency_code
 *
 * The followings are the available model relations:
 * @property Jobmilestones[] $jobmilestones
 * @property Jobrequests[] $jobrequests
 * @property Users $users
 * @property Currencies $currencyCode
 */
class Jobs extends CActiveRecord
{
	const AWAITING_RESPONSE = 1;
	const AWAITING_PROPOSAL = 2;
	const PROPOSAL_ACCEPTED = 3;
	const AWAITING_FUNDS_ESCROW = 4; 
	const FUNDS_ESCROWED = 5;
	const IN_PROGRESS=6;
	const ACTIVE_PROPOSALS=7;
	const COMPLETED=8;	 
	/**
	 * Returns the static model of the specified AR class.
	 * @return Jobs the static model class
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
		return '{{jobs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id', 'required'),
			array('jobStatus, users_id, currencies_id', 'numerical', 'integerOnly'=>true),
			array('rating', 'numerical'),
			array('title', 'length', 'max'=>256),
			array('description', 'length', 'max'=>1200),
			array('amount', 'length', 'max'=>45),		
			array('dateOfCreation', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, rating, amount, dateOfCreation, jobStatus, users_id, currency_code', 'safe', 'on'=>'search'),
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
			'jobmilestones' => array(self::HAS_MANY, 'Jobmilestones', 'tbl_jobs_id'),
			'jobrequests' => array(self::HAS_MANY, 'Jobrequests', 'jobs_id'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currencies_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'rating' => 'Rating',
			'amount' => 'Amount',
			'dateOfCreation' => 'Date Of Creation',
			'jobStatus' => 'Job Status',
			'users_id' => 'Users',
			'currencies_id' => 'Currency',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('dateOfCreation',$this->dateOfCreation,true);
		$criteria->compare('jobStatus',$this->jobStatus);
		$criteria->compare('users_id',$this->users_id);
		$criteria->compare('currency_code',$this->currency_code,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}