<?php

/**
 * This is the model class for table "{{package_excluded}}".
 *
 * The followings are the available columns in table '{{package_excluded}}':
 * @property integer $id
 * @property string $item
 * @property integer $packages_id
 *
 * The followings are the available model relations:
 * @property Packages $packages
 */
class PackageExcluded extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PackageExcluded the static model class
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
		return '{{package_excluded}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('packages_id', 'required'),
			array('packages_id', 'numerical', 'integerOnly'=>true),
			array('item', 'length','min'=>2,'max'=>150),
			array('item', 'match', 'pattern'=>'/^([A-Za-z0-9\-_,&().  ])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item, packages_id', 'safe', 'on'=>'search'),
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
			'packages' => array(self::BELONGS_TO, 'Packages', 'packages_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item' => 'Item',
			'packages_id' => 'Packages',
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
		$criteria->compare('item',$this->item,true);
		$criteria->compare('packages_id',$this->packages_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}