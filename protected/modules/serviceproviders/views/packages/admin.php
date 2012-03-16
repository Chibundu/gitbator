<?php
$this->breadcrumbs=array(
	'Packages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Packages','url'=>array('index')),
	array('label'=>'Create Packages','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('packages-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Packages</h1>

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

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'packages-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'description',
		'picture',
		'cost',
		'cost_type',
		/*
		'delivery',
		'instructions',
		'serviceproviders_id',
		'servicecategories_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
