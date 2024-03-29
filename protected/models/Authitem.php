<?php

/**
 * This is the model class for table "authitem".
 *
 * The followings are the available columns in table 'authitem':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property Authassignment[] $assignments
 * @property Authitemchild[] $children
 */
class Authitem extends CActiveRecord
{	
	
	const OPERATION = 0;
	const TASK = 1;
	const ROLE = 2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Authitem the static model class
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
		return 'authitem';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description, bizrule, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
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
			'assignments' => array(self::HAS_MANY, 'Authassignment', 'itemname'),
			'children' => array(self::HAS_MANY, 'Authitemchild', 'parent'),		
			'parents'=>array(self::HAS_MANY, 'Authitemchild', 'child'),	
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Name',
			'type' => 'Type',
			'description' => 'Description',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar'=>'page'
			),
			'sort'=>array(
				'defaultOrder'=>'created_on DESC',
			),
		));
	}
	
	public function getItemType()
	{
		
		if($this->type == self::OPERATION)
		{
			return 'Operation';
		}
		else if($this->type == self::TASK)
		{
			return 'Task';
		}
		else
		{
			return 'Role';
		}
	}
	
	public function getChildren()
	{
		return $this->children;
	}
	
	public static function types()
	{
		return array(self::ROLE => 'Role', self::TASK=>'Task', self::OPERATION=>'Operation');
	}
	public function behaviors(){
 	 	return array(
 	 		'CTimestampBehavior' => array(
  			'class' => 'zii.behaviors.CTimestampBehavior',
 			'createAttribute' => 'created_on',
 			'updateAttribute' => 'last_modified',
 		)
  	);
  }
  
   
}