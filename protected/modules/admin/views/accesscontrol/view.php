<?php
$this->breadcrumbs=array(
	'Authitems'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Authitem','url'=>array('index')),
	array('label'=>'Create Authitem','url'=>array('create')),
	array('label'=>'Update Authitem','url'=>array('update','id'=>$model->name)),
	array('label'=>'Delete Authitem','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->name),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Authitem','url'=>array('admin')),
);
?>

<h1>View Authitem #<?php echo $model->name; ?></h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'type',
		'description',
		'bizrule',
		'data',
	),
)); ?>
