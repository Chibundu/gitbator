<?php
class ProfileController extends Controller
{	
	public $layout = 'profile';
	
	
	public function actionIndex()
	{		
		$email = Yii::app()->user->id;		
		$serviceProvider = Miscellaneous::getServiceProvider();
		
		$success = '';
		$error = '';
		if(isset($_POST['Serviceproviders']))
		{						
			if(isset($_POST['Serviceproviders']['keywords'])){
					$keywords = $_POST['Serviceproviders']['keywords'];					
					$serviceProvider->setAttribute('keywords', $keywords);
					if($serviceProvider->validate(array('keywords'))){					
						$serviceProvider->storeKeywords();
						$success .= 	"Tags successfully updated!<br>";						
					}
					else
					{
						$error.= "Tags was not be updated! Reason: Unexpected Format<br>";
					}					
			}
			if(isset($_POST['Serviceproviders']['skills'])){
					$skills = $_POST['Serviceproviders']['skills'];					
					$serviceProvider->setAttribute('skills', $skills);
					if($serviceProvider->validate(array('skills'))){					
						$serviceProvider->storeSkills();
						$success .= 	"Skills successfully updated!<br>";						
					}
					else
					{
						$error.= "Skills was not be updated! Reason: Unexpected Format<br>";
					}					
			}
			else if(isset($_POST['Serviceproviders']['displayName'])){	
				$display_name = $_POST['Serviceproviders']['displayName'];
				$serviceProvider->setAttribute('displayName', $display_name);
				if( $serviceProvider->validate(array('displayName'))){				
					$serviceProvider->saveAttributes(array('displayName'));
					$success .= 	"Display name successfully updated!<br>";
				}
				else
				{
					$error.= "Display name was not updated! Reason: Unexpected Format<br>";
				}		
			}
			else if(isset($_POST['Serviceproviders']['businessName'])){
				$business_name = $_POST['Serviceproviders']['businessName'];
				$serviceProvider->setAttribute('businessName', $business_name);		
				if($serviceProvider->validate(array('businessName'))){												
					$serviceProvider->saveAttributes(array('businessName'));
					$success.="Business name was successfully updated!";
				}
				else
				{
					$error.= "Business name was not updated! Reason: Unexpected Format<br>";
				}		
			}
			else if(isset($_POST['Serviceproviders']['tagline'])){	
				$tagline = $_POST['Serviceproviders']['tagline'];
				$serviceProvider->setAttribute('tagline', $tagline);
				if( $serviceProvider->validate(array('tagline')))
				{
						$serviceProvider->saveAttributes(array('tagline'));
						$success.="Tagline was successfully updated!";
				}				
				else
				{
					$error.= "Tagline was not updated! Reason: Unexpected Format<br>";
				}
						
			}
			else if(isset($_POST['Serviceproviders']['overview'])){
				$overview = $_POST['Serviceproviders']['overview'];
				$serviceProvider->setAttribute('overview', $overview);
				if($serviceProvider->validate(array('overview'))){					
					$serviceProvider->saveAttributes(array('overview'));
					$success.="Overview was successfully updated!";
				}
				else
				{
					$error.= "Overview was not updated! Reason: Unexpected Format<br>";
				}		
			}	
			if($success != '')
			{
				Yii::app()->user->setFlash('success', $success);
			}
			if($error != '')
			{
				Yii::app()->user->setFlash('error', $error);	
			}		
			$serviceProvider->refresh();
		}
		
		
		$profile_overview = array();
		$name = Yii::app()->user->name;
		$profile_overview['name']= $name;	
		
		
		$keywords = $serviceProvider->getKeywords();
		$skills = $serviceProvider->getSkills();
		$services = $serviceProvider->getServices();
		$overview = $serviceProvider->overview;		
		$display_name = $serviceProvider->displayName;
		$business_name = $serviceProvider->businessName;
		$tagline = ($serviceProvider->tagline == '')?'-':$serviceProvider->tagline;		
		$subscriptionPackage = $serviceProvider->subscriptionPackage;
		$account_type = $serviceProvider->accountType;		
		$teamLeader = (!empty($serviceProvider->teamLeader))?$serviceProvider->teamLeader:null;
		
		
				
		$profile_overview['tagline']=$tagline;
		$profile_overview['subscription_package']=ucwords($subscriptionPackage);
		$profile_overview['account_type']=ucwords($account_type);
		$profile_overview['display_name']=ucwords($display_name);
		$profile_overview['company']= ucwords($business_name);
		$profile_overview['primary_contact']=($teamLeader!=null)?ucwords($teamLeader->firstname.' '.$teamLeader->lastname):'-';
		$profile_overview['primary_email']=($teamLeader!=null)?$teamLeader->email:'-';
		$profile_overview['services']=($services == '')?'-':$services;
		$profile_overview['skills'] = ($skills == '')?'-':$skills;
		$profile_overview['keywords']=($keywords =='')?'-':$keywords;
		$profile_overview['overview']=($overview == null || $overview == '')?'-':$overview;
		
		$this->render('index', array('profile_overview'=>$profile_overview));
	}
	
	public function actionLogo()
	{
		$model = Miscellaneous::getServiceProvider(); 
		$model->setScenario('upload');		
	  	if(isset($_POST['Serviceproviders']))
        {        	
            $oldLogo = $model->pic;           
            
            if($model->validate(array('pic')))
            {            	
            	 $model->pic = (time())."_".$_FILES['Serviceproviders']['name']['pic']; 
            	if($model->save(false))
            	{
            		Yii::import('application.WideImage.*');
            		//delete old logo
            		@unlink(Miscellaneous::getLogoPath().$oldLogo);
            		$path = Miscellaneous::getLogoPath().$model->pic;
					CUploadedFile::getInstance($model, 'pic')->saveAs($path);
            		//resize the saved image
            		WideImage::load($path)->resize(90)->saveToFile($path);					
            		 
            		Yii::app()->session['logo'] = $model->pic;
            		Yii::app()->user->setFlash('success','Image Successfully Uploaded');
            	}          	            	            	                
            }
            else
            {
            	Yii::app()->user->setFlash('error','Unexpected File Format!');
            }
          
        }
	
		$this->render('editlogo', array('model'=>$model));	
	}
	
	public function actionProfilePic()
	{		
		$model = Teammembers::model()->findByAttributes(array('email'=>Yii::app()->user->id));	
		$model->setScenario('upload');
		if(isset($_POST['Teammembers']))
		{
			$oldPic = $model->profile_picture;			
			if($model->validate(array('profile_picture')))
			{
				$model->profile_picture = (time())."_".$_FILES['Teammembers']['name']['profile_picture'];
				if($model->save(false))
				{
					$path = Miscellaneous::getProfilePicturePath().$model->profile_picture;
					$thumbnailPath = Miscellaneous::getProfileThumbnailPath().$model->profile_picture;
					
					@unlink(Miscellaneous::getProfilePicturePath().$oldPic);
					@unlink(Miscellaneous::getProfileThumbnailPath().$oldPic);
					
					if(CUploadedFile::getInstance($model, 'profile_picture')->saveAs($path)){
					
						if(copy($path, $thumbnailPath))
						{
							$thumbnail = Yii::app()->image->load($thumbnailPath);
							$thumbnail->resize(50,50)->quality(100);
							$thumbnail->save();	
						}					
						$imageSize = getimagesize($path);
						$width = $imageSize[0];
						$height = $imageSize[1];						
						
						//if($width > 210 || $height > 150)
						//{							
							$profile_picture = Yii::app()->image->load($path);
							$profile_picture->resize(210,150)->quality(100);
							$profile_picture->save();
						//}
						
						$sp = Serviceproviders::model()->with('profilePoints')->findByPk($model->serviceproviders_id);
						$profilePoints = $sp->profilePoints;
						if(!$profilePoints->isProfilePic)
						{
							$profilePoints->isProfilePic = true;
							$profilePoints->save(false);
						}
					}					
					Miscellaneous::getTeamMember()->refresh();
					Yii::app()->user->setFlash('success', 'Profile picture successfully updated!');
				}
			}
		}	
		$this->render('editprofilepic', array('model'=>$model));	
	}
	
	public function actionEditDisplayName()
	{
		$sp = Miscellaneous::getServiceProvider();	
		$this->renderPartial('_displayName', array('model'=>$sp));
	}
	
	public function actionEditCompany()
	{
		$sp = Miscellaneous::getServiceProvider();	
	
		$this->renderPartial('_company', array('model'=>$sp));
	}
	
	public function actionEditTagline()
	{		
		$sp = Miscellaneous::getServiceProvider();	
		$this->renderPartial('_tagline', array('model'=>$sp));
	}
	
	public function actionEditKeywords()
	{		
		$sp = Miscellaneous::getServiceProvider();	
		$sp->getKeywords();
		$this->renderPartial('_keywords', array('model'=>$sp));
	}
	public function actionEditSkills()
	{		
		$sp = Miscellaneous::getServiceProvider();	
		$sp->getSkills();
		$this->renderPartial('_skills', array('model'=>$sp));
	}
	
	public function actionEditOverview()
	{		
		$sp = Miscellaneous::getServiceProvider();	
		$this->renderPartial('_overview', array('model'=>$sp));
	}
	
	public function actionAddress()
	{		
		$this->layout = 'column1';
		$location = Miscellaneous::getLocation();
		
		$sp = Serviceproviders::model()->with('profilePoints')->findByPk(Miscellaneous::getSpId());		
		
		$address = $sp->address();
		$postal_address = $sp->postalAddress;
		
		$city = $address->city;
		$province = $address->province;
		
		$p_city = $postal_address->city;
		$p_province = $postal_address->province;
		
		if($city == '')
		{
			$address->city = $location['city'];
		}
		if($province == '')
		{
			$address->province = $location['province'];
		}
		
		if($p_city == '')
		{
			$postal_address->city = $location['city'];
		}
		if($p_province == '')
		{
			$postal_address->province = $location['province'];
		}
		
		$postal_address->city = $location['city'];
		$postal_address->province = $location['province'];
			
		$address->city = $location['city'];
		$address->province = $location['province'];	
			
		if(isset($_POST['ajax']) && $_POST['ajax']==='address-form')
		{
			echo CActiveForm::validate(array($address, $postal_address));
		}
		if(isset($_POST['SpAddresses']))
		{
			$address->attributes = $_POST['SpAddresses'];
			if(isset($_POST['SpPostalAddresses']))
			{
				$postal_address->attributes = $_POST['SpPostalAddresses'];
				
				
				if($address->save() && $postal_address->save())
				{
					$profilePoints = $sp->profilePoints;
					if(!$profilePoints->isAddress)
					{
						$profilePoints->isAddress = true;
						$profilePoints->save(false);
					} 
					$this->redirect(array('profile/services'));				
				}					
			}					
		}
		
		$this->render('address',array('address'=>$address, 'postal_address'=>$postal_address));
	}
	
	public function actionServices()
	{
		$this->layout = 'column1';
		$sp = Miscellaneous::getServiceProvider();	
		$spId = $sp->id;			
		$sc = Servicecategories::model()->with('services', 'serviceCount')->findAll();
		$db = Yii::app()->db;
		
		$selected = array();
		$entered = array();
		
		$myServices = $sp->services;
		
		foreach ($myServices as $myService)
		{
			$selected[] = $myService->id;
		}
				
		$myOtherServices = $sp->otherservices;
				
		foreach ($myOtherServices as $myOtherService)
		{
			$entered[] = array($myOtherService->services, $myOtherService->servicecategories_id);
		}
		
		if(isset($_POST['services_submit'])){			
			
			//delete previous services associated with this user
			$query = "DELETE FROM {{providers_services}} WHERE serviceproviders_id = :spId";
			$command = $db->createCommand($query);
			$command->bindParam(':spId', $spId);
			$command->execute();
			
			$command->reset();		
			
			$query = "DELETE FROM {{otherservices}} WHERE serviceproviders_id = :spId";
			$command->setText($query);
			$command->bindParam(':spId', $spId);
			$command->execute();
							
			if(isset($_POST['services']) && is_array($_POST['services']))
			{		
				$query = "INSERT INTO {{providers_services}} (serviceproviders_id, services_id) VALUES (:spId,:sId)";
				$command->reset();
				$command->setText($query);			
				
				foreach ($_POST['services'] as $id)
				{						
					if(preg_match('/^\d{1,2}$/', $id))
					{
						$sId = $id;
					
						if(!Miscellaneous::exists('serviceproviders_id','serviceproviders_id=:spId AND services_id = :sId', 
						array(':spId'=>$spId, ':sId'=>$sId), '{{providers_services}}')){
							$command->bindParam(':spId', $spId, PDO::PARAM_STR);
							$command->bindParam(':sId', $sId, PDO::PARAM_STR);
	
							$command->execute();
						}					
					}
				}
				
				
			}
			
			if(isset($_POST['other_services']) && isset($_POST['other_categories'])
			 && is_array($_POST['other_categories']) && is_array($_POST['other_services']))
			{			
				
				$query = "INSERT INTO {{otherservices}} (services, servicecategories_id, serviceproviders_id) VALUES (:service, :scId, :spId)";
				$command = $db->createCommand($query);			
						
				$other_services = $_POST['other_services'];
				$other_categories = $_POST['other_categories'];			
				
				
				foreach ($other_services as $key => $other_service)
				{				
					if(preg_match('/^[A-Za-z0-9, ]{2,45}$/', $other_service))
					{					
						if(array_key_exists($key, $other_categories))
						{
							$other_category = $other_categories[$key];	
												
							$command->bindParam(':service', $other_service, PDO::PARAM_STR);
							$command->bindParam(':scId', $other_category, PDO::PARAM_INT);
							$command->bindParam(':spId', $spId, PDO::PARAM_INT);
							$command->execute();
						}
					}
				}
			}
		
			$profilePoints = $sp->profilePoints;
			if(!$profilePoints->isServices)
			{
				$profilePoints->isServices = true;
				$profilePoints->save(false);
			}
			$this->redirect('otherInfo');
			
			
		}
		
		$this->render('services', array('categories'=>$sc, 'myServices'=>$selected, 'myOtherServices'=>$entered));
	}
	
	public function actionOtherInfo()
	{
		$this->layout = 'column1';	
			
		$sp = Miscellaneous::getServiceProvider();
		
		$services = $sp->servicesAndCat;		 
		
		$categories = array();
		
		$tipList = array();
		
		foreach ($services as $service)
		{
			$category_id = $service->category->id;
			if(!in_array($category_id, $categories))
			{				
				$categories[] = $category_id;
				$skills = $service->category->skills;
				foreach ($skills as $skill)
				{
					$tipList[] = $skill->name;
				}
				
			}
		}
		
		sort($tipList, SORT_STRING);
		
		$skillTips = '';
		
		foreach ($tipList as $tip)
		{
			$skillTips.= '"'.$tip.'", ';
		}
		
		$skillTips = trim($skillTips, " ,");		
		
		$teamLeader = $sp->teamLeader; 
	 	if(isset($_POST['Serviceproviders'])){
	 		
	 		
	 		
	 		$sp->attributes = $_POST['Serviceproviders'];
	 		
	 		
	 		if($sp->validate(array('overview', 'skills')))
	 		{		 					
	 			if($sp->save(false))
	 			{
	 				$profilePoints = $sp->profilePoints;
					if(!$profilePoints->isOtherInfo)
					{
						$profilePoints->isOtherInfo = true;
						$profilePoints->save(false);
					}
	 				$this->redirect('companyDetails');
	 			}	 			
	 		}    
	 
	 				
  		}
		
		$this->render('misc', array('model'=>$sp, 'teamLeader'=>$teamLeader, 'skillTips'=>$skillTips));
	}
	
	public function actionCompanyDetails()
	{
		$this->layout = 'column1';	
		$sp = Miscellaneous::getServiceProvider();
		
		
		if(isset($_POST['Serviceproviders']))
		{
			$sp->attributes = $_POST['Serviceproviders'];
			if($sp->validate(array('displayName','businessName','tagline','businessRegType','businessRegNo','regYear','keywords')))
			{				
				if($sp->save(false))
				{
					$profilePoints = $sp->profilePoints;
					if(!$profilePoints->isCompanyDetails)
					{
						$profilePoints->isCompanyDetails = true;
						$profilePoints->save(false);
					}
					Yii::app()->user->setFlash('success', 'Thank you for taking out time to complete your profile! To begin receiving proposals, verify your mobile phone number.
					 <p><center>'.CHtml::link('Verify your mobile phone &raquo;', array('verifications/mobile'),array('class'=>'btn')).'</center></p>');
					$this->redirect('index');
				}
				
			}
		}
		
		
		$services = Services::model()->findAll('1 ORDER BY name ASC');
		$suggestions = '';			
		
		foreach ($services as $service)
		{
			$suggestions.= '"'.$service->name.'", ';
		}
		
		$suggestions = trim($suggestions, " ,");			
		
		$this->render('company_details', array('model'=>$sp, 'suggestions'=>$suggestions));
	}
	
	public function actions()
	{
		return array(
		 'upload'=>array(
                'class'=>'ext.xupload.actions.XUploadAction',
        		'subfolderVar' => 'parent_id',
        		'path' => realpath(Yii::app()->getBasePath()."/../images/uploads"),
            ),
		);
	}
	
	public function filters()
	{
		return array(
			'accessControl',					
		);
	}
	public function accessRules()
	{
		return array(
			array('allow', 'roles'=>array('sp-teamleader','sp-teammember')),
			array('deny', 'users'=>array('*'))
		);
	}	
	
	public function actionAddOtherServices()
	{
		$categories = Servicecategories::model()->findAll();		
		echo '<div class = "row-fluid">';
		echo '<div class = "span4">';
		echo CHtml::hiddenField('otherServiceId[]', '-1');
		echo CHtml::textField('other_services[]', '', array('size'=>60, 'id'=>'other_services[]','class'=>'other_service'));
		echo '</div>';
		echo '<div class = "span4">';
		echo CHtml::dropDownList('other_categories[]', '1', CHtml::listData($categories, 'id', 'name'), array('id'=>'other_categories[]'));
		echo '</div>';		
		echo '<div class = "span4">';
		echo CHtml::link('<i class="icon-minus-sign"></i> Remove', '#', array('class'=>'btn'));
		echo '</div>';
		echo '</div>';
		
	}	
	

	public function actionUploadProfilePic(){
		
		Yii::import('application.WideImage.*');
		$baseUrl = Yii::app()->request->baseUrl;
		$profile_dir = Miscellaneous::getProfilePicturePath();
		$thumbnail_dir = Miscellaneous::getProfileThumbnailPath();
		
		$sp = Miscellaneous::getServiceProvider();
		$teamLeader = $sp->teamLeader;
		
		$old_profile_pic = $teamLeader->profile_picture;		
		
		if(isset($_FILES['pp'])){
			$length = count($_FILES['pp']['name']);
			$length; 
			$i = 0;
			foreach($_FILES['pp']['name'] as $key=>$filename){
				if($i == $length - 1){
					if(move_uploaded_file($_FILES['pp']['tmp_name'][$key],$profile_dir.$filename)){
						
						$profile_pic = time().'_'.$filename;					
											
						$ext = substr($profile_pic, (strrpos($profile_pic, '.') + 1));
						
						$size = $_FILES['pp']['size'][$key];
						
						$max_size = 2 * 1024 *1024; // 2MB
						
						if(!in_array($ext, array('jpg', 'png', 'gif'))){
							throw new CHttpException(400, 'We only accept jpg, png and gif files.');
						}
						else if($size > $max_size){							
							throw new CHttpException(400, 'File should not exceed 2MB in size.');
						}
						else
						{
							$item = '';
							$teamLeader->profile_picture = $profile_pic;
							
							if($teamLeader->save(false)){								
								
								$profilePoints = $sp->profilePoints;
								if(!$profilePoints->isProfilePic)
								{
									$profilePoints->isProfilePic = true;
									$profilePoints->save(false);
								}
								
								@unlink($profile_dir.$old_profile_pic);
								@unlink($thumbnail_dir.$old_profile_pic);		
								
								WideImage::load($profile_dir.$filename)->resize(210,150)->saveToFile($profile_dir.$profile_pic);
								WideImage::load($profile_dir.$filename)->resize(50,50)->saveToFile($thumbnail_dir.$profile_pic);
						
								@unlink($profile_dir.$filename);
								
						
								$item = '<div id = "upload_pro_pic_bar">'.
								CHtml::image(Miscellaneous::getRelativeProfilePicturePath().$profile_pic, 'Profile Picture', array('style'=>'border: 1px dashed #ccc;')).
								'</div>';
							}							
						}						 					
					}				
				
				}
				$i++;
			}
			echo $item;
		}
		
 		
	}
	
	public function actionShowPortfolioForm()
	{
		$this->layout = "plain";	
		$model = new Portfolios('create');
	
		if(isset($_POST['Portfolios']))
		{		
			$sp = Miscellaneous::getServiceProvider();
			$model->attributes=$_POST['Portfolios'];
			$sp_id = $sp->id;
			$model->serviceproviders_id = $sp_id;
			
			if(isset($_FILES['Portfolios']['name']['resource_location']))
			{
				$model->resource_location = (time()).'_'.$_FILES['Portfolios']['name']['resource_location'];
				$model->size = $_FILES['Portfolios']['size']['resource_location']/(1024 *1024);				
			}
			
			$portfolioMaxSize = Yii::app()->params['maxPortfolioSize'];
			if(($sp->portfolioSize + $model->size) <= $portfolioMaxSize){				
				
			// if it is ajax validation request	
				
				if($model->save()){	
					
					$profilePoints = $sp->profilePoints;
					if(!$profilePoints->isPortfolio)
					{
						$profilePoints->isPortfolio = true;
						$profilePoints->save(false);
					}
					
					$path = Miscellaneous::getPortfolioPath().$model->resource_location;					
					$croppedPath = Miscellaneous::getCroppedPortfolioPath().$model->resource_location;
				
					if(CUploadedFile::getInstance($model, 'resource_location')->saveAs($path)&& $model->resourceIsImage)
					{
						if(copy($path, $croppedPath))
						{
							$image = Yii::app()->image->load($croppedPath);
							$image->resize(400,400)->quality(100)->sharpen(50);
							$image->save();
							
						}
					}					
					
					$portfolioInfo = $this->getPortfolioInfo();
					 
					echo 'success*<div class = "alert alert-block alert-success">Thank you for uploading your Portfolio Item - <strong>'.$model->tag.'
					</strong><a href="#" class = "close" data-dismiss="alert">&times;</a></div>^'.$portfolioInfo;
					
					Yii::app()->end();
				}
				else 
				{
					$errors = $model->errors;            
          
					$errorMessage = '<div class="alert alert-error fade in"><strong>The following errors have occured:</strong> <a class="close" data-dismiss="alert" href="#">&times;</a><ul>';
					foreach ($errors as $error)
					{
						foreach ($error as $e){
							$errorMessage.="<li>$e</li>\n";
						}
					}
					$errorMessage.="</ul></div>";
					
					echo "error*$errorMessage";
					Yii::app()->end();
				}
			}
			else
			{
				$errorMessage = '<div class="alert alert-error fade in">Sorry your work sample could not be uploaded because your portfolio size exceeded the maximum size allowed '.$portfolioMaxSize.'MB <a class="close" data-dismiss="alert" href="#">&times;</a></div>';
				echo "error*$errorMessage";
				Yii::app()->end();				
			}
				
		}	
		
		$this->render('_portfolio_form', array('model'=>$model, 'portfolioInfo'=>$this->getPortfolioInfo()));
	}	
	
	
	public function actionRemoveProfilePic()
	{
		$baseUrl = Yii::app()->request->baseUrl;
		$profile_dir = Miscellaneous::getProfilePicturePath();
		$thumbnail_dir = Miscellaneous::getProfileThumbnailPath();
		
		$sp = Miscellaneous::getServiceProvider();
		$teamLeader = $sp->teamLeader;
		$profile_pic = $teamLeader->profile_picture;
		
		if($profile_pic)
		{
			@unlink($profile_dir.$profile_pic);
			@unlink($thumbnail_dir.$profile_pic);
		}

		$teamLeader->profile_picture = NULL;
		if($teamLeader->save(false))
		{
			$profilePoints = $sp->profilePoints;
			if(!$profilePoints->isProfilePic)
			{
				$profilePoints->isProfilePic = true;
				$profilePoints->save(false);
			}
			echo '<div id = "upload_pro_pic_bar" class = "upload_pro_pic_bar"></div>';	
		};		
		
	}
	
	public function actionDeletePortfolioItem($id)
	{
		$portfolioItem  = Portfolios::model()->findByAttributes(array('id'=>$id));
		
		$size = $portfolioItem->size;
		
		if($portfolioItem != null && Yii::app()->user->checkAccess('sp-accountOwner', array('sp_id'=>$portfolioItem->serviceproviders_id))){
			
			//determine if the portfolio size is zero
			$sp_id = $portfolioItem->serviceproviders_id;
			$portfolioItems = Portfolios::model()->findAllByAttributes(array('serviceproviders_id'=>$sp_id));
			if(empty($portfolioItems))
			{
				$sp = Miscellaneous::getServiceProvider();
				$profilePoints = $sp->profilePoints;
				$profilePoints->isPortfolio = false;
				$profilePoints->save(false);				
			}			
			
			if($portfolioItem->delete())
			{
					@unlink(Miscellaneous::getPortfolioPath().$portfolioItem->resource_location);
					@unlink(Miscellaneous::getCroppedPortfolioPath().$portfolioItem->resource_location);
					
					$successMessage = '<div class="append-bottom alert alert-success fade in">Portfolio item deleted successfully.<a class = "close" data-dismiss="alert">&times;</a></div>';
					echo "success*$successMessage*$size";
					Yii::app()->end();
			}
			else
			{
				$errorMessage = '<div class="append-bottom alert alert-error fade in">Sorry we are unable to delete your portfolio item at this time <a class = "close" data-dismiss="alert">&times;</a></div>';
				echo "error*$errorMessage";
				Yii::app()->end();
			}
		}
		else{
			throw new CHttpException(404);
		}
	}
	
	private function getPortfolioInfo()
	{
		$sp_id = Miscellaneous::getSpId();
		$portfolioMaxSize = Yii::app()->params['maxPortfolioSize'];
		$portfolioItems = Portfolios::model()->findAllByAttributes(array('serviceproviders_id'=>$sp_id));
		$numberOfItems = count($portfolioItems);
		
		$portfolioInfo = '';
		$portfolioSize = 0;
		foreach ($portfolioItems as $p)
		{
			$portfolioSize += $p->size;
			$portfolioInfo .= '<div class = "row-fluid"><div class = "span3">'.$p->tag.'</div><div class = "span2">'.number_format($p->size, 2).'MB</div>'
			.'<div class = "span1">'.CHtml::link('<i class = "icon-trash"></i>', array('profile/deletePortfolioItem', 'id'=>$p->id), array('class'=>'remove')).'</div></div>';
		}
		$title = '<div class = "row-fluid"><div class = "span4"><h4>Items(<span id = "noi">'.$numberOfItems.'</span>)</h4></div><div class = "span4"><span class = "right bold"><span id = "moi">'.number_format($portfolioSize,2) .'</span>MB of '.$portfolioMaxSize .'MB</span></div></div>';
		return 	$portfolioInfo = $title.$portfolioInfo;
	}
	
}