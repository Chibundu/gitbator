<?php
$app = Yii::app();
$baseUrl = $app->request->baseUrl;
$service_packages_dir = $app->params['service_packages_dir'];
$app->clientScript->registerScriptFile($baseUrl."/js/ajax-form.js", CClientScript::POS_HEAD, 'stylesheet');

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'packages-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
 ?>
 
 <div class = "row-fluid">
 
 	<div id="modal" class="giant-reveal-modal">
 		<a class="close-reveal-modal">&#215;</a>
 		<div id = "modal_content"></div>		
	</div>
 
 </div>
 
 <div class = "row-fluid">
 	<div class = "span8">
 	
 		<div class = "row-fluid">
	<div class = "span12">
		<p class="help-block append-bottom">Fields with <span class="required">*</span> are required.</p>
	
			<?php echo $form->errorSummary($model); ?>
	
		<div class = "prepend-top">
			<?php echo $form->textFieldRow($model,'title',array('class'=>'span12','maxlength'=>45)); ?>
		</div>
		<div class = "prepend-top">
		<div class = "row-fluid">
			<?php echo $form->labelEx($model,'description'); ?>
		</div>
		<div class = "row-fluid">
			<span class = "help-block">Be descriptive and concise.</span>
		</div>
		<div class = "row-fluid">
			<?php echo $form->textArea($model,'description',array('class'=>'span12','maxlength'=>500, 'rows'=>8)); ?>
		</div>
		<div class = "row-fluid">
			<?php echo $form->error($model,'description'); ?>
		</div>
		
		</div>
		
		<div id = "service_package_pic_section" class = "prepend-top">
		<div class = "row-fluid">
			<?php echo $form->labelEx($model, 'picture'); ?>
		</div>
		<div class = "row-fluid append-bottom">
		<span class = "help-block">Add a picture that describes the service or expresses the content. The Image must be relevant to your service.</span>
		</div>
		
		<div class = "row-fluid">
			<span>
				<?php echo CHtml::link('<i class = "icon-plus"></i> Add Picture', '#', array('class'=>'btn', 'id'=>'file_btn'))?>
			</span>
			<span id = "file_content" class = "quiet"></span>
		</div>
		
		<div class = "row-fluid" id = "service_package_pic_box" <?php if(!$model->picture):?> style = "display: none;"<?php endif;?>>
			<ul class = "prepend-top thumbnails">
				<li class = "span3">
					<div class = "picture_box mini-rounded">
						<div class = "preview" style = "overflow: hidden; width: 260px; height: 180px;">
							<a href="#" id = "package_picture_link">
	      						<img id = "package_picture" src="<?php echo ($model->picture)? "$baseUrl/$service_packages_dir".$model->picture: ""?>" alt="" style = "max-width: none;">
	    					</a>
	    					<div class = "caption">
	    						<h5 id = "pic_caption"></h5>
	    					</div>
	    				</div>
	    			</div>    			
				</li>
			</ul>		
		</div>
		
		
		
	
		
		</div>
		
		
		<hr>
		<h3>The Service Package Fineprint</h3>
		
		<div class = "row-fluid prepend-top">
		
			<?php echo $form->labelEx($model, 'deliverables'); ?>
		
		</div>
		<div class = "row-fluid">
		<span class = "help-block">Please list one item per line</span>
		</div>
		<div class = "row-fluid">
			<?php echo $form->textArea($model, 'deliverables', array('class'=>'span12 help-block', 'rows'=>8, 'id'=>'Packages_deliverables')); ?>	
		</div>
		<div class = "row-fluid">
			<?php echo $form->error($model, 'deliverables'); ?>	
		</div>
		
	
		
		<div class = "row-fluid prepend-top">
			<?php echo $form->labelEx($model, 'excluded'); ?>
		</div>
		<div class = "row-fluid">
			<span class = "help-block">Please list one item per line</span>
		</div>
		<div class = "row-fluid">
			<?php echo $form->textArea($model, 'excluded', array('class'=>'span12 help-block', 'rows'=>8, 'id'=>'excluded')); ?>
		</div>
		<div class = "row-fluid">
			<?php echo $form->error($model, 'excluded'); ?>	
		</div>
		
		
		<div class = "prepend-top">
			<div class = "row-fluid">
				<?php echo CHtml::label('Choose the category that this service package falls into', 'servicecategories');?>
			</div>
			<div class = "row-fluid">
				<span class = "help-block">This will help buyers find your package</span>
			</div>
			<div class = "row-fluid">
				<?php echo $form->dropDownList($model,'servicecategories_id', CHtml::listData(Servicecategories::model()->findAll(), 'id', 'name'), array('class'=>'span6')); ?>
			</div>
		</div>
		
		<div class = "row-fluid prepend-top">
			<?php echo CHtml::label('How much does this service cost? <span class="required">*</span>', 'cost');?>
		</div>
		
		<div class = "row-fluid">
	
			<div class = "span1">		
				 <span class = "bold highlight" style = "font-size: 1.5em;"><?php echo $symbol; ?></span>
			</div>
			
			<div class = "span2">
				<div class = "row-fluid">
				 <?php echo $form->textField($model,'cost',array('class'=>'span12','maxlength'=>45)); ?>		 
				</div>
				<div class = "row-fluid">
				<?php echo $form->error($model,'cost'); ?>
				</div>
			</div>
			
			<div class = "span3">
				<?php echo $form->dropdownList($model,'cost_type', Packages::costTypes(), array('class'=>'span12','maxlength'=>45)); ?>
			</div>
		
		</div>
		
		<div class = "row-fluid prepend-top">
			<?php echo CHtml::label('How much discount are you willing to offer?', 'discount');?>
		</div>
		<div class = "row-fluid">		
			
			<div class = "span12">
				<div class = "row-fluid">				
				 <?php echo $form->textField($model,'discount', array('class'=>'span2')).' &nbsp;<span = style = "font-size: 1.4em; font-weight: bold;">%</span>'; ?>		
				</div>
				<div class = "row-fluid">
				<?php echo $form->error($model,'discount'); ?>
				</div>
			</div>			
		
		</div>
		
	
		
		<div class = "prepend-top">	
		<?php echo $form->dropdownListRow($model,'delivery', Packages::estimatedTimeOfDelivery(), array('class'=>'span3')); ?>
		</div>
		
		<div class = "prepend-top">
			<div class = "row-fluid">
				<?php echo CHtml::activeLabelEx($model, 'instructions');?>
			</div>
			<div class = "row-fluid">
				<span class = "help-block">Give buyers a head start</span>
			</div>
			<?php echo $form->textArea($model,'instructions',array('class'=>'span12','maxlength'=>500, 'rows'=>8)); ?>
		</div>
		
	
		<div class = "row-fluid">
			<?php echo CHtml::hiddenField("left", "", array('id'=>'left'));?>
			<?php echo CHtml::hiddenField("top", "", array('id'=>'top'));?>
			<?php echo CHtml::hiddenField("width", "", array('id'=>'width'));?>
			<?php echo CHtml::hiddenField("height", "", array('id'=>'height'));?>
			<?php echo CHtml::hiddenField("scaledWidth", "", array('id'=>'scaledWidth'));?>
			<?php echo CHtml::hiddenField("scaledHeight", "", array('id'=>'scaledHeight'));?>
		</div>
	
		<div class="prepend-top">
		<?php if($model->isNewRecord):?>
			<?php echo CHtml::submitButton('Submit For Approval', array('class'=>'nice gold radius button')); ?>
		<?php else: ?>
			<?php echo CHtml::submitButton('Save', array('class'=>'submit nice gold radius button')); ?>
		<?php endif;?>
			<div class = "row-fluid">
				<span class = "help-block">Your submission will be reviewed before it appears on the website.</span>
			</div>
		</div>
	
	</div>
</div>
 		
 	</div>
 </div>
 
 
 

<?php $this->endWidget(); ?>

<?php $app->clientScript->registerScript('package_form','
	
	//get default coordinates
	$.ajax({
		url : \''.$this->createUrl("packages/getCoordinates").'\',
		dataType : "json",
		cache : false,
		success : function(data)
		{
			
			if(data != null){
				$("#package_picture").width(data.scaledWidth);
				$("#package_picture").height(data.scaledHeight);
				$("#package_picture").css({marginLeft: "-"+data.left.toString()+"px"});
				$("#package_picture").css({marginTop: "-"+data.top.toString()+"px"});
				
				$("#left").val(data.left);
				$("#top").val(data.top);
				$("#width").val(data.width);
				$("#height").val(data.height);
				$("#scaledWidth").val(data.scaledWidth);
				$("#scaledHeight").val(data.scaledHeight);
			}	
			
		}
	});
	
	
	
	$("#file_btn, #package_picture_link").click(function(){
		var modal = $("#modal");
		var modal_content = $("div#modal_content");	
		modal.reveal({
			 animation: "fadeAndPop", //fade, fadeAndPop, none
		     animationspeed: 300, //how fast animtions are
		     closeOnBackgroundClick: true, //if you click background will modal close?	
		     dismissmodalclass: "close-reveal-modal"
		});	

		modal_content.html(\'<div class = "loading center">'.CHtml::image("$baseUrl/images/ajax-loader.gif",'loading').'</div>\');
		
		$.ajax({
			url : \''.$this->createUrl('packages/'.(($model->isNewRecord)?'create':'update'), array('id'=>$model->id,'pic_form'=>true)).'\',
			success : function(data){				
				modal_content.html(data);	
			}
		});
	});
	
	$(".close-reveal-modal").click(function(){
		var ias_elements = $(\'[class |= "imgareaselect"]\');
		if(ias_elements.length)
		{
			ias_elements.remove();
		}
	});
		

	var handleErrors = function(data){		
	
		$.each(data.errors, function(idx, val){							
			if($("#Packages_"+idx).length)
			{							
				var parent = $("#Packages_"+idx).parent("div");								
				if(parent.length)
				{
					var errorMessage = parent.find("span.help-inline");
					if(errorMessage.length)
					{						
						errorMessage.remove();
					}									
					parent.append(\'<div class = "row-fluid"><span class = "help-inline">\'+ val +\'</span></div>\');								
				}				
			}
		});
	};

	$("label").addClass("bold");	


	$("#packages-form").delegate("input, textarea, label", "click", function(){
		
		var package_deliverables = $("#Packages_deliverables");
		
		if(this == document.getElementById("excluded") && $("#excluded").val() == "Item #1\nItem #2\nItem #3")
		{
			$("#excluded").val("");
			$("#excluded").removeClass("help-block");			
		}
		else if(this != document.getElementById("excluded") && $("#excluded").val() == "")
		{
			$("#excluded").addClass("help-block");
			$("#excluded").val("Item #1\nItem #2\nItem #3");			
		}		
		
		if(this == document.getElementById("Packages_deliverables") && package_deliverables.val() == "Deliverable #1\nDeliverable #2\nDeliverable #3")
		{
			package_deliverables.val("");
			package_deliverables.removeClass("help-block");			
		}
		else if(this != document.getElementById("Packages_deliverables") && (package_deliverables.val() == "" || package_deliverables.val() == "\n"  || package_deliverables.val() == "\n\n"))
		{
			package_deliverables.addClass("help-block");
			package_deliverables.val("Deliverable #1\nDeliverable #2\nDeliverable #3");			
		}		
		
		
			
	});	


', CClientScript::POS_READY);?>
