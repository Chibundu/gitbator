<?php

/**
 * This is the model class for table "{{services}}".
 *
 * The followings are the available columns in table '{{services}}':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $categories_id
 *
 * The followings are the available model relations:
 * @property Paymentmodel[] $paymentmodels
 * @property Serviceproviders[] $tblServiceproviders
 * @property ServiceRates $rate
 * @property Servicecategories $category
 */
class Services extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Services the static model class
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
		return '{{services}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, categories_id', 'required'),
			array('categories_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('desc', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, categories_id', 'safe', 'on'=>'search'),
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
			'paymentmodels' => array(self::HAS_MANY, 'Paymentmodel', 'services_id'),
			'tblServiceproviders' => array(self::MANY_MANY, 'Serviceproviders', '{{providers_services}}(services_id, serviceproviders_id)'),
			'rate' => array(self::HAS_ONE, 'ServiceRates', 'services_id'),
			'category' => array(self::BELONGS_TO, 'Servicecategories', 'categories_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'desc' => 'Desc',
			'categories_id' => 'Categories',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('categories_id',$this->categories_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}