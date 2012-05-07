<?php
	$cs = Yii::app()->clientScript;
	$baseUrl = Yii::app()->request->baseUrl;
	
	$cs->registerCss('portfolio-css', '
	.navbar .brand
	{
		padding-top:2px;
		padding-bottom:0px;
	}
	.navbar .nav .active > a
	{
		border-top:5px solid #d0a113;	
		padding-top: 5px;	
	}
	a
	{
		color:#040404;
	}
	a:hover
	{
		color:#d0a113;
	}
');	
	$cs->registerScriptFile($baseUrl.'/js/ajax-form.js', CClientScript::POS_HEAD);
 ?>
 
<div class = "row-fluid append-bottom">
	<div class = "span10" id = "itemActions">
	
	</div>
</div>
 
 <div class = "row-fluid append-bottom">
	<div class = "span10" id = "portfolioItems">
	<?php echo $portfolioInfo; ?>
	</div>
</div>
 
 
 
<div class="row-fluid standout">
<span class = "right"><a href="#" class = "close close-link">&times;</a></span>
<div class = "row-fluid prepend-top">
	<div class = "span10" id = "flashMessage">
	
	</div>
</div>

<div class="span10">
<?php 

	$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'portfolios-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data', 'name'=>'portfolio-form'),
	));
	 
?>

	<p class="help-block append-bottom">Fields with <span class="required">*</span> are required.<br /><br />
	<span class="hint note">Upload any work samples(images/documents) here.
	Supported file types include: jpg,png,gif,pdf,ppt,doc,docx.
	</span>
	</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo CHtml::hiddenField('id', $model->id); ?>
	<?php echo CHtml::hiddenField('ajax', 'portfolios-form'); ?>
	<?php echo $form->fileFieldRow($model, 'resource_location', array('class'=>'span7 pop', 'data-original-title'=>'Associated Graphics', 'data-content'=>'Remember what they say about pictures being worth a thousand words? Yes! Capture the attention of Vcubator entrepreneurs with a descriptive image of this portfolio Item.')); ?>
	
	<?php echo $form->textFieldRow($model,'tag',array('maxlength'=>45, 'class'=>"span7 pop", 'data-original-title'=>'Title', 'data-content'=>'Please enter a caption for this portfolio item')); ?>	
	<?php echo $form->textFieldRow($model,'associated_link',array('maxlength'=>45, 'class'=>"span7 pop",'data-original-title'=>'Associated Link', 'data-content'=>'Do you have a website that can further illustrate this portfolio item? Please enter the link to such a site here. For example: http://www.example.com')); ?>	
	<?php echo $form->textAreaRow($model,'Description',array('cols'=>'50', 'rows'=>'10','class'=>"span7 pop", 'data-original-title'=>'Portfolio Description', 'data-content'=>'In a few words(less than 500 characters), please describe this portfolio item.')); ?>
	<div>
		<?php echo CHtml::link('Enter', array('#'), array('id'=>'submit', 'name'=>'enter_btn', 'class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>

<?php 

$cs->registerScript('portfolio-utility', '

	var submitButton = $("#submit");
	var portfolioItems = $("#portfolioItems");
	var pop = $(".pop");
	
	$("div.standout .close-link").click(function(){
		$("div.standout").hide();
	});
	
	
	submitButton.click(function(e){
		$("#portfolios-form").ajaxSubmit(function(r){
			var msg = r.split("*");
			var isError = false;
			if(Object.prototype.toString.call(msg) == "[object Array]"){				
				if(msg[0] == "error")
				{
					isError = true;
				}
				if(isError)
				{
					$("#flashMessage").html(msg[1]);
				}
				else
				{
					var successMessage = msg[1].split("^");
					//console.log(successMessage);
					$("#flashMessage").html(successMessage[0]);
					$("#portfolioItems").html(successMessage[1]);
					
					$("#Portfolios_tag").val("");
					$("#Portfolios_resource_location").val("");
					$("#Portfolios_associated_link").val("");
					$("#Portfolios_Description").val("");
				}
			}
			
		});	
		return false;
	});
	
	portfolioItems.delegate(".remove", "click", function(e){
		
		e.preventDefault();
		
		var elem = $(e.target).parent();
		
		$.ajax({			
			cache : false,
			url : elem.attr("href"),
			success : function(data)
			{
				var msg = data.split("*"); 
				if(Object.prototype.toString.call(msg) == "[object Array]"){
					$("#itemActions").html(msg[1]);
					elem.parent().parent().remove();
					
					var noi = Number($("span#noi").text());//the former number of items
					var moi = Number($("span#moi").text());// the former size of items
					
					var riz = Number(msg[2]); //the size of the removed item
					
					//console.log(noi);
					//console.log(moi);
					//console.log(riz);
					
					$("span#moi").text(Math.round((moi - riz) * 100)/100);
					$("span#noi").text((noi - 1));	

					
					
				}
			}
			
		});
	});
	
	if(pop.length)
	{
		pop.each(function(){
			$(this).popover();
		});				
	}	
	
', CClientScript::POS_READY);?>