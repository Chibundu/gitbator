<?php

/**
 * This is the model class for table "{{mentors}}".
 *
 * The followings are the available columns in table '{{mentors}}':
 * @property integer $id
 * @property string $title
 * @property string $firstname
 * @property string $lastname
 * @property string $sex
 * @property string $dob
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 *
 * The followings are the available model relations:
 * @property MenthorAddress[] $menthorAddresses
 * @property MentorAddress[] $mentorAddresses
 * @property MentorAnswers[] $mentorAnswers
 * @property MentorCategories[] $tblMentorCategories
 * @property MentorPostalAddress[] $mentorPostalAddresses
 * @property MentorReferenceDetails[] $mentorReferenceDetails
 * @property Mentorauth[] $mentorauths
 * @property Mentorexperience[] $mentorexperiences
 * @property Mentorqual[] $mentorquals
 * @property OtherMentorCategory[] $tblOtherMentorCategories
 * @property Users[] $tblUsers
 */
class Mentors extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Mentors the static model class
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
		return '{{mentors}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname, phone1, email', 'required'),
			array('email', 'email'),		
			array('dob', 'date', 'format'=>'dd/MM/yyyy'),
			array('phone1, phone2', 'match', 'pattern'=>'/^\d{9,13}$/'),
			array('title, firstname, lastname, sex, phone1, phone2, email', 'length', 'max'=>45),
			array('dob', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, firstname, lastname, sex, dob, phone1, phone2, email', 'safe', 'on'=>'search'),
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
			'menthorAddresses' => array(self::HAS_MANY, 'MenthorAddress', 'mentors_id'),
			'mentorAddresses' => array(self::HAS_MANY, 'MentorAddress', 'mentors_id'),
			'mentorAnswers' => array(self::HAS_MANY, 'MentorAnswers', 'mentors_id'),
			'tblMentorCategories' => array(self::MANY_MANY, 'MentorCategories', '{{mentor_categories_has_mentors}}(mentors_id, mentor_categories_id)'),
			'mentorPostalAddresses' => array(self::HAS_MANY, 'MentorPostalAddress', 'mentors_id'),
			'mentorReferenceDetails' => array(self::HAS_MANY, 'MentorReferenceDetails', 'tbl_mentors_id'),
			'mentorauths' => array(self::HAS_MANY, 'Mentorauth', 'mentors_id'),
			'mentorexperiences' => array(self::HAS_MANY, 'Mentorexperience', 'mentors_id'),
			'mentorquals' => array(self::HAS_MANY, 'Mentorqual', 'mentors_id'),
			'tblOtherMentorCategories' => array(self::MANY_MANY, 'OtherMentorCategory', '{{other_mentor_categories}}(mentors_id, other_mentor_category_id)'),
			'tblUsers' => array(self::MANY_MANY, 'Users', '{{users_has_tbl_mentors}}(tbl_mentors_id, tbl_users_id)'),
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
			'firstname' => 'firstname',
			'lastname' => 'Surname',
			'sex' => 'Sex',
			'dob' => 'Date of Birth',
			'phone1' => 'Mobile number',
			'phone2' => 'Alternate Phone',
			'email' => 'Email',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('phone1',$this->phone1,true);
		$criteria->compare('phone2',$this->phone2,true);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave()
	{		
		if(parent::beforeSave())
		{
			
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
}