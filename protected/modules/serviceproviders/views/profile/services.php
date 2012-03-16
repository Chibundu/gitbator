<?php
	/**	 
	 * @var CClientScript
	 */ 
	$cs = Yii::app()->clientScript;		
?>
<div class = "row-fluid">
<div class = "span12">


<div class = "row-fluid">
	<div class = "span12">
<?php $this->widget('ext.indicator.Tracker.ProgressTracker', array(
		'levels'=>array('Address Data', 'Register Services', 'Other Information', 'Company Details'),
		'current'=>2,
))
;?>
<h1>Services</h1>
	</div>
</div>

<div class = "row-fluid">
	<div class = "span10 prepend-top">
		<?php $this->widget('ext.SimpleFlash', array('message'=>'<h3>Great! We are making Progress. Now let\'s add the service category you expertise covers</h3>
		You can choose up to 5 service categories from which you will be notified whenever there is a job request that matches the category.'))?>
	</div>
</div>
	
	<div class = "row-fluid">
		<div class = "span10 prepend-top">
	<p class = "help-block">If you can't find your service, click on the 'Add Other Services' button below. If you intend offering more than one service that are not listed, keep clicking on the 'Add Other Services' button until you have finished entering them. 
	After selecting and/or entering all your services, click on the continue button on the 'Save & Continue' button at the end of the page.</p>
		</div>
	</div>
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'otherservices-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array(
			'onSubmit'=>'return validateServices();',
		),
	));?>
	
	
	<div class = "row-fluid prepend-top">
	<div class = "span2">
	<?php echo CHtml::link('<i class = "icon-plus-sign"></i> Add Other Services', '#', array('class'=>'btn', 'id'=>'addaservice'));?>
	</div>
	</div>
	
	<div class = "row-fluid prepend-top">
		<div class = "span10">
			<div id = "other_services_section" class="remove_container standout">
			
				<?php foreach($myOtherServices as $myOtherService):?>
					<div class = "row-fluid">
						<div class = "span4">
							<?php echo CHtml::hiddenField('otherServiceId[]', '-1'); ?>
							<?php echo CHtml::textField('other_services[]', $myOtherService[0], array('size'=>60, 'id'=>'other_services[]','class'=>'other_service')); ?>
						</div>
						<div class = "span4">
							<?php echo CHtml::dropDownList('other_categories[]', $myOtherService[1], CHtml::listData($categories, 'id', 'name'), array('id'=>'other_categories[]'));?>
						</div>
						<div class = "span4">
							<?php echo CHtml::link('<i class="icon-minus-sign"></i> Remove', '#', array('class'=>'btn')); ?>
						</div>
					</div>
				<?php endforeach;?>
				
			</div>
		</div>
	</div>
	
	<div id = "max" class = "errorMessage">
		
	
	
	</div>
	
	<?php $maxCol = 3; $colCount = 0; $mod = $maxCol -1; ?>
	<?php foreach($categories as $category):?>
	<?php if($category->name != 'Other'):?>
	<div class = "row-fluid prepend-top">
		<div class = "span12">
		<h3><?php $total = $category->serviceCount; echo $category->name." ($total)";?></h3>
		
		<?php $services = $category->services;  ?>
		<?php
			 for($i = 0; $i < $total; $i++ ):
			 	$sId = $services[$i]->id
		
		?>
		<?php 
			//at the start of a new row ($i % $maxCol == 0), open and close the row div if not at the extremes($i == 0 or $i == $total)
			if($i == 0)
			{
				echo '<div class = "row-fluid">';
			}
		?>
		<div class = "span4"><?php echo CHtml::checkBox('services[]', (in_array($sId, $myServices)), array('id'=>'services[]', 'value'=>$sId, 'style'=>'margin-right: 5px;')).$services[$i]->name; ?></div>
		<?php 
			if((($i % $maxCol) == $mod) && ($i < ($total-1)))
			{
				echo '</div><div class = "row-fluid">';
			}
		?>
			
				
				
		<?php
			if($i == ($total - 1))
			{
				echo '</div>';
			} 
			endfor;
		?>
		</div>
	</div>
	<?php endif;?>
	
	<?php endforeach;?>
	
	



<div class = "row-fluid">
	<div class = "span11">
		<div class = "form-actions">
			<div class = "row">
				<div class="span4">
				<?php echo CHtml::link('&laquo; Back', array('address'), array('class'=>'btn')) ?>
				&nbsp; &nbsp; &nbsp;
				<?php echo CHtml::submitButton('Save & Continue', array('class'=>'nice gold radius button', 'id'=>'services_submit', 'name'=>'services_submit'));?>
				</div>
			</div>
		</div>
	</div>
</div>

</div>
</div>
<?php $this->endWidget();?>


<?php $cs->registerScript('remove_other_services', '	
	var remove_container = $(".remove_container");	
	if(remove_container.length)
	{
		remove_container.delegate(".btn","click", function(e){			
			$(e.target).parent().parent().remove();
			if(remove_container.children().length == 0)
			{
				remove_container.removeClass("standout");
			}
			$("#max").empty();
		});
	}
	
	var addAService = $("#addaservice");
	if(addAService.length)
	{
		addAService.click(function(){	
			remove_container.addClass("standout");
			$.ajax({
				\'url\':\'addOtherServices\',
				\'success\':function(data)
							{
								if((($(\'.other_service\').length + $("input:checked").length)) < 5)
								{									
									$(".row-fluid .span12 .remove_container").append(data);
								}
								else
								{
									$("#max").html(\'<span class="red">Maximum number of services reached. You cannot add more than 5</span>\');
								}
								
							}
			});			
			
		});
	}
	
', CClientScript::POS_READY);?>