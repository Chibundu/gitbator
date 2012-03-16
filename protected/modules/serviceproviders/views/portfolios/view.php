<?php
 $baseUrl = Yii::app()->request->baseURL;
 $cs = Yii::app()->clientScript; 
 
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Portfolio'=>array('portfolios/'),
	$model->tag,
);
?>

<h2><?php echo $model->tag; ?></h2>


	<div class="row-fluid prepend-top">	
 
 	<div class = "span2">
 	<?php echo CHtml::link('<i class = "back"></i> Back', array('portfolios/'), array('class'=>'btn'));?> 
 	</div>
 	<div class = "span10">
 	<div class="btn-group right">
 		<?php echo CHtml::link('Manage', '#', array('class'=>'btn'));?>
 		<?php echo CHtml::link('<span class = "caret"></span>', '#', array('class'=>'btn dropdown-toggle', 'data-toggle'=>'dropdown'));?>
 		<ul class = "dropdown-menu">
 			<li><?php echo CHtml::link('<i class = "icon-plus"></i> Add', array('portfolios/create'));?></li>
 			<li><?php echo CHtml::link('<i class = "icon-pencil"></i> Edit', array('portfolios/update', 'id'=>$model->id));?></li>
 			<li><?php echo CHtml::link('<i class = "icon-trash"></i> Remove', array('portfolios/delete', 'id'=>$model->id), array('confirm' => 'Are you sure you want to delete this portfolio item?'));?></li>
 		</ul>	
 	</div>	
	</div>	 
	
	  </div>
	
	 <div class = "row-fluid ">  
	  <div class="span12  prepend-top append-bottom">
	 <?php 	  	
	  	switch($model->resourceType){	  		
			case "pdf":	
				echo CHtml::link(CHtml::image($baseUrl.'/images/pdf.png', $model->tag, array('title'=>$model->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('portfolios/show', 'id'=>$model->id), array('target'=>'_blank')); 
		 	break;
		 	
			case "ppt":	
			case "pptx":
		 		echo CHtml::link(CHtml::image($baseUrl.'/images/pp.png', $model->tag, array('title'=>$model->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('portfolios/show', 'id'=>$model->id), array('target'=>'_blank')); 
		 	break;	
		 		
			case "docx":	
			case "doc":
				echo CHtml::link(CHtml::image($baseUrl.'/images/word.png', $model->tag, array('title'=>$model->tag, 'style'=>"opacity: 1; width: 200px; display: block; ")), array('portfolios/show', 'id'=>$model->id), array('target'=>'_blank')); 
			break;
			
			default:	
				echo CHtml::link(CHtml::image(Miscellaneous::getRelativeCroppedPortfolioPath().$model->resource_location, $model->tag, array('title'=>$model->tag)), array('portfolios/show', 'id'=>$model->id), array('target'=>'_blank')); 
			break;			
	}        
	?>	
	<p class="note hint">Click to see <?php echo $model->tag ?></p>  	
	  </div>
	  </div>
	
	  <div class = "row-fluid prepend-top">
	  <div class = "span3">
	  <span class = "bold"> Website </span>
	  </div>
	  <div class="span9" style="text-align: justify">	
	  	<?php echo CHtml::link($model->associated_link, $model->associated_link, array('target'=>'_blank'));  ?>
	  </div>
	  </div>
	  
	    <div class = "row-fluid prepend-top">
	  <div class = "span3">
	  <span class = "bold"> Brief Description </span>
	  </div>
	  <div class="span9" style="text-align: justify">	
	<?php echo $model->Description; ?>
	  </div>
	  </div>	   
	   
