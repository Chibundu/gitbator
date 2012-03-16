<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Team'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Teammembers', 'url'=>array('index')),
	array('label'=>'Manage Teammembers', 'url'=>array('admin')),
);
?>

<h2>Add Team Member</h2>
<div class="row">
<div class="ten columns">
<?php $this->widget("ext.bootstrap.widgets.BootAlert"); ?>
</div>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>