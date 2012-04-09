<?php

/**
 * This is the model class for table "{{serviceproviders}}".
 *
 * The followings are the available columns in table '{{serviceproviders}}':
 * @property integer $id
 * @property string $businessName
 * @property string $businessRegNo
 * @property string $businessRegType
 * @property string $displayName
 * @property string $tagline
 * @property string $vatNo
 * @property string $taxNo
 * @property string $pic
 * @property string $accountType
 * @property string $regYear
 * @property string $overview
 * @property string $paymentTerms
 * @property string $subscriptionPackage
 * @property double $earningsToDate
 * @property double $rating
 * @property double $purse
 * @property integer $sizerange_id
 * @property integer $currency_id
 * @property integer $created_on
 * @property integer $lastModified
 * @property string $timeZone
 * @property integer $isAvailable
 * @property integer $isActivated
 * @property string $activationCode;
 *
 * @property Availability[] $availabilities
 * @property Jobrequests[] $jobrequests
 * @property Otherservices[] $otherservices 
 * @property Portfolios[] $portfolio
 * @property Services[] $services
 * @property Services[] $servicesAndCat
 * @property Qualification[] $qualifications
 * @property Qualification[] $qualAndHolder
 * @property Recommendations[] $recommendations
 * @property ServiceRates[] $serviceRates
 * @property Sizerange $sizerange
 * @property Currencies $currency
 * @property Keywords[] $keywordSet
 * @property Skills[] $skillSet
 * @property SpAddresses $address
 * @property SpPostalAddresses $postalAddress
 * @property Spmessages[] $messages
 * @property Sppayments[] $payments
 * @property Teammembers[] $teamMembers
 * @property Teammembers $teamLeader
 * @property Team[] $teams
 * @property Qualification[] $pendingQualifications
 * @property Qualification[] $unverifiedQualifications
 * @property Qualification[] $verifiedQualifications
 * @property Verifications $verification
 * @property integer $vqCount
 * @property integer $uqCount
 * @property integer $pqCount
 * @property ProfilePts $profilePoints
 * @property Packages[] $packages
 */
class Serviceproviders extends CActiveRecord
{
	const FREELANCER = 1;
	const COMPANY = 2;
	
	const ACTIVATED = 1;
	
	
	public $keywords;
	public $skills;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Serviceproviders the static model class
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
		return '{{serviceproviders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('displayName, currency_id, sizerange_id, taxNo, skills', 'required'),
			array('sizerange_id, currency_id, created_on, lastModified', 'numerical', 'integerOnly'=>true),			
			array('displayName', 'match','pattern'=>'/^([A-Za-z0-9\-_])+$/'),
			array('displayName', 'unique'),
			array('businessName,keywords,skills', 'match','pattern'=>'/^([A-Za-z0-9\-_,&().#  ])+$/'),
			array('businessName','validateBizName'),
			array('businessRegType','validateBizType'),			
			array('regYear','match','pattern'=>'/^\d{4,4}$/'),
			array('pic','file','types'=>'jpg, gif, png', 'on'=>'upload', 'maxSize'=>5*1024*1024),
			array('regYear','checkRegDate'),	
			array('vatNo','validateVAT'),
			array('vatNo, taxNo','numerical'),
			array('keywords', 'length', 'max'=>200, 'message'=>'Please select just a few keywords'),
			array('skills', 'length', 'max'=>200, 'message'=>'Please select just a few skills. Are you a jack of all trades?'),
			array('keywords, skills', 'safe'),			
			array('earningsToDate, rating, purse', 'numerical'),
			array('businessName, businessRegNo, businessRegType, displayName, tagline, vatNo, taxNo, accountType, regYear, subscriptionPackage', 'length', 'max'=>45),
			array('overview', 'length','min'=>30, 'max'=>500),			
			array('paymentTerms', 'length', 'max'=>1000),		
			array('pic, timeZone', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, businessName, timeZone, businessRegNo, businessRegType, displayName, tagline, vatNo, taxNo, pic, accountType, regYear, overview, paymentTerms, subscriptionPackage, email, earningsToDate, rating, purse, sizerange_id, currency_id, created_on, lastModified', 'safe', 'on'=>'search'),
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
			'tblSkills' => array(self::MANY_MANY, 'Skills', 'serviceproviders_skills(tbl_serviceproviders_id, tbl_skills_id)'),
			'availabilities' => array(self::HAS_MANY, 'Availability', 'serviceproviders_id'),
			'jobrequests' => array(self::HAS_MANY, 'Jobrequests', 'serviceproviders_id'),
			'otherservices' => array(self::HAS_MANY, 'Otherservices', 'serviceproviders_id'),			
			'portfolio' => array(self::HAS_MANY, 'Portfolios', 'serviceproviders_id'),
			'services' => array(self::MANY_MANY, 'Services', '{{providers_services}}(serviceproviders_id, services_id)'),
			'servicesAndCat'=>array(self::MANY_MANY, 'Services','{{providers_services}}(serviceproviders_id, services_id)',
				'with'=>array('category.skills')
			),
			'qualifications' => array(self::HAS_MANY, 'Qualification', 'serviceProviders_id'),
			'qualAndHolder'=>array(self::HAS_MANY, 'Qualification', 'serviceProviders_id', 'with'=>'holder'),
			'recommendations' => array(self::HAS_MANY, 'Recommendations', 'serviceproviders_id'),
			'serviceRates' => array(self::HAS_MANY, 'ServiceRates', 'serviceproviders_id'),
			'sizerange' => array(self::BELONGS_TO, 'Sizerange', 'sizerange_id'),
			'currency' => array(self::BELONGS_TO, 'Currencies', 'currency_id'),
			'keywordSet' => array(self::MANY_MANY, 'Keywords', '{{serviceproviders_has_tbl_keywords}}(tbl_serviceProviders_id, tbl_keywords_id)'),
			'address' => array(self::HAS_ONE, 'SpAddresses', 'serviceProviders_id'),			
			'postalAddress' => array(self::HAS_ONE, 'SpPostalAddresses', 'serviceproviders_id'),
			'spmessages' => array(self::HAS_MANY, 'Spmessages', 'serviceproviders_id'),
			'sporders' => array(self::HAS_MANY, 'Sporder', 'serviceproviders_id'),
			'teamMembers' => array(self::HAS_MANY, 'Teammembers', 'serviceproviders_id'),
			'teamLeader'=>array(self::HAS_ONE, 'Teammembers', 'serviceproviders_id', 'condition'=>'isTeamLeader=true'),
			'verifications' => array(self::HAS_ONE, 'Verifications', 'serviceproviders_id'),
			'verification'=>array(self::HAS_ONE, 'Verifications', 'serviceproviders_id'),
			'verifiedQualifications'=>array(self::HAS_MANY, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerified=1"),
			'unverifiedQualifications'=>array(self::HAS_MANY, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerified=0 AND isVerificationRequestSent=0"),
			'skillSet'=>array(self::MANY_MANY,'Skills','serviceproviders_skills(tbl_serviceproviders_id, tbl_skills_id)'),
			'teams' => array(self::HAS_MANY, 'Team', 'tbl_serviceProviders_id'),
			'pendingQualifications'=>array(self::HAS_MANY, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerificationRequestSent=1 AND isVerified=0"),
			'pqCount'=>array(self::STAT, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerificationRequestSent=1 AND isVerified=0"),
			'uqCount'=>array(self::STAT, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerified=0 AND isVerificationRequestSent=0"),
			'vqCount'=>array(self::STAT, 'Qualification', 'serviceProviders_id', 'condition'=>"isVerified=1"),
			'profilePoints'=>array(self::HAS_ONE, 'ProfilePts', 'serviceproviders_id'),
			'packages'=>array(self::HAS_MANY, 'Packages', 'serviceproviders_id', 'order'=>'packages.created_on DESC'),
		
		);
	}	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'businessName' => 'Business Name',
			'businessRegNo' => 'Business Reg No',
			'businessRegType' => 'Business Reg Type',
			'displayName' => 'Display Name',
			'tagline' => 'Tagline',
			'vatNo' => 'Vat No',
			'taxNo' => 'Tax No',
			'pic' => 'Logo',
			'accountType' => 'Account Type',
			'regYear' => 'Year of Registration',			
			'overview' => 'Overview',
			'paymentTerms' => 'Payment Terms',
			'subscriptionPackage' => 'Subscription Package',
			'earningsToDate' => 'Earnings To Date',
			'rating' => 'Rating',
			'purse' => 'Purse',
			'sizerange_id' => 'Sizerange',
			'currency_id' => 'Currency',
			'created_on' => 'Created On',
			'lastModified' => 'Last Modified',
			'timeZone' => 'Time Zone',
			'isAvailable' => 'Available?',
			'isActivated' => 'Activated?',
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
		$criteria->compare('businessName',$this->businessName,true);
		$criteria->compare('businessRegNo',$this->businessRegNo,true);
		$criteria->compare('businessRegType',$this->businessRegType,true);
		$criteria->compare('displayName',$this->displayName,true);
		$criteria->compare('tagline',$this->tagline,true);
		$criteria->compare('vatNo',$this->vatNo,true);
		$criteria->compare('taxNo',$this->taxNo,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('accountType',$this->accountType,true);
		$criteria->compare('regYear',$this->regYear,true);
		$criteria->compare('overview',$this->overview,true);
		$criteria->compare('paymentTerms',$this->paymentTerms,true);
		$criteria->compare('subscriptionPackage',$this->subscriptionPackage,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('earningsToDate',$this->earningsToDate);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('purse',$this->purse);
		$criteria->compare('sizerange_id',$this->sizerange_id);
		$criteria->compare('currency_id',$this->currency_id);
		$criteria->compare('created_on',$this->created_on);
		$criteria->compare('lastModified',$this->lastModified);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function checkRegDate($attribute, $params)
	{
		if($this->accountType == 'Company' && ($this->regYear == null || $this->regYear == ''))
		{
			$this->addError('regYear', "Please enter the year ".(($this->businessName=='')?'your company':("'".$this->businessName)."'"). " was registered.");
		}
		else if(($this->accountType == 'Company')&& ($this->regYear < 1800 || $this->regYear > 2012))
		{
			$this->addError('regYear', "Year is beyond expected range");
		}		
	}
	/**
	 * Stores comma separated keywords in a way that recognizes already existing keywords and also avoids duplicates
	 */
	public function storeKeywords()
	{	
		$this->deleteKeywords();
		$this->keywords = trim($this->keywords);
		$length = strlen($this->keywords);
		//remove any trailing commas
		if(strrpos($this->keywords,',')===($length-1))
		{
			$this->keywords = substr($this->keywords, 0, ($length-1));
		}
		//remove any preceding commas
		if(strpos($this->keywords, ',')=== 0)
		{
			$this->keywords = substr($this->keywords,1);
		}
		
		$keyword_array = explode(",",$this->keywords);
		if(count($keyword_array) == 0)
		{
			$keyword_array[] = $this->keywords;
		}
		
		$connection = Yii::app()->db;
		$command = $connection->createCommand("INSERT INTO {{serviceproviders_has_tbl_keywords}} (tbl_serviceProviders_id, tbl_keywords_id) VALUES (:spId, :kId)");
		
		$rowsInserted = 0;		
		
		foreach ($keyword_array as $keyword)
		{
			$keyword = trim($keyword);			
			if($keyword != ''){	
							
				if(($keywords = Keywords::model()->findByAttributes(array('keyword'=>$keyword))) == null)
				{						
					$keywords = new Keywords();
					$keywords->keyword = $keyword;
					$keywords->save(false);		
	
					$rowsInserted++;
				}	
				
				$kId = $keywords->id;
				$spId = $this->id;
				
				if(!Miscellaneous::exists("tbl_keywords_id","tbl_serviceProviders_id=:spId AND tbl_keywords_id=:kId", array(':spId'=>$spId,':kId'=>$kId),"tbl_serviceproviders_has_tbl_keywords"))
				{					
					$command->bindParam(":spId", $spId);
					$command->bindParam(":kId", $kId);
					$command->execute();
				}
			}
		}	
		
		return $rowsInserted;
	}
	
	/**
	 * Stores comma separated skills in a way that recognizes already existing skills and avoids duplicates
	 */
	public function storeSkills()
	{	
		$this->deleteAllSkills();
		$this->skills = trim($this->skills);
		$length = strlen($this->skills);		
		//remove accidental last comma
		if(strrpos($this->skills, ',')=== ($length-1))
		{			
			$this->skills = substr($this->skills, 0, ($length-1));
		}
		//remove accidental first comma	
		if(strpos($this->skills, ',')=== 0)
		{				
			$this->skills = substr($this->skills, 1);
		}
		$skills_array = explode(",", $this->skills);
		
		$connection = Yii::app()->db;		
		$command = $connection->createCommand("INSERT INTO serviceproviders_skills (tbl_serviceproviders_id, tbl_skills_id) VALUES (:spId,:skId)");
		
		$rowsInserted = 0;
		foreach ($skills_array as $skill)
		{
			$skill = trim($skill);
			if($skill != ''){
				//if we can't find the skill by the skill name, we create a new one
				
				if(($skills = Skills::model()->findByAttributes(array('name'=>$skill))) == null)
				{										
					$skills = new Skills();
					$skills->name = $skill;						
					$skills->save(false);				
					$rowsInserted++;
				}
				
				$skId = $skills->id;
				$spId = $this->id;
				if(!Miscellaneous::exists("tbl_serviceproviders_id","tbl_serviceproviders_id=:spId AND tbl_skills_id=:skId",array(':spId'=>$spId,':skId'=>$skId), 'serviceproviders_skills')){
					$command->bindParam(":skId", $skId);
					$command->bindParam(":spId",$spId);	
					$command->execute();
				}
			}
				
		}	
		
		//$this->lastModified = time();
		//$this->save(false);	
		return $rowsInserted;
	}
	
	
	/**
	 * Deletes keywords that belong ONLY to a particular service provider
	 */
	public function deleteKeywords()
	{		
		//self::refresh();
		$keywords = $this->keywordSet;
		$spId = $this->id;
		$connection = Yii::app()->db;
		$command = $connection->createCommand("DELETE FROM {{serviceproviders_has_tbl_keywords}} WHERE tbl_serviceProviders_id = :spId AND tbl_keywords_id=:kId");
		foreach($keywords as $keyword)
		{			
			$kId = $keyword->id;
			$command->bindParam(":kId",$kId);
			$command->bindParam(":spId", $spId);
			$command->execute();	
			if(!Miscellaneous::exists("tbl_keywords_id","tbl_keywords_id=:kId AND tbl_serviceProviders_id != :spId", array(":kId"=>$kId, ":spId"=>$spId),"{{serviceproviders_has_tbl_keywords}}"))
			{
				$keyword->delete();
			}			
		}
	}
	/**
	 * Deletes All Skills of this Provider that are not associated with other Providers
	 * (A modification is being made(20/02/2012) where preloaded skills, WHICH HAVE ALREADY BEEN CATEGORIZED, are untouched)
	 */
	public function deleteAllSkills()
	{
		$serviceProvider = self::model()->findByPk($this->id);
		$skills = $serviceProvider->skillSet;
		$spId = $serviceProvider->id;
		$connection = Yii::app()->db;
		$command = $connection->createCommand("DELETE FROM serviceproviders_skills WHERE tbl_serviceproviders_id = ".$spId." AND tbl_skills_id =:skId");
		foreach ($skills as $skill)
		{			
			foreach ($skills as $skill)
			{
				$skId = $skill->id;
				$command->bindParam(":skId",$skId);
				$command->execute();
				if(!Miscellaneous::exists('tbl_skills_id','tbl_skills_id = :skId AND tbl_serviceproviders_id!=:spId', array(':spId'=>$spId,':skId'=>$skill->id), 'serviceproviders_skills'))
				{
					if($skill->category == NULL)
						$skill->delete();
				}				
					
			}			
				
		}
	}
	/**
	 * Returns a comma-separated list of keywords
	 */
	public function getKeywords()
	{
		$keywords = '';
		//self::refresh();
		$keyword_array = $this->keywordSet;			
		foreach($keyword_array as $keyword)
		{				
			$keywords.=$keyword->keyword.", ";
		}
		$keywords = trim($keywords);
		if($keywords != '')
			$keywords = substr($keywords, 0, strlen($keywords)-1);
		$this->keywords = $keywords;
		return $keywords;
	}
	/**
	 * Returns comma-separated list of skills
	 */
	public function getSkills()
	{
		$dSkills = '';	
		$skills = $this->skillSet;
		if(!empty($skills)){		
			foreach ($skills as $skill)
			{
				$dSkills.=$skill->name.', ';	
			}
			$dSkills =trim($dSkills);
			if($dSkills != '')
				$dSkills = substr($dSkills, 0, strlen($dSkills)-1);		
			$this->skills = $dSkills;		
		}	
		return $dSkills;
	}
	/**
	 * @return string services separated by commas e.g web design, mobile applications development
	 */
	public function getServices()
	{
		$services = '';		
		$service_array = $this->services;
		if(!empty($service_array))
		{
			foreach($service_array as $service)
			{
				$services .= $service->name.", ";
			}
		}
		$services = trim($services);
		if($services != '')
			$services = substr(trim($services),0,strlen($services)-1);
		return $services;
	}
	

	/**
	 * Validates business registration number. It is compulsory for companies to enter their company registeration numbers
	 */
	public function validateBizRegNo()
	{
		if($this->accountType == 'company' && ($this->businessRegNo == null || $this->businessRegNo == ''))
		{
			$this->addError('businessRegNo', "Please enter the registration number for ".(($this->businessName=='')?'your company':("'".$this->businessName)."'"));
		}		
	}
	/**
	 * Validates business name. It is compulsory for companies to put their company name 
	 */
	public function validateBizName()
	{		
		if($this->accountType == 'company' && ($this->businessName == null || $this->businessName == ''))
		{
			$this->addError('businessName', "Please enter the name of your company");
		}		
	}
 	/** Validates company registration type. It is compulsory for companies to put their company registration type 
	 */
	public function validateBizType()
	{
		if($this->accountType == 'company' && ($this->businessRegType == null || $this->businessRegType == ''))
		{
			$this->addError('businessRegType', "Please enter the registration type for you company");
		}		
	}
	
	/**
	 * Validates VAT field
	 */
	public function validateVAT()
	{
		if($this->accountType == 'company' && ($this->vatNo == null || $this->vatNo == ''))
		{
			$this->addError('vatNo', "Please enter the VAT number for ".(($this->businessName=='')?'your company':("'".$this->businessName)."'"));
		}		
	}
	/**
	 * Returns the profile Id of a service provider in the form VPS-001,VPS-089,VPS-987, etc
	 */
	public function normalizeSPId()
	{
		$id = $this->id;
		switch($id)
		{
			case ($id >= 0 && $id < 10):
				$id = "VSP-00".$id;
				break;
			case ($id >=10 && $id < 100):
				$id	= "VSP-0".$id;
				break;
			default: 
				$id = "VSP-".$id;
				break;
		}
				
		return $id;	
	}
	
	/**
	 * @return integer the number of verified data
	 */
	public function getVerificationCount()
	{		
		$count = 0;
				
		$count += count($this->verifiedQualifications);
		
		if($this->verification->email == true)
		{			
			$count++;
		}
		if($this->verification->phone == true)
		{
			$count++;
		}
		if($this->verification->identity == true)
		{			
			$count++;
		}
		
		return $count;
	}
	
	/**
	 * returns portfolio size
	 */
	public function getPortfolioSize()
	{
		$size = 0;
		foreach	($this->portfolio as $portfolio)
		{
			$size += $portfolio->size;
			
		}
		return number_format($size, 2);
	}
	/**
	 * @returns an array of service ids
	 */
	public function getMyServiceIds()
	{
		$services = $this->services;
		$myServiceIds = array();
		foreach($services as $service)
		{
			$myServiceIds[]=$service->id;
		}
		return $myServiceIds;
	}
	/**
	 * @return boolean whether the service provider is a company or a freelancer
	 */
	public function getIsCompany()
	{
		return $this->accountType == 'Company';	
	}
	
	/**
	 * @return array containing the verified count, general verification object(comprises email, phone, identity), unverified count and pending Verifications count
	 * array('verifiedCount'=>$this->verificationCount,'general'=>$verification,'unverifiedCount'=>$unverifiedCount,'pending'=>$pending)
	 */
	public function getVerifications()
	{			
		$verification = $this->verification;
		$unverifiedCount = count($this->unverifiedQualifications);	
		$pending = count($this->pendingQualifications);
		
		if($verification->email == 0)
		{
			$unverifiedCount++;
		}
		if($verification->phone == 0)
		{
			$unverifiedCount++;
		}
		if($verification->identity == 0)
		{			
			$unverifiedCount++;
		}
		if($verification->isIdentityRequestSent)
		{
			$pending++;
			$unverifiedCount--;
		}
		return array('verifiedCount'=>$this->verificationCount,'general'=>$verification,'unverifiedCount'=>$unverifiedCount,'pending'=>$pending);
	}
	/**
	 * @return timezone as GMT+timezone where timezone is: -1,0, 1, 2, 3, etc
	 */
	public function getFormattedTimeZone()
	{
		return substr($this->timeZone, strpos($this->timeZone, 'G'));		
	}
	
	/**
	 * @returns date time based on the Time Zone setting of the service provider
	 */
	public function getCurrentTime()
	{
		
		if($this->formattedTimeZone=='GMT')
		{
			return gmdate("r");
		}
		else
		{
		
			$minus = strpos($this->timeZone,'-');
			if($minus !== false)
			{
				$gmt = substr($this->timeZone, ($minus + 1), 5);
				$time_part = explode(':',$gmt);
				$hr_part = (int)$time_part[0] * 60 * 60;
				$min_part = (int)$time_part[1] * 60;
				return gmdate("d-m-Y H:i:s", time() - ($hr_part + $min_part));	
			}
			$plus = strpos($this->timeZone,'+');
			if($plus !== false)
			{
				$gmt = substr($this->timeZone, ($plus + 1), 5);
				$time_part = explode(':',$gmt);
				$hr_part = (int)$time_part[0] * 60 * 60;
				$min_part = (int)$time_part[1] * 60;
				
				return gmdate("d-m-Y H:i:s", time() + ($hr_part + $min_part));						
			}
			return gmdate("d-m-Y H:i:s");
		}
		
	}
	
	protected function beforeSave()
	{		
		if($this->isNewRecord)
		{			
			$this->created_on = time();		
		}
		$this->lastModified = time();
		return parent::beforeSave();
	} 
	
	protected function afterSave()
	{
		if($this->isNewRecord)
		{
			$spId = $this->id;
			$start = '08:00';
			$end = '17:00';
			$this->created_on = time();
			$connection = Yii::app()->db;
			$command = $connection->createCommand("INSERT INTO {{availability}} (day, start, end, serviceproviders_id) VALUES (:day, :start, :end, :spId)");
			for($i = 1; $i <= 7; $i++)
			{
				$command->bindParam(':day', $i, PDO::PARAM_STR);				
				$command->bindParam(':start', $start, PDO::PARAM_STR);				
				$command->bindParam(':end', $end, PDO::PARAM_STR);
				$command->bindParam(':spId', $spId, PDO::PARAM_STR);
				$command->execute();
			}	
					
			$verifications = new Verifications();
			$verifications->serviceproviders_id = $this->id;			
			$verifications->save(false);			
			
			$profile_points = new ProfilePts();
			$profile_points->serviceproviders_id = $this->id;
			$profile_points->save(false);
			
		}
		if($this->skills != '')
		{
			$this->storeSkills();
		}
		if($this->keywords != '')
		{
			$this->storeKeywords();
		}
		return parent::afterSave();
	}
	
	public function behaviors()
	{
		return array(
			'prefixedIds'=>array(
				'class'=>'application.behaviors.PrefixedIdsBehavior',
			),
		);
	}
}