<?php

/**
 * This is the model class for table "{{providers_auth}}".
 *
 * The followings are the available columns in table '{{providers_auth}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $tbl_teamMembers_id
 * @property integer $tbl_teamMembers_tbl_team_id
 *
 * The followings are the available model relations:
 * @property Teammembers $tblTeamMembers
 */
class ProvidersAuth extends CActiveRecord
{
	public $password_repeat;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProvidersAuth the static model class
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
		return '{{providers_auth}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('tbl_teamMembers_id, tbl_teamMembers_tbl_team_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>45),
			array('password', 'compare'),
			array('password_repeat', 'safe'),
			array('password, salt', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt, tbl_teamMembers_id, tbl_teamMembers_tbl_team_id', 'safe', 'on'=>'search'),
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
			'tblTeamMembers' => array(self::BELONGS_TO, 'Teammembers', 'tbl_teamMembers_id'),
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
			'tbl_teamMembers_id' => 'Tbl Team Members',
			'tbl_teamMembers_tbl_team_id' => 'Tbl Team Members Tbl Team',
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
		$criteria->compare('tbl_teamMembers_id',$this->tbl_teamMembers_id);
		$criteria->compare('tbl_teamMembers_tbl_team_id',$this->tbl_teamMembers_tbl_team_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns encrypted password
	 */
	public function encryptPassword()
	{
		$this->password = md5($this->generateSalt().$this->password);
	}
	/**	 
	 * Validates the password
	 * @param string, the password to be validated
	 * @return boolean, the authentication status
	 */
	public function validatePassword($password){
		return md5($this->salt.$password) == $this->password;
	}
	private function generateSalt(){
		$this->salt = uniqid();
		return $this->salt;
	}
}