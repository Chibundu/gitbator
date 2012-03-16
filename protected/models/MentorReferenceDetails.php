<?php

/**
 * This is the model class for table "{{mentor_reference_details}}".
 *
 * The followings are the available columns in table '{{mentor_reference_details}}':
 * @property integer $id
 * @property string $title
 * @property string $lastname
 * @property string $firstname
 * @property string $phone
 * @property string $email
 * @property integer $tbl_mentors_id
 *
 * The followings are the available model relations:
 * @property Mentors $tblMentors
 */
class MentorReferenceDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MentorReferenceDetails the static model class
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
		return '{{mentor_reference_details}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, lastname, firstname, phone, email', 'required'),
			array('email', 'email'),
			array('email', 'unique'),
			array('phone', 'match', 'pattern'=>'/^\d{9,13}$/'),
			array('tbl_mentors_id', 'numerical', 'integerOnly'=>true),
			array('title, lastname, firstname, phone, email', 'length', 'max'=>45),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, lastname, firstname, phone, email, tbl_mentors_id', 'safe', 'on'=>'search'),
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
			'tblMentors' => array(self::BELONGS_TO, 'Mentors', 'tbl_mentors_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Position',
			'lastname' => 'Surname',
			'firstname' => 'First Name',
			'phone' => 'Phone',
			'email' => 'Email',
			'tbl_mentors_id' => 'Tbl Mentors',
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
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tbl_mentors_id',$this->tbl_mentors_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}