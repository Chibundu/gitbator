<?php
$this->breadcrumbs=array(
	'Authitems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Authitem','url'=>array('index')),
	array('label'=>'Manage Authitem','url'=>array('admin')),
);
?>

<h1>Create Authitem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>