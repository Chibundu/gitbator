<?php 
	$app = Yii::app();
	$baseUrl  = $app->request->baseUrl;
	$app->clientScript->registerScriptFile("$baseUrl/js/ajax-form.js", CClientScript::POS_HEAD);
	$app->clientScript->registerScriptFile("$baseUrl/js/spin.min.js", CClientScript::POS_HEAD);
	$app->clientScript->registerScriptFile("$baseUrl/js/imgAreaSelect/jquery.imgareaselect.pack.js", CClientScript::POS_HEAD);
	$app->clientScript->registerCssFile("$baseUrl/css/imgAreaSelect/imgareaselect-animated.css");
 ?>

<div id = "saved_message" style = "display:none;" class = "three-quarters center">
<?php $this->widget("ext.SimpleFlash", array("css"=>"alert-success","message"=>'<h3>Thank You!</h3> Your Service Package picture was successfully saved. We will now be returning you to the form shortly..')); ?>
</div>
<div id = "picture_handler">

<?php $form = $this->beginWidget('BootActiveForm', array(
		'id'=>'pic_form'
));?>

	<div id = "picture_div" class = "row-fluid">
		<?php echo $form->fileFieldRow($model, 'picture', array('class'=>'span12'));?>			
	</div>
<?php $this->endWidget();?>
<div class = "row-fluid">
	<div id = "pic_bg" class = "row-fluid">			
		<div class = "span6">					
			<div id = "bigger_image">
			
			</div>					
		</div>
		<div class = "span5">		
			<div class = "prepend-top" id = "smaller_image">				
			</div>			
		</div>					
	</div>
</div>

<div id = "save_section" class = "row-fluid prepend-top" style = "display:none">
	<div class = "one-quarter center"><?php echo CHtml::link('<i class = "icon-folder-close"></i> Save ', "", array('class'=>'btn', 'id'=>'save'));?></div>
</div>
</div>

	

	
	
<?php Yii::app()->clientScript->registerScript('pic_matters','	

	var picFile = $("#Packages_picture");
	
	var pic_path = "";
	
	var imgHeight = 0;
	var imgWidth = 0;
	
	var fixedWidth = 260;
	var fixedHeight = 180;
	
	var maxWidth = 260;
	var maxHeight = 180;
	
	var cWidth = [0,0];
	var cHeight = [0,0];
	
	var deleteOldElements = function()
	{
		var ias_elements = $(\'[class |= "imgareaselect"]\');
		if(ias_elements.length)
		{
			ias_elements.remove();
		}
	};
	
	var goToByScroll = function(element)
	{		
		el = $.browser.opera ? $("html"): $("html, body");
		el.animate({scrollTop : $(element).offset().top}, \'slow\');		
	};
	
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
	
	
	$("#save").click(function(){
		deleteOldElements();
		
		$("#picture_handler").hide();
		$("#saved_message").show();
			
		setTimeout(function(){$(".close-reveal-modal").click();goToByScroll("#service_package_pic_section");},3000);
		var csrf = document.getElementsByName("YII_CSRF_TOKEN");
		var csrf_data = csrf[0].value;
		
		$.ajax({
			url : \''.$this->createUrl("packages/saveCoordinates").'\',
			data : {
				left:$("#left").val(),
				top:$("#top").val(),
				width:$("#width").val(),
				height:$("#height").val(),				
				scaledWidth:$("#scaledWidth").val(),
				scaledHeight:$("#scaledHeight").val(),
				edit:$("#edit").val(),
				YII_CSRF_TOKEN:csrf_data
				},
			success : function(data){
				console.log(data);
			},
			type : "post"
		});
	});
	
	picFile.change(function(){
		var target =  document.getElementById("pic_bg");		
		$(target).show();		
		var spinner = new Spinner({
		  lines: 12, // The number of lines to draw
  		  length: 7, // The length of each line
  		  width: 4, // The line thickness
  		  radius: 10, // The radius of the inner circle
  		  color: "#000", // #rgb or #rrggbb
  		  speed: 2, // Rounds per second
  		  trail: 60, // Afterglow percentage
  		  shadow: false, // Whether to render a shadow
  		  hwaccel: false, // Whether to use hardware acceleration
  		  className: "spinner", // The CSS class to assign to the spinner
  	      zIndex: 2e9, // The z-index (defaults to 2000000000)
  		  top: "auto", // Top position relative to parent in px
  		  left: "auto" // Left position relative to parent in px
  		  }).spin(target);	
  		  
  	
  		  							
		  	$("form#pic_form").ajaxSubmit({
				url : \''.$this->createUrl('packages/'.(($model->isNewRecord)?'create':'update'), array('id'=>$model->id,'ajax'=>true)).'\',		
				dataType : "json",	
				cache : false,			
				success : function(data){
					deleteOldElements();
					if(data.messageType == "error")
					{	
						$("#save_section").hide();
						$(target).hide();						
						$("#Packages_picture").parent("div").next().next().remove(); //Quick fix for repeated errors	
						spinner.stop();														
						handleErrors(data);
					}
					else if(data.messageType == "success")
					{	
						
						$("#save_section").show();					
						imgHeight = data.height;	
						imgWidth = data.width;
						pic_path = data.picture_path;
						
						$(".preview, .picture_box").css({width: fixedWidth, height : fixedHeight});
						$("#package_picture").attr("src", pic_path);
						$("#pic_caption").text($("#Packages_title").val());
						$("#service_package_pic_box").show();

						
						var cWidth = central(maxWidth, fixedWidth);
						var cHeight = central(maxHeight, fixedHeight);						
						var errorMessage = $("#picture_div").find(".help-inline");				
						if(errorMessage.length)
						{
							errorMessage.remove();
						}
						spinner.stop();		
						var bigger_image = $("#bigger_image");										
						bigger_image.html(\'<h4> '.CHtml::image("$baseUrl/images/circle_info.png").' Adjust the selection below to your taste.</h4><span class = "help-block" style = "margin-left: 25px;">Click on the Save button below after editing.</span><div id = "rough" style = "margin-top: 10px; background: #f8f8f8; padding: 10px; border: 1px dashed #ccc; width: \'+maxWidth.toString()+\'px;"><img style = "max-width: none; width:\'+ maxWidth +\'px; height: \'+ data.height +\'px;" id = "original_img" src = "\'+data.picture_path+\'" ></div>\');
						$("#smaller_image").html(\'<div style = "margin-top: 90px; padding: 10px; border: 1px solid #ccc;background: #f8f8f8; width:\'+ (fixedWidth + 2).toString() +\'px;"><div id = "preview" style = "border: 1px solid #ccc; width: \'+ fixedWidth +\'px; height: \'+ fixedHeight +\'px; overflow: hidden;"><img id = "preview_image" style = "max-width:none; height:none;" src = "\'+data.picture_path+\'" ></div></div>\');
						
						$("#original_img").imgAreaSelect({ 
							aspectRatio: fixedWidth.toString() + \':\' +fixedHeight.toString() ,
							maxWidth: maxWidth,
							maxHeight: maxHeight,
							minWidth: 144,
							minHeight: 100,
							x1: cWidth[0],
							y1: cHeight[0],
							x2: cWidth[1],
							y2: cHeight[1], 
							onInit: preview,
							onSelectChange:preview,
							handles: true,							
						});
											
					}				
				}
			});
	});
	
	
	function preview(img, selection) {	  
	   var scaleX =  fixedWidth/ selection.width;  
       var scaleY =  fixedHeight/ selection.height;   
  	   var preview_image = $("#preview_image");
  	   
       $("#preview_image, #package_picture").css({  
        	width: Math.round(scaleX * imgWidth) + "px",  
        	height: Math.round(scaleY * imgHeight) + "px",  
        	marginLeft: "-" + Math.round(scaleX * selection.x1) + "px",  
        	marginTop: "-" + Math.round(scaleY * selection.y1) + "px"  
    	});
    	
    	$("#left").val(Math.round(scaleX * selection.x1));
    	$("#top").val(Math.round(scaleY * selection.y1));
    	$("#width").val(fixedWidth);
    	$("#height").val(fixedHeight);
    	$("#scaledWidth").val(preview_image.width());
    	$("#scaledHeight").val(preview_image.height());
    	$("#edit").val("proceed");
	 }
	 
	 //return an array for central positioning (x1, x2) or (y1, y2) based on what is passed in as parameters
	 //passing in actual - that is the actual width or length and reduced, the reduced width or height 
	 function central(actual, reduced)
	 {
	 	if(reduced <= actual)
	 	{
	 		var begin = Math.round((actual - reduced)/2);
	 		return [begin, (begin + reduced)] ;
	 	}
	 	else
	 	{
	 		return 0;
	 	}
	 }

', CClientScript::POS_HEAD);?>