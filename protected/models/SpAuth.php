<?php

/**
 * This is the model class for table "{{sp_auth}}".
 *
 * The followings are the available columns in table '{{sp_auth}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt 
 * @property integer $teammembers_id
 *
 * The followings are the available model relations:
 * @property Teammembers $teammember
 */
class SpAuth extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpAuth the static model class
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
		return '{{sp_auth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teammembers_id', 'required'),
			array('teammembers_id', 'numerical', 'integerOnly'=>true),
			array('username, password, salt', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt, role, teammembers_id', 'safe', 'on'=>'search'),
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
			'teammember' => array(self::BELONGS_TO, 'Teammembers', 'teammembers_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'salt' => 'Salt',			
			'teammembers_id' => 'Team Member',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('teammembers_id',$this->teammembers_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**	 
	 * Encrypts the password for a particular
	 */
	public function encryptPassword()
	{
		$this->salt = uniqid();
		$this->password = md5($this->salt.$this->password);
	}
	
	/**	 
	 * Validates a given password
	 */
	public function validatePassword($password)
	{
		return $this->password == md5($this->salt.$password);
	}
}