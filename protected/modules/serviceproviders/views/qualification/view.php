<?php
$this->breadcrumbs=array(	
	'Profile'=>array('profile/'),
	'Qualifications'=>array('index'),
	$model->qual.'('.$model->qualificationCategory->name.')',
);

?>

<div class="row-fluid append-bottom">
	<div class="span7">
		<h2>Qualification: <?php echo $model->qual.'('.$model->qualificationCategory->name.')'; ?></h2>
	</div>
	<div class="span5">
		<div class = "right">
		<?php echo CHtml::link('<i class = "icon-plus-sign"></i> Add', array('qualification/create'), array('class'=>'btn'));?>
		 <?php echo CHtml::link('<i class = "icon-pencil"></i> Edit', array('qualification/update', 'id'=>$model->id), array('class'=>'btn'));?> 
		 <?php echo CHtml::link('<i class = "icon-list-alt"></i> Show All', array('qualification/'), array('class'=>'btn'));?>
		</div>
	
	</div>
</div>


<div class="row-fluid"> 	

  <div class="span12 standout no-border">
  	<div class="append-bottom">	
	<?php	
	$holder = $model->holder;
	if($model->sfrom == '' || $model->sfrom == NULL):
			$this->widget('BootDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'teammember_id',
					'type'=>'raw', 
					'value'=>CHtml::link($holder->fullName,array('team/')),
				),		
				'sto',
				'institution',
				'description',
				array('name'=>'isVerified', 'value'=>($model->isVerified)?'Yes':'No'),		
			),
		));
	else:	
			$this->widget('BootDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				array(
					'name'=>'teammember_id', 
					'value'=>$holder->fullName
				),
				'sfrom',		
				'sto',
				'institution',
				'description',
				array('name'=>'isVerified', 'value'=>($model->isVerified)?'Yes':'No'),		
			),
		));
	endif;
	
	?>
	</div>
	</div>
</div>


