<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $sex
 * @property string $email
 * @property string $pic
 * @property string $dob
 * @property string $highestLevelOfEducation
 * @property string $lastUpdateTime
 * @property string $create_time
 * @property string $phone
 * @property string $website
 * @property integer $currencies_id
 *
 * The followings are the available model relations:
 * @property Currencies $currency
 * @property Addresses[] $addresses
 * @property Bizinfo[] $bizinfos
 * @property Jobs[] $jobs
 * @property Recommendations[] $recommendations
 * @property Mentors[] $tblMentors
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname', 'required'),
			array('firstname, lastname, highestLevelOfEducation, phone', 'length', 'max'=>45),
			array('sex', 'length', 'max'=>6),
			array('email', 'length', 'max'=>128),
			array('pic, dob, lastUpdateTime, create_time, website', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstname, lastname, sex, email, pic, dob, highestLevelOfEducation, lastUpdateTime, create_time, phone, website, currencies_id', 'safe', 'on'=>'search'),
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
			'currency'=>array(self::BELONGS_TO, 'Currencies', 'currencies_id'),
			'addresses' => array(self::HAS_MANY, 'Addresses', 'users_id'),
			'bizinfos' => array(self::HAS_MANY, 'Bizinfo', 'tbl_users_id'),
			'jobs' => array(self::HAS_MANY, 'Jobs', 'users_id'),
			'recommendations' => array(self::HAS_MANY, 'Recommendations', 'users_id'),
			'tblMentors' => array(self::MANY_MANY, 'Mentors', '{{users_has_tbl_mentors}}(tbl_users_id, tbl_mentors_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'sex' => 'Sex',
			'email' => 'Email',
			'pic' => 'Pic',
			'dob' => 'Dob',
			'highestLevelOfEducation' => 'Highest Level Of Education',
			'lastUpdateTime' => 'Last Update Time',
			'create_time' => 'Create Time',
			'phone' => 'Phone',
			'website' => 'Website',
			'currencies_id'=>'Currency',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('highestLevelOfEducation',$this->highestLevelOfEducation,true);
		$criteria->compare('lastUpdateTime',$this->lastUpdateTime,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('currencies_id',$this->currencies_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			$this->setCreateTime();
			foreach($this->metadata->tableSchema->columns as $columnName=>$column)
			{
				if (!strlen($this->$columnName)) continue;
				if($column->dbType == 'date')
				{
					$this->$columnName = date('Y-m-d',CDateTimeParser::parse($this->$columnName,'dd/MM/yyyy'));
				}
			}
			return true;
		}
		else
			return false;
	}
	protected function afterFind()
	{
		foreach($this->metadata->tableSchema->columns as $columnName=>$column)
		{
			if (!strlen($this->$columnName)) continue;
			if($column->dbType == 'date')
			{
				$this->$columnName = Yii::app()->dateFormatter->format('dd/MM/yyyy', CDateTimeParser::parse($this->$columnName,'yyyy-MM-dd'));
			}
		}
		return true;
	
	}
	private function setCreateTime()
	{
		if($this->create_time === null || $this->create_time=='0000-00-00 00:00:00')
		{
			$this->create_time = Yii::app()->dateFormatter->format('yyyy-MM-dd HH:mm:ss',time());
		}
	}
}