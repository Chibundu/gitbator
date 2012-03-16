<?php
$this->breadcrumbs=array(
	'Packages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Packages','url'=>array('index')),
	array('label'=>'Manage Packages','url'=>array('admin')),
);
?>
<div class = "prepend-top append-bottom">
<h2>Add Service Package</h2>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'symbol'=>$symbol)); ?>