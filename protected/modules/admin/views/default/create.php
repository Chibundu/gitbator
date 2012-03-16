<?php
$this->breadcrumbs=array(
	'Serviceproviders'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Serviceproviders','url'=>array('index')),
	array('label'=>'Manage Serviceproviders','url'=>array('admin')),
);
?>

<h1>Create Serviceproviders</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>