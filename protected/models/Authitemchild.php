<?php

/**
 * This is the model class for table "authitemchild".
 *
 * The followings are the available columns in table 'authitemchild':
 * @property string $parent
 * @property string $child
 *
 * The followings are the available model relations:
 * @property Authitem $authitem 
 */
class Authitemchild extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Authitemchild the static model class
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
		return 'authitemchild';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('parent, child', 'required'),
			array('parent, child', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('parent, child', 'safe', 'on'=>'search'),
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
			'authitem' => array(self::BELONGS_TO, 'Authitem', 'parent'),						
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'parent' => 'Parent',
			'child' => 'Child',
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

		$criteria->compare('parent',$this->parent,true);
		$criteria->compare('child',$this->child,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getChildCount()
	{
		return $this->countByAttributes(array('parent'=>$this->child));
	}
	
	/**
	 * @return string tree label
	 */
	public function getTreeLabel()
	{
		return $this->child;
	}

	/**
	 * @return array menu url
	 */
	public function getItemUrl()
	{
		return '#';
	}
	
	public function getChildren()
	{
		return self::model()->findAllByAttributes(array('parent'=>$this->child));
	}
	
	/**
	 * @return array behaviors.
	 */
	public function behaviors()
	{
		return array(
			'TreeBehavior' => array(
				'class' => 'ext.behaviors.XTreeBehavior',
				'treeLabelMethod'=> 'getTreeLabel',
				'menuUrlMethod'=> 'getItemUrl',
			),
		);
	}
}