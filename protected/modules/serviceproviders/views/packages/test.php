<?php
	$app = Yii::app();
	$baseUrl = $app->request->baseUrl; 
?>

<?php 
	$app->clientScript->registerCssFile("$baseUrl/css/imgAreaSelect/imgareaselect-animated.css");
	$app->clientScript->registerScriptFile("$baseUrl/js/imgAreaSelect/jquery.imgareaselect.pack.js", CClientScript::POS_HEAD);
	
?>
<?php
echo CHtml::image($baseUrl."/images/splash-1.jpg", "", array("id"=>"img1"));
?>

<?php Yii::app()->clientScript->registerScript('test', '
	$("#img1").imgAreaSelect({ maxWidth: 200, maxHeight: 150, handles: true });
', CClientScript::POS_READY);?>