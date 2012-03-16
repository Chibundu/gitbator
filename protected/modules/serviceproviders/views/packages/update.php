<?php
$this->breadcrumbs=array(
	'Packages'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

?>

<div class = "append-bottom">
<h2><?php echo $model->title; ?></h2>
</div>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'symbol'=>$symbol)); ?>