<?php
$this->breadcrumbs=array(
	'Qualifications'=>array('index'),
	'Create',
);
?>

<div class = "row-fluid">
<div class = "span4">
<h2>Add Qualification</h2>
</div>
<div class ="span8">
<div class = "right">
	 <?php echo CHtml::link('<i class = "icon-eye-open"></i> Qualifications', array('qualification/'), array('class'=>'btn'));?>
	 <?php echo CHtml::link('<i class = "icon-eye-open"></i> Team Members', array('team/'), array('class'=>'btn'));?> 	
	</div>
</div> 
</div>
	
	
	

 
 
 <div class="row-fluid">
 <div class="span12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
</div>