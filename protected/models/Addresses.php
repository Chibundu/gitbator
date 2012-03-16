<?php

/**
 * This is the model class for table "{{addresses}}".
 *
 * The followings are the available columns in table '{{addresses}}':
 * @property integer $id
 * @property string $first_line
 * @property string $second_line
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $postal_code 
 * @property string $website
 * @property string $phone_1
 * @property string $phone_2
 * @property integer $tbl_users_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Addresses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Addresses the static model class
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
		return '{{addresses}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_line, city, tbl_users_id, phone_1', 'required'),
			array('tbl_users_id, phone_1,phone_2', 'numerical', 'integerOnly'=>true),
			array('second_line', 'length', 'max'=>100),
			array('first_line', 'length', 'min'=>5, 'max'=>100),
			array('city, province, country', 'length', 'min'=>2, 'max'=>45),
			array('postal_code', 'length', 'max'=>10),
			array('website', 'length', 'max'=>128),						
			array('website','url'),
			array('phone_1, phone_2', 'length', 'min'=>9,'max'=>13),
			array('phone_1, phone_2', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_line, second_line, city, province, country, postal_code, website, phone_1, phone_2, tbl_users_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'tbl_users_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_line' => 'First Line',
			'second_line' => 'Second Line',
			'city' => 'City',
			'province' => 'Province',
			'country' => 'Country',
			'postal_code' => 'Postal Code',			
			'website' => 'Website',
			'phone_1' => 'Phone 1',
			'phone_2' => 'Phone 2',
			'tbl_users_id' => 'Tbl Users',
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
		$criteria->compare('first_line',$this->first_line,true);
		$criteria->compare('second_line',$this->second_line,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postal_code',$this->postal_code,true);		
		$criteria->compare('website',$this->website,true);
		$criteria->compare('phone_1',$this->phone_1,true);
		$criteria->compare('phone_2',$this->phone_2,true);
		$criteria->compare('tbl_users_id',$this->tbl_users_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}