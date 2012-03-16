<?php

/**
 * This is the model class for table "{{mentor_answers}}".
 *
 * The followings are the available columns in table '{{mentor_answers}}':
 * @property integer $id
 * @property string $literal
 * @property integer $mentors_id
 * @property integer $mentor_question_id
 *
 * The followings are the available model relations:
 * @property Mentors $mentors
 * @property MentorQuestion $mentorQuestion
 */
class MentorAnswers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MentorAnswers the static model class
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
		return '{{mentor_answers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mentors_id, mentor_question_id', 'required'),
			array('mentors_id, mentor_question_id', 'numerical', 'integerOnly'=>true),
			array('literal', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, literal, mentors_id, mentor_question_id', 'safe', 'on'=>'search'),
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
			'mentors' => array(self::BELONGS_TO, 'Mentors', 'mentors_id'),
			'mentorQuestion' => array(self::BELONGS_TO, 'MentorQuestion', 'mentor_question_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'literal' => '',
			'mentors_id' => 'Mentors',
			'mentor_question_id' => 'Mentor Question',
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
		$criteria->compare('literal',$this->literal,true);
		$criteria->compare('mentors_id',$this->mentors_id);
		$criteria->compare('mentor_question_id',$this->mentor_question_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}