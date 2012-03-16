<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $sex
 * @property string $pic
 * @property string $dob
 * @property string $highestLevelOfEducation
 * @property string $lastUpdateTime
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property Addresses[] $addresses
 * @property Bizinfo[] $bizinfos
 * @property Mentors[] $tblMentors
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
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
			array('firstname, lastname, sex, dob, highestLevelOfEducation', 'required'),
			array('firstname, lastname, highestLevelOfEducation', 'length', 'min'=>2, 'max'=>45),
			array('sex', 'length', 'min'=>4, 'max'=>6),
			array('email','length', 'max'=>30),
			array('email','email'),
			array('email','unique'),
			array('pic, create_time', 'safe'),			
			array('dob', 'date', 'format'=>'dd/MM/yyyy'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstname, lastname, sex, pic, dob, highestLevelOfEducation, lastUpdateTime, create_time', 'safe', 'on'=>'search'),
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
			'addresses' => array(self::HAS_MANY, 'Addresses', 'tbl_users_id'),
			'bizinfos' => array(self::HAS_MANY, 'Bizinfo', 'tbl_users_id'),
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
			'pic' => 'Pic',
			'dob' => 'Date of Birth',
			'highestLevelOfEducation' => 'Highest Level Of Education',
			'lastUpdateTime' => 'Last Update Time',
			'create_time' => 'Create Time',
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
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('highestLevelOfEducation',$this->highestLevelOfEducation,true);
		$criteria->compare('lastUpdateTime',$this->lastUpdateTime,true);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider(get_class($this), array(
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