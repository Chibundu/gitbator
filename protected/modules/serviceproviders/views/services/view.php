<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Services','url'=>array('index')),
	array('label'=>'Create Services','url'=>array('create')),
	array('label'=>'Update Services','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Services','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Services','url'=>array('admin')),
);
?>

<h1>View Services #<?php echo $model->id; ?></h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
		'categories_id',
	),
)); ?>
