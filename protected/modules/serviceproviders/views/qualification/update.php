<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Qualifications'=>array('index'),
	$model->qual.'('.$model->qualificationCategory->name.')'=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Qualification','url'=>array('index')),
	array('label'=>'Create Qualification','url'=>array('create')),
	array('label'=>'View Qualification','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Qualification','url'=>array('admin')),
);
?>

<h3>Update Qualification: <?php echo $model->qual.'('.$model->qualificationCategory->name.')'; ?></h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>