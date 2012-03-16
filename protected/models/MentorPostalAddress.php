<?php

/**
 * This is the model class for table "{{mentor_postal_address}}".
 *
 * The followings are the available columns in table '{{mentor_postal_address}}':
 * @property integer $id
 * @property string $firstline
 * @property string $secondline
 * @property string $postalCode
 * @property string $city
 * @property string $province
 * @property string $country
 * @property integer $mentors_id
 *
 * The followings are the available model relations:
 * @property Mentors $mentors
 */
class MentorPostalAddress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return MentorPostalAddress the static model class
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
		return '{{mentor_postal_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstline, postalCode, city', 'required'),
			array('mentors_id', 'numerical', 'integerOnly'=>true),
			array( 'province, country', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstline, secondline, postalCode, city, province, country, mentors_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstline' => 'Firstline',
			'secondline' => 'Secondline',
			'postalCode' => 'Postal Code',
			'city' => 'City',
			'province' => 'Province',
			'country' => 'Country',
			'mentors_id' => 'Mentors',
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
		$criteria->compare('firstline',$this->firstline,true);
		$criteria->compare('secondline',$this->secondline,true);
		$criteria->compare('postalCode',$this->postalCode,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('mentors_id',$this->mentors_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}