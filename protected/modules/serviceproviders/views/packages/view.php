<?php
$this->breadcrumbs=array(
	'Packages'=>array('index'),
	$model->title,
);
$app = Yii::app();
$baseUrl = $app->request->baseUrl;
?>

<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/bootstrap.min.css');?>
<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/bootstrap-responsive.min.css');?>
<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/custom.css');?>
		
	<h2><?php echo $model->title; ?></h2>

	<?php $this->widget('ext.ServicePackageWidgets.SnapShot', array('model'=>$model));?>
		  
		
		  
