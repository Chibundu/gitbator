<?php
$this->breadcrumbs=array(
	'Serviceproviders'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Serviceproviders','url'=>array('index')),
	array('label'=>'Create Serviceproviders','url'=>array('create')),
	array('label'=>'Update Serviceproviders','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Serviceproviders','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Serviceproviders','url'=>array('admin')),
);
?>

<h1>View Serviceproviders #<?php echo $model->id; ?></h1>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'businessName',
		'businessRegNo',
		'businessRegType',
		'displayName',
		'tagline',
		'vatNo',
		'taxNo',
		'pic',
		'accountType',
		'regYear',
		'overview',
		'paymentTerms',
		'subscriptionPackage',
		'earningsToDate',
		'rating',
		'purse',
		'sizerange_id',
		'currency_id',
		'created_on',
		'lastModified',
		'timeZone',
		'isAvailable',
		'isActivated',
		'activationCode',
	),
)); ?>
