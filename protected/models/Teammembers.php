<?php

/**
 * This is the model class for table "{{teammembers}}".
 *
 * The followings are the available columns in table '{{teammembers}}':
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $phone
 * @property string $profile_picture
 * @property integer $isTeamLeader
 * @property integer $serviceproviders_id
 * @property string $lastLoggedIn
 *
 * The followings are the available model relations:
 * @property Qualification[] $qualifications
 * @property SpAuth[] $spAuths
 * @property Serviceproviders $serviceprovider
 * @property Teammemberskills[] $teammemberskills
 */
class Teammembers extends CActiveRecord
{
	const Role_TeamMember = 1;
	const Role_TeamLeader = 2;
	public $skill;
	public $password;
	public $password_repeat;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Teammembers the static model class
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
		return '{{teammembers}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id, email, phone', 'required'),
			array('firstname, lastname', 'match', 'pattern'=>'/^[A-Za-z\-, ]+$/'),
			array('phone', 'match', 'pattern'=>'/^[0-9]+$/'),	
			array('phone', 'length','min'=>9, 'max'=>13),		
			array('email','email'),
			array('email','unique'),	
			array('skill','safe'),
			array('password','compare'),		
			array('password, password_repeat','safe'),		
			array('isTeamLeader, serviceproviders_id', 'numerical', 'integerOnly'=>true),
			array('profile_picture','file','types'=>'jpg,gif,png','on'=>'upload'),
			array('password','required', 'on'=>'create'),
			array('firstname, lastname, email', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, firstname, lastname, email, phone, profile_picture, isTeamLeader, serviceproviders_id, lastLoggedIn', 'safe', 'on'=>'search'),
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
			'qualifications' => array(self::HAS_MANY, 'Qualification', 'teammember_id'),
			'spAuths' => array(self::HAS_MANY, 'SpAuth', 'teammembers_id'),
			'serviceProvider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
			'teammemberskills' => array(self::HAS_MANY, 'Teammemberskills', 'teammembers_id'),
			'skills'=>array(self::HAS_MANY, 'TeammemberSkills','teammembers_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'firstname' => 'Firstname',
			'lastname' => 'Lastname',
			'email' => 'Email',
			'phone' => 'Phone',
			'profile_picture' => 'Profile Picture',
			'isTeamLeader' => 'Is Team Leader',
			'serviceproviders_id' => 'Serviceproviders',
			'lastLoggedIn' => 'Last Logged In',
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
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('profile_picture',$this->profile_picture,true);
		$criteria->compare('isTeamLeader',$this->isTeamLeader);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('lastLoggedIn',$this->lastLoggedIn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
/**
	 * checks if this teammember is currently logged in
	 */
	public function isCurrentlyLoggedIn()
	{
		return $this->email==Yii::app()->user->id;
	}
	
	/**
	 * Stores skills
	 */
	public function storeSkills()
	{
		$this->deleteAllSkills();
		$skills = $this->skill;
		$skills_array = explode(',', $skills);
		if(count($skills_array) == 0)
		{
				$skill_model = new TeammemberSkills();
				$skill_model->teammembers_id = $this->id;
				$skill_model->name = $skills;
				if($skill_model->save())
					return true;
		}
		else
		{
			
			
			foreach ($skills_array as $skill)
			{
				$skill = trim($skill);
				$skill_model = new TeammemberSkills();
				
				if($this->id == NULL)
					$this->save(false);
				$skill_model->teammembers_id = $this->id;
				$skill_model->name = $skill;
				
				$skill_model->save();
				
				
			}
			return true;
		} 
		return false;
	}
	
	public function deleteAllSkills()
	{
		$this->refresh();
		$skills = $this->skills;
		foreach ($skills as $skill)
		{
			$skill->delete();
		}
		
	}
	
	public function retrieveSkills()
	{
		$this->refresh();
		$skills = $this->skills;
		$mySkills = '';
		$n = count($skills); 	  	
	  	for($i = 0; $i < $n; $i++)
	  	{
	  		if($i == 0):
	  			$mySkills.=$skills[$i]->name;	  			  			
	  		else:
	  			$mySkills.= ', '.$skills[$i]->name;
	  		endif;	  		
	  	}
	  	$this->skill = $mySkills;
	  
	}
	
	/**
	 * @return string a concatenation of the first and last names e.g Chibundu Mbagwu
	 */
	public function getFullName()
	{
		return $this->firstname.' '.$this->lastname;
	}
	
	public function getShortName()
	{
		$c = substr($this->firstname,0,1);
		return $this->lastname. ' '. $c.'.';
	}
}