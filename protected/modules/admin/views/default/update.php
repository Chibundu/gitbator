<?php
$this->breadcrumbs=array(
	'Serviceproviders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Serviceproviders','url'=>array('index')),
	array('label'=>'Create Serviceproviders','url'=>array('create')),
	array('label'=>'View Serviceproviders','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Serviceproviders','url'=>array('admin')),
);
?>

<h1>Update Serviceproviders <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>