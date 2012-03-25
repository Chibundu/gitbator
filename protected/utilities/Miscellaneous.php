<?php

class Miscellaneous {
	/**
	 * gets key=>value array which can be used for dropdown menu from a database table
	 * built for Yii framework
	 * @param string $id_field, field which will be used as the key
	 * @param string $other_field, field which should contain the value to be displayed
	 * @param string $table, the table to perform the operation on - leave out table prefix.
	 * @author Chibundu Mbagwu
	 */
	public static function getDbList($id_field, $other_field, $table)
	{
		$sql = "select $id_field, $other_field from {{".$table."}}";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		$dataReader = $command->query();
		
		$result = array();
		while(($row = $dataReader->read())!== false)
		{			
			$id = $row["$id_field"];
			$value = $row["$other_field"];			
			$result[$id] = $value;			
		}
		if(count($result)>0)
		{
			return $result;
		}
		return null;		
	}
	
	/**
	 * generates a set of random characters (letters and digits)
	 * @param int $max the total number of characters
	 * @author Mbagwu Chibundu
	 */
	public static function generateRandom($max)
	{	
		$pick = array('A','B','C','D', 'E','F','G','H','I','J','K','L','M','N','O'
					,'P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5',
					'6','7','8','9','0','a','b','c','d','e','f','g','h','i','j','k',
					'l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		
		$activation_code = '';
		for($i = 0; $i < $max; $i++){
			$index = rand(0, 61);
			$activation_code.= $pick[$index];
		}
		return $activation_code;	
	}
	
	/**	 
	 * Deletes data from a table
	 * @param string $condition e.g column=:value
	 * @param array $params an array of parameters to be bound e.g array(':value'=>$value) 
	 * @param string $table table to delete from
	 */
	public static function executeDelete($condition, $params, $table)
	{
		$query = "DELETE FROM $table WHERE $condition";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($query);
		foreach ($params as $key=>$value){
			$command->bindParam($key, $value);
		}
		return $command->execute();		
	}
	/**
	 * carries out insert statements - based on Yii Active record
	 * @param array $data an associative array containing data to be inserted
	 * where the keys(or index) represent the columns and the values represent 
	 * the values to be inserted
	 * @param string $table the table into which the data is to be inserted
	 * @author Mbagwu Chibundu
	 */
	public static function executeInsert($data, $table)
	{
		 $placeholders = str_repeat('?, ', count($data));
		 $placeholders = substr($placeholders, 0, (strlen($placeholders)-2));		 		 
		  
		 $columns = implode(', ',array_keys($data));
		 foreach ($data as $key=>$value)
		 {
		 	$data[$key] = get_magic_quotes_gpc()? $value: addslashes($value);		 	
		 }
		 $values = "'".implode("','", $data)."'";
		 
 		 $sql = "INSERT into $table ($columns) VALUES($values)";
 		 
 		 $connection = Yii::app()->db; 		 
		 $command = $connection->createCommand($sql);
		 $inserted = $command->execute();				
		 
		 return $inserted;		
	}
	
	/**
	 * Carries out multiple inserts 
	 * @param array $data, 2-dimensional array of data to be inserted
	 * @param string $table, the table into which the data is to be inserted
	 */
	public static function multiExecuteInsert($data, $table)
	{
		$inserted = 0;
		foreach ($data as $field => $value)
		{
			if(is_array($value))
			{
				$inserted += self::executeInsert($value, $table);
			}
		}
		return $inserted;
	}
	
	/**
	 * Checks whether a supplied value exists in a given table	 
	 * @param string $column
	 * @param string $condition
	 * @param array $params
	 * @param string $table
	 */
	public static function exists($column, $condition='', $params=null, $table)
	{
		$where = "";
		if($condition != '' && $condition != null)
		{		
			if(is_array($params))
			{
				if(count($params > 0))
				{
					foreach($params as $key => $value)
					{
						$key = addslashes($key);
						$value = addslashes($value);
						$condition = str_ireplace($key, "'".$value."'", $condition);
					}
				}
			}
			$where.= "WHERE  $condition";
		}
		$sql = "SELECT $column from $table $where";		
		$connection = Yii::app()->db;
		$command = $connection->createCommand($sql);
		return $command->queryScalar() != null;		
	}
	
	public static function getProfileCompleteness()
	{
		$completeness = 0;
		
		$profilePoints = ProfilePts::model()->findByAttributes(array('serviceproviders_id'=>self::getSpId()));
	 	
		if($profilePoints){
		 	if($profilePoints->isProfilePic)
		 	{
		 		$completeness = $completeness + 10;
		 	}
		 	if($profilePoints->isPortfolio)
		 	{
		 		$completeness = $completeness + 10;
		 	}
		 	if($profilePoints->isQualification)
		 	{
		 		$completeness = $completeness + 10;
		 	}
		 	if($profilePoints->isServices)
		 	{
		 		$completeness = $completeness + 10;
		 	}
		 	if($profilePoints->isOtherInfo)
		 	{
		 		$completeness = $completeness + 20;
		 	}
		 	if($profilePoints->isCompanyDetails)
		 	{
		 		$completeness = $completeness + 20;
		 	}
		 	if($profilePoints->isAddress)
		 	{
		 		$completeness = $completeness + 20;
		 	}
		}
	 	return $completeness;
	}
	
	/**	 
	 * Returns the location
	 */
	public static function getLocation() {
		
	
				
		$location = Yii::app()->session['location'];		
		
		if($location == null){
			
			$iplocator = new IP2LocationLite();
			$iplocator->setKey($key='d7e990cf781f5cf4e84e05c3d4de00ecf0cb9f97c6e73eb28f579ba260e21c32');
			$locations = $iplocator->getCity($_SERVER['REMOTE_ADDR']);
			
			if($locations!= null && !empty($locations))
			{
				
				$city = $locations['cityName'];
				$country = $locations['countryName'];
				$province = $locations['regionName'];
				if($city == '-')
				{
					$city = 'Johannesburg';
				}
				else 
					$city = ucwords(strtolower($city));
				if($province == '-')
				{
					$province = 'Gauteng';
				}
				else 
					$province = ucwords(strtolower($province));
					
				if($country == '-')
				{
					$country = 'SOUTH AFRICA';
				}
				
				$location = array('city'=>$city,'province'=>$province,'country'=>$country);
				
			
			}
			else
			{
				$location = array('city'=>'Johannesburg','country'=>'SOUTH AFRICA','province'=>'Gauteng');
			}
			
			Yii::app()->session['location'] = $location;			
		}
		
		return $location;
	}	
	
	public static function getTime()
	{	
		$sp = self::getServiceProvider();
		return $sp->currentTime;		
	}	
	
	/**	 
	 * @return array profile_overview
	 */
	public static function getSPSummaryData()
	{
		$serviceProvider = self::getServiceProvider();
		$profile_overview = array();
		
		$tagline = ($serviceProvider->tagline == '')?'-':$serviceProvider->tagline;
		$business_name = $serviceProvider->businessName;
		$profile_overview['logo_available']=($serviceProvider->pic == null || $serviceProvider->pic == '')?false:true;
		$profile_overview['logo'] = self::getRelativeLogoPath().$serviceProvider->pic;
		$profile_overview['company']= ucwords($business_name);		
		$profile_overview['location']=array('city'=>$serviceProvider->address->city,'country'=>$serviceProvider->address->country);
		$profile_overview['time']=self::getTime();
		$profile_overview['id'] = $serviceProvider->normalizeSPId();		
		$profile_overview['tagline']=$tagline;		
		$profile_overview['teamMembers'] = $serviceProvider->teamMembers;
		
		$profile_overview['emailVerified'] = ($serviceProvider->verification->email)? true : false;
		$profile_overview['phoneVerified'] = ($serviceProvider->verification->phone)? true: false;
		$profile_overview['identityVerified'] = ($serviceProvider->verification->identity)? true : false;
		$profile_overview['credentialVerified'] = count($serviceProvider->verifiedQualifications);
		$profile_overview['verification_count'] = $serviceProvider->getVerificationCount(); 
		
		return $profile_overview;
	}
	
	/**	 
	 * @return array containing key value pairs of: 
	 * Service provider model (key is 'sp')
	 * Logged in team member (key is 'tm')
	 * An array of all teammembers (key is 'tms')
	 * Team Leaders email(key is 'tlEmail')
	 */
	public static function getLayoutInfoBox()
	{
		$app = Yii::app();	
		$user = $app->user;
		$username = $user->id;
		$sp = $app->session['sp'];		
		if($sp == NULL){			
			if($user->isGuest){					
				$app->request->redirect($app->baseUrl.$user->loginUrl[0]);
			}
			else
			{					
				$tm = Teammembers::model()->findByAttributes(array('email'=>$username));
				$sp = $tm->serviceProvider;
				$app->session['sp'] = $sp;								
			}
		}
		else
		{			
			$sp->refresh();			
		}		
	
		$teamMembers = $sp->teamMembers;	
		
		$profilePoints = $sp->profilePoints;
		
	 	$completeness = 0;
	 	$uncompleted = array();
	 	if($profilePoints->isProfilePic)
	 	{
	 		$completeness = $completeness + 10;
	 	}
	 	else
	 	{
	 		$uncompleted[] = array('Upload profile picture[10%]', array('profile/profilePic'));
	 	}
	 	
	 	if($profilePoints->isPortfolio)
	 	{
	 		$completeness = $completeness + 10;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Upload Portfolio[10%]', array('portfolios/create'));
	 	}
	 	
	 	if($profilePoints->isQualification)
	 	{
	 		$completeness = $completeness + 10;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Add Qualification[10%]', array('qualification/create'));
	 	}
	 	
	 	if($profilePoints->isServices)
	 	{
	 		$completeness = $completeness + 10;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Add Services[10%]', array('services/update'));
	 	}
	 	
	 	if($profilePoints->isOtherInfo)
	 	{
	 		$completeness = $completeness + 20;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Add Skills, Overview[20%]', array('profile/otherInfo'));
	 	}
	 	
	 	if($profilePoints->isCompanyDetails)
	 	{
	 		$completeness = $completeness + 20;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Add Company Details[20%]', array('profile/companyDetails'));
	 	}
	 	
	 	if($profilePoints->isAddress)
	 	{
	 		$completeness = $completeness + 20;
	 	}
		else
	 	{
	 		$uncompleted[] = array('Add Address[20%]', array('profile/address'));
	 	}
	 	
	 	
		$tm = null; //the logged in team member
		$tms = array();// an array of team members
		$tlEmail = '';//the email of the team leader
		
		
		
		foreach ($teamMembers as $teamMember) {
					
			if($username == $teamMember->email)
			{
				$tm = $teamMember;	
			}
			if($teamMember->isTeamLeader)
			{
				$tlEmail = $teamMember->email;
			}
			$tms[]=$teamMember;			
		}
		
		return array('sp'=>$sp, 'tm'=>$tm, 'tms'=>$tms, 'tlEmail'=>$tlEmail, 'completeness'=>$completeness, 'uncompleted'=>$uncompleted);
		
	}
	
	/**	 
	 * @return Serviceproviders model instance of currently logged in Service provider
	 */
	public static function getServiceProvider()
	{		
		$sp = Yii::app()->session['sp'];		
		if($sp == NULL){			
			if(Yii::app()->user->isGuest){					
				Yii::app()->request->redirect(Yii::app()->baseUrl.Yii::app()->user->loginUrl[0]);
			}
			else
			{		
				
				$username = Yii::app()->user->id;
				$tm = Teammembers::model()->findByAttributes(array('email'=>$username));
				$sp = $tm->serviceProvider;
				Yii::app()->session['sp'] = $sp;								
			}
		}
		else
		{			
			$sp->refresh();			
		}
		return $sp;
		
		
	}
	
	/**	 
	 * @return Users model instance of currently logged in Entrepreneur
	 */
	public static function getEntrepreneur()
	{		
		$ent = Yii::app()->session['ent'];		
		if($ent == NULL){
			if(Yii::app()->user->isGuest())
			{
				Yii::app()->user->logout();
				Yii::app()->request->redirect(Yii::app()->baseUrl.Yii::app()->user->loginUrl[0]);
			}			
			$username = Yii::app()->user->id;
			$user = Authdetails::model()->findByAttributes(array('username'=>$username));
			if($user == NULL){
				Yii::app()->user->logout();
				Yii::app()->request->redirect(Yii::app()->baseUrl.Yii::app()->user->loginUrl[0]);
			}
			else
			{
				self::grantAccess($user);
				$ent = Yii::app()->session['ent'];				
			}				
		}
		else
		{			
			$ent->refresh();			
		}
		return $ent;
		
		
	}
	
	
	/**	 
	 *  assigns the roles and settings associated with a particular user
	 * @param Authdetails $user
	 */

	
	/**	 
	 * @return Teammembers currently logged in team member else redirects to login page	 
	 */
	public static function getTeamMember()
	{
		if(isset(Yii::app()->session['teammember'])){			
				$teamMember = Yii::app()->session['teammember'];
				$teamMember->refresh();		
				return $teamMember;
		}
		else 
		{
			if(Yii::app()->user->isGuest){				
				Yii::app()->request->redirect(Yii::app()->baseUrl.Yii::app()->user->loginUrl[0]);
			}
			else
			{		
				$username = Yii::app()->user->id;
				$teamMember = Teammembers::model()->findByAttributes(array('email'=>$username));
				if($teamMember == NULL){
					Yii::app()->user->logout();
					Yii::app()->request->redirect(Yii::app()->baseUrl.Yii::app()->user->loginUrl[0]);
				}
				else 
				{
					return $teamMember;
				}
								
			}
		}
	}
	
	public static function getIdentityDocsPath()
	{
		return dirname(__FILE__).'/../../identitydocs/';
	}
	
	/**	 
	 * @return absolute path to logo e.g c:\wamp\www\Vcubator\profilepics\thumbnails\
	 */
	public static function getLogoPath()
	{
		return dirname(__FILE__).'/../../logos/';
	}
	
	/**	 
	 * @return string absolute path to profile picture e.g c:\wamp\www\Vcubator\profilepics\thumbnails\
	 */
	public static function getProfilePicturePath()
	{
		return dirname(__FILE__).'/../../profilepics/';
	}
	
	/**	 
	 * @return string absolute path to profile picture thumbnail e.g c:\wamp\www\Vcubator\profilepics\thumbnails\
	 */
	public static function getProfileThumbnailPath()
	{
		$profilePicPath = self::getProfilePicturePath();
		return $profilePicPath.'thumbnails/';
	}
	/**	 
	 * @return string return portfolio path e.g c:\wamp\www\Vcubator\portfolio\
	 */
	public static function getPortfolioPath()
	{
		return dirname(__FILE__).'/../../portfolios/';
	}
	/**	 
	 * @return string relative path to Portfolios e.g /Vcubator/portfolios/
	 */
	public static function getRelativePortfolioPath()
	{
		return Yii::app()->request->baseUrl."/portfolios/";
	}
	/**	 
	 * @return string return portfolio path e.g c:\wamp\www\Vcubator\portfolio\cropped\
	 */
	public static function getCroppedPortfolioPath()
	{
		return dirname(__FILE__).'/../../portfolios/cropped/';
	}
	/**	 
	 * @return string relative path to Portfolios e.g /Vcubator/portfolios/cropped/
	 */
	public static function getRelativeCroppedPortfolioPath()
	{
		return Yii::app()->request->baseUrl."/portfolios/cropped/";
	}
	/**	 
	 * @return string relative path to profile picture e.g /Vcubator/profilepics/
	 */
	public static function getRelativeProfilePicturePath()
	{
		return Yii::app()->request->baseUrl."/profilepics/";
	}
	/**
	 * @return string relative path to profile picture thumbnail e.g /Vcubator/profilepics/
	 */
	public static function getRelativeProfileThumbnailPath()
	{
		return self::getRelativeProfilePicturePath()."thumbnails/";
	}
	/**	 
	 * @return string relative path to logo e.g /Vcubator/logos/
	 */
	public static function getRelativeLogoPath()
	{
		return Yii::app()->request->baseUrl."/logos/";
	}
	/**	 
	 * @return string profile picture identifier e.g profile.png
	 */
	public static function getProfilePicture()
	{			
		$profile_picture = self::getTeamMember()->profile_picture;
		return $profile_picture;
	}
	/**	 
	 * @return string logo image identifier e.g logo.png
	 */
	public static function getLogo()
	{
		$logo = Yii::app()->session['logo'];
		if($logo == null || $logo == '')
		{
			$sp = self::getServiceProvider();
			$logo = Yii::app()->session['logo'] = $sp->pic;			
		}
		return $logo;
		
	}
	/**	 
	 * @return string id of currently logged in Service Provier
	 */
	public static function getSpId()
	{
	  if(isset(Yii::app()->session['spId'])){
	  	$spId = Yii::app()->session['spId'];
	  } 
	  else
	  {					
		$spId = Miscellaneous::getServiceProvider()->id;		
		Yii::app()->session['spId'] = $spId;
	  }		
		return $spId;		
	}
	
	

	
		
}

?>