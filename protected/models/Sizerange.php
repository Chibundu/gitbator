<?php

/**
 * This is the model class for table "{{sizerange}}".
 *
 * The followings are the available columns in table '{{sizerange}}':
 * @property integer $id
 * @property string $range
 *
 * The followings are the available model relations:
 * @property Serviceproviders[] $serviceproviders
 */
class Sizerange extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Sizerange the static model class
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
		return '{{sizerange}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('range', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, range', 'safe', 'on'=>'search'),
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
			'' => array(self::HAS_MANY, 'Serviceproviders', 'sizerange_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'range' => 'Range',
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
		$criteria->compare('range',$this->range,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getSizeRanges()
	{
		
		return CHtml::listData(self::model()->findAll(), 'id', 'range');
	}
}