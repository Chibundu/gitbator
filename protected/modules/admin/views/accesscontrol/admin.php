<?php
 $cs=Yii::app()->clientScript;
$cs->registerScript('menuTreeClick', "
	jQuery('#authitem-treeview a').click(function() {
		alert('Node #'+this.id+' was clicked!');
		return false;
	});
");
?>

<h1>Authentication Items</h1>

<div class = "row-fluid">
<div class = "standout">
<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'access-control-form', 
		'dataProvider'=>$model->search(),
		'filter'=>$model,		
    	 'pager' => array('class'=>'bootstrap.widgets.BootPager'),
		 'itemsCssClass'=>'table table-condensed table-striped',
		'columns'=>array(			
			'name',
			 array(
			 	'name'=>'type',
			 	'value'=>'$data->itemType',
			 	'filter'=>array('Operation','Task','Role'),
			),
			 array(
			 	'name'=>'bizrule',
			 	'filter'=>false,
			 ),
			  array(
			 	'name'=>'description',
			 	'filter'=>false,
			 ),
			  array(
			 	'name'=>'data',
			 	'filter'=>false,
			 ),			 
			 array(
			 	'class'=>'CButtonColumn',			 			 	
			 )	
			 		 
		),
));?>
</div>
</div>