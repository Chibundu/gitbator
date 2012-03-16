<h1>Authentication Items</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'access-control-form', 
		'dataProvider'=>$model->search(),
		'filter'=>$model,	
		 'itemsCssClass'=>'table table-striped table-condensed',
    	 'pager' => array('class'=>'bootstrap.widgets.BootPager'),
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
