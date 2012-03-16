<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	$model->tag,
	'Update',
);
?>

<h3>Update <?php echo $model->tag; ?></h3>
<?php $this->widget('ext.pixelmatrix.EUniform', array('selector'=>':file'));?>
<?php $this->widget('ext.bootstrap.widgets.BootAlert');?>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>