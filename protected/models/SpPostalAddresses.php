<?php

/**
 * This is the model class for table "{{sp_postal_addresses}}".
 *
 * The followings are the available columns in table '{{sp_postal_addresses}}':
 * @property integer $id
 * @property string $firstline
 * @property string $secondline
 * @property string $postalCode
 * @property string $city
 * @property string $province
 * @property string $country
 * @property integer $serviceproviders_id
 *
 * The followings are the available model relations:
 * @property Serviceproviders $serviceproviders
 */
class SpPostalAddresses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SpPostalAddresses the static model class
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
		return '{{sp_postal_addresses}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstline, city, country', 'required'),
			array('id, serviceproviders_id', 'numerical', 'integerOnly'=>true),
			array('firstline, secondline, postalCode, city, province, country', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstline, secondline, postalCode, city, province, country, serviceproviders_id', 'safe', 'on'=>'search'),
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
			'' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstline' => 'First Line',
			'secondline' => 'Second Line',
			'postalCode' => 'Postal Code',
			'city' => 'City',
			'province' => 'Province',
			'country' => 'Country',
			'serviceproviders_id' => 'Serviceproviders',
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
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}