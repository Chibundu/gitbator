<h3><?php echo $category; ?></h3>
<?php if($category=='Other'):?>
<p class="help-block note">
Please ensure that the service you are about registering is not already listed in some other category. When choosing a category below, select 'Other' if the category to which your new service belongs is not listed or is not accurately described by any of the categories in the dropdown.
</p>
<?php endif;?>
<div class="dec_box prepend-top standout">

<?php
$this->widget('ext.bootstrap.widgets.BootAlert');
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action'=>array('services/update'),	
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('style'=>'margin-bottom:0px;'),
	
	));
 ?>
 
 <?php
  $numServices = count($services);
  if($numServices > 0 || $category == 'Other'){
  	
  		if($category == 'Other')
  		{    
  			$otherService = new Otherservices(); 			
  			echo $form->textFieldRow($otherService,'services', array('class'=>'span7'));
  			echo $form->dropDownListRow($otherService,'servicecategories_id', CHtml::listData(Servicecategories::model()->findAll(), 'id', 'name'), array('class'=>'span5'));
  			echo $form->textAreaRow($otherService, 'description', array('class'=>'span7','rows'=>6));
  			echo '<br><span class="help-block">Please describe your service if you selected \'Other\' as the Category (Optional)</span><br>';
  		}
  	
  		
		 foreach($services as $index => $service):?>
		 
		 <div   class="dec_row  
		<?php if(($index % 2) == 0) echo 'alt'?>
		"> 		 
		        <?php
		       
		        	echo $form->hiddenField($service, "[$index]id");
		        	echo $form->checkBox($service, "[$index]selected", array('checked'=>(in_array($service->id, $myServiceIds)))). " ".$service->name;
		        ?>
		        
		    </div>
		 
		 <?php
		  endforeach;
  }
  else
  {
  	echo "Sorry, there are no services in this category.";
  }
  ?>

<div class="form-actions" style="margin-bottom:0px;"><?php echo CHtml::submitButton('Submit', array('class'=>'nice gold radius button', 'id'=>'submit'));?></div>
 <?php $this->endWidget();?>
 </div>
  
