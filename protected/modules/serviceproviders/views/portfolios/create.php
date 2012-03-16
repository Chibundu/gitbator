<?php
$this->breadcrumbs=array(	
	'Profile'=>array('profile/'),
	'Portfolio'=>array('index'),
	'Create',
);

?>

<h2>Create New Portfolio Item</h2>

<?php $this->widget('ext.pixelmatrix.EUniform', array('selector'=>':file'));?>
<div class="prepend-top"><?php $this->widget('ext.bootstrap.widgets.BootAlert');?></div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>