<?php
$this->breadcrumbs=array(
	'Teammembers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Teammembers', 'url'=>array('index')),
	array('label'=>'Create Teammembers', 'url'=>array('create')),
	array('label'=>'Update Teammembers', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Teammembers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Teammembers', 'url'=>array('admin')),
);
?>

<h1>View Teammembers #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'firstname',
		'lastname',
		'email',
		'phone1',
		'phone2',
		'profile_picture',
		'isTeamLeader',
		'serviceproviders_id',
	),
)); ?>
