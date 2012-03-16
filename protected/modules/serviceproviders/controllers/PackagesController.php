<?php

class PackagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(			
			array('allow',
				'roles'=>array('sp-teamleader', 'sp-teammember') 
			),			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{			
		$this->layout = "plain";
		if(Yii::app()->request->getIsAjaxRequest()){
			if(isset($_GET['sample']) && is_numeric($_GET['sample']))
			{				
				$this->render('view_samples', array('sample'=>$_GET['sample']));
			}
			else
			{				
				$this->render('view', array(
					'model'=>$this->loadModel($id),
				));
			}
		}
		else
		{
			throw new CHttpException(403, 'Please do not repeat this request!');
		}
	}
	
	public function actionSaveCoordinates()
	{
		if(isset($_POST))
		{
			$_SESSION['coordinates'] = array(
			 'left'=>$_POST['left'],
			 'top'=>$_POST['top'],
			 'width'=>$_POST['width'],
			 'height'=>$_POST['height'],
			 'scaledHeight'=>$_POST['scaledHeight'],
			 'scaledWidth'=>$_POST['scaledWidth']
			);
		}	
	}
	
	public function actionGetCoordinates()
	{		
		if(isset($_SESSION["coordinates"]))
		{
			$coordinates = $_SESSION['coordinates'];
			echo CJSON::encode($coordinates);			
		}	
		
	}
	
	/**	 
	 * Handles ajax update for the Service Package creation
	 * @param Packages $model
	 */
	private function handleAjaxPictureUpload($model)
	{
	
		if(isset($_GET['ajax']))
		{						
			if(isset($_FILES['Packages']['name']['picture']) && $_FILES['Packages']['name']['picture'] != '')
			{
				$baseUrl = Yii::app()->request->baseUrl;
				$package_dir = Yii::app()->params['service_packages_dir'];
			
				if($model->picture)
				{
					$_SESSION['oldPic'] = $package_dir.$model->picture;		
				}
			
				
				$model->picture =  time().'_'.$_FILES['Packages']['name']['picture'];	
				
				if($model->validate(array('picture')))
				{					 
				
					Yii::import('application.WideImage.*');
				
					
					$picture_path = $package_dir.$model->picture;
									
					if(CUploadedFile::getInstance($model, 'picture')->saveAs($picture_path))
					{
						WideImage::load($picture_path)->resize( 360, 250, 'outside' )->saveToFile($picture_path);					
						
						
						$imageSize = getimagesize($picture_path);
						
						
						$height = 0;
						$width = 0;
						
						if($imageSize)
						{
							$width = $imageSize[0];
							$height = $imageSize[1];							
						}
						
							
						
					}
					
					if(isset($_SESSION['newPic']))
						@unlink($package_dir.$_SESSION['newPic']);
				
					$_SESSION['newPic'] = $model->picture;						
					
					
					echo CJSON::encode(CMap::mergeArray(array('messageType'=>'success'), array('picture_path'=>"$baseUrl/$picture_path"), array('height'=>$height, 'width'=>$width)));
				
				}
				else
				{
					echo CJSON::encode(CMap::mergeArray(array('messageType'=>'error'), array('errors'=>$model->errors)));
				
				}
			}
			
			
			Yii::app()->end();
		}	
	
	}
	

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{		
		$model=new Packages;		
		
		if(isset($_GET['pic_form']) && (bool)$_GET['pic_form'] == true)
		{
			$this->layout = 'plain';
			$this->render('picture_resize', array('model'=>$model));
			Yii::app()->end();
		}
		
		$this->handleAjaxPictureUpload($model);
		
		$sp = Miscellaneous::getServiceProvider();
		$model->serviceproviders_id = $sp->id;
		
		$currency = $sp->currency;
		
		$model->currencies_id = $currency->id;	
		$model->deliverables = "Deliverable #1\r\nDeliverable #2\r\nDeliverable #3";	
		$model->excluded = "Item #1\r\nItem #2\r\nItem #3";
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Packages']))
		{
			$model->attributes=$_POST['Packages'];
			if(isset($_SESSION['newPic'])){	
				$model->picture = $_SESSION['newPic'];
			} 	
			if($model->save())
			{		
				
				$picture = $model->picture;
															
				if(isset($_SESSION['newPic'])){	
					unset($_SESSION['newPic']);
				} 	
				if(isset($_SESSION['oldPic']))
				{
					@unlink($_SESSION['oldPic']);
					unset($_SESSION['oldPic']);
				}				
				
				
				if($picture != "default/service_package.png"){
				
					//Yii::import('application.WideImage.*');
					
					$left = (int)$_POST['left'];
					$top = (int)$_POST['top'];
					$width = (int)$_POST['width'];
					$height = (int)$_POST['height'];
					$scaledWidth = (int)$_POST['scaledWidth'];
					$scaledHeight = (int)$_POST['scaledHeight'];
					
					$app = Yii::app();
					$package_dir = $app->params['service_packages_dir'];
					$picture_path = $package_dir.$picture;
					
					if($left > 0 || $top > 0){						
						
						//we resize the image to scaled size and crop				
						//WideImage::load($picture_path)->resize($scaledWidth, $scaledHeight, 'fill')->crop($left, $top, $width, $height)->saveToFile($picture_path);
						//Create Larger version
						//WideImage::load($picture_path)->resize(375)->saveToFile("$package_dir/larger/$picture");
						$image = Yii::app()->image->load($picture_path);
						$image->resize($scaledWidth, $scaledHeight, Image::NONE);
						$image->crop($width, $height, $top, $left);
						$image->save();
						
						if(copy($picture_path, $package_dir."larger/$picture"))
						{
							$larger_image = Yii::app()->image->load($package_dir."larger/$picture");
							$larger_image->resize(375,260)->quality(100)->sharpen(30);
							$larger_image->save();							
						}
						
					}	

					$_SESSION['justAddedPackage']=$model->id;
					
					Yii::app()->user->setFlash('success', '<h3>New Service Package Created</h3> <p>You have successfully created a new Service Package titled <b>'. $model->title .'</b>. We will consider your offer and let you know once it is approved.</p>');
				}
				
				$this->redirect('index');
			}
				
		}

		$this->render('create',array(
			'model'=>$model,
			'symbol'=>$currency->symbol,
		));
	}	
	

	

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		
		$model = $this->loadModel ( $id );
		$oldPic = $model->picture;
		
		if(isset($_GET['pic_form']) && (bool)$_GET['pic_form'] == true)
		{
			$this->layout = 'plain';
			$this->render('picture_resize', array('model'=>$model));
			Yii::app()->end();
		}
				
		$this->handleAjaxPictureUpload($model);		
		
		
		$deliverables = $model->packageDeliverables;
		$excluded_items = $model->packageExcluded;
			
		$model->deliverables = "Deliverable #1\r\nDeliverable #2\r\nDeliverable #3";
		$model->excluded = "Item #1\r\nItem #2\r\nItem #3";		
			
		if (! empty ( $deliverables )) {
			$model->deliverables = '';
			$buffer = '';
			
			foreach ( $deliverables as $deliverable ) {
				$buffer .= $deliverable->deliverable . "\n";
			}
			
			$model->deliverables = $buffer;
		}
		
		if (! empty ( $excluded_items )) {
			$model->excluded = '';
			$buffer = '';
			foreach ( $excluded_items as $excluded ) {
				$buffer .= $excluded->item . "\n";
			}
			$model->excluded = $buffer;
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
	
		if (isset ( $_POST ['Packages'] )) {
			
			if(isset($_SESSION['newPic'])){	
				$model->picture = $_SESSION['newPic'];
			} 
			$model->attributes = $_POST ['Packages'];		
			if ($model->save ()) {
				
				$picture = $model->picture;
				
				if(isset($_SESSION['newPic'])){	
					unset($_SESSION['newPic']);
				} 	
				if(isset($_SESSION['oldPic']))
				{
					@unlink($_SESSION['oldPic']);
					unset($_SESSION['oldPic']);
				}			
				
				if($picture != "default/service_package.png"){
					
					Yii::import('application.WideImage.*');
				
					$left = (int)$_POST['left'];
					$top = (int)$_POST['top'];
					$width = (int)$_POST['width'];
					$height = (int)$_POST['height'];
					$scaledWidth = (int)$_POST['scaledWidth'];
					$scaledHeight = (int)$_POST['scaledHeight'];
					
					
					
					$app = Yii::app();
					
					$package_dir = $app->params['service_packages_dir'];
					$picture_path = $package_dir.$picture;
					
					if($left > 0 || $top >0){						
						//we resize the image to scaled size and crop				
						WideImage::load($picture_path)->resize($scaledWidth, $scaledHeight, 'fill')->crop($left, $top, $width, $height)->saveToFile($picture_path);
						//Create Larger version but first delete old larger version
						@unlink("$package_dir/larger/$oldPic");
						WideImage::load($picture_path)->resize(375)->saveToFile("$package_dir/larger/$picture");
					}
					$_SESSION['justAddedPackage']=$model->id;
					
					Yii::app()->user->setFlash('success', '<h3>Service Package Upldate</h3> <p>You have successfully updated your Service Package titled <b>'. $model->title .'</b>. We will consider your offer and let you know once it is approved.</p>');
					$this->redirect('index', false);
				}
				
				
			}
			
			 
		}
		
		$this->render ( 'update', array ('model' => $model, 'symbol' => $model->currency->symbol ) );
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{		
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$title = $model->title;
			
			$_SESSION['deletedTitle'] = $title;
							
			$model->delete();
			echo CJSON::encode(array('messageType'=>"success", 'title'=>$title));
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if(isset($_SESSION['coordinates']))
		{
			unset($_SESSION['coordinates']);
		}
		if(isset($_SESSION['oldPic'] )){				
			unset($_SESSION['oldPic']);			
		}
		if(isset($_SESSION['newPic'] )){
			@unlink(Yii::app()->params['service_packages_dir'].$_SESSION['newPic']);		
			unset($_SESSION['newPic']);			
		}	
		$packages = Miscellaneous::getServiceProvider()->packages;
		$this->render('index', array('packages'=>$packages, 'name'=>Miscellaneous::getTeamMember()->firstname));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Packages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Packages']))
			$model->attributes=$_GET['Packages'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Packages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='packages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
