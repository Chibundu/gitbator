<?php
$this->breadcrumbs=array(
	'Qualifications'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Qualification','url'=>array('index')),
	array('label'=>'Create Qualification','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('qualification-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Qualifications</h3>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.grid.BootGridView',array(
	'id'=>'qualification-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'qual',
		'sfrom',
		'sto',
		'ref',
		'description',
		/*
		'isVerified',
		'serviceProviders_id',
		'qualificationCategory_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
