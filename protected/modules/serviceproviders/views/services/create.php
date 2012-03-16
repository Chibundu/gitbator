<?php
$this->breadcrumbs=array(
	'Services'=>array('index'),
	'Create',
);

?>

<h3>Add Services</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'categories'=>$categories)); ?>