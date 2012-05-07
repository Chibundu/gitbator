<?php

/**
 * This is the model class for table "{{et_auth}}".
 *
 * The followings are the available columns in table '{{et_auth}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $users_id
 *
 * The followings are the available model relations:
 * @property Users $users
 */
class EtAuth extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EtAuth the static model class
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
		return '{{et_auth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id', 'required'),
			array('users_id', 'numerical', 'integerOnly'=>true),
			array('username, password, salt', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt, users_id', 'safe', 'on'=>'search'),
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
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
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
			'users_id' => 'Users',
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
		$criteria->compare('users_id',$this->users_id);

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