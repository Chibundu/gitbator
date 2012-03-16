<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Team'=>array('index'),	
	'Update '.$model->firstname.' '.$model->lastname,
);

$this->menu=array(
	array('label'=>'List Teammembers', 'url'=>array('index')),
	array('label'=>'Create Teammembers', 'url'=>array('create')),
	array('label'=>'View Teammembers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Teammembers', 'url'=>array('admin')),
);
?>

<h2>Update Teammember: <?php echo $model->firstname.' '.$model->lastname; ?></h2>
<div class="row">
<div class="ten columns">
<?php $this->widget("ext.bootstrap.widgets.BootAlert"); ?>
</div>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>