<?php
$baseUrl = Yii::app()->request->baseURL;
$this->breadcrumbs=array(
	'Profile'=>array('profile/'),
	'Public Profile',
);
?>

 
 <?php $this->widget('ext.public.SingleProfile', array('sp'=>$sp));?>
 