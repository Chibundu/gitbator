<?php 
$profile_pic_form = $this->beginWidget("BootActiveForm", array(
	'action'=>array('profile/uploadProfilePic'),
	'htmlOptions'=>array(
		'id' => 'profile_pic_form',
	),
));
$baseUrl = Yii::app()->request->baseUrl;
$cs  = Yii::app()->clientScript;

$cs->registerScriptFile($baseUrl.'/js/jquery.tagsinput.min.js', CClientScript::POS_HEAD);
$cs->registerCss('tag-input','
div.tagsinput { border:1px solid #CCC; background: #FFF; padding:5px; width:auto; height:100px; overflow-y: auto;}
div.tagsinput span.tag { border: 1px solid #a5d24a; -moz-border-radius:2px; -webkit-border-radius:2px; display: block; float: left; padding: 5px; text-decoration:none; background: #cde69c; color: #638421; margin-right: 5px; margin-bottom:5px;font-family: helvetica;  font-size:13px;}
div.tagsinput span.tag a { font-weight: bold; color: #82ad2b; text-decoration:none; font-size: 11px;  } 
div.tagsinput input { width:80px; margin:0px; font-family: helvetica; font-size: 13px; border:1px solid transparent; padding:5px; background: transparent; color: #000; outline:0px;  margin-right:5px; margin-bottom:5px;
 -webkit-transition: none; -moz-transition: none;-ms-transition: none; -o-transition: none; transition: none;  -webkit-box-shadow: none;  -moz-box-shadow: none; box-shadow: none;
}
div.tagsinput input:focus{  border-color: none;  -webkit-box-shadow: none;  -moz-box-shadow: none;  box-shadow: none;}
div.tagsinput div { display:block; float: left; } 
.tags_clear { clear: both; width: 100%; height: 0px; }
.not_valid {background: #FBD8DB !important; color: #90111A !important;}
');

?>
<?php $this->widget('ext.indicator.Tracker.ProgressTracker', array(
		'levels'=>array('Address Data', 'Register Services', 'Other Information', 'Company Details'),
		'current'=>3,
))
;?>

<h1>Other Info</h1>

<div class = "row-fluid">
	<div class = "span8 prepend-top">
		<?php $this->widget('ext.SimpleFlash', array('message'=>'<h3>Now just a few steps left. We will like to know you a little.</h3>
		People find it easy to connect to people with pictures, so just upload a pciture of you, a compelling overview and your skill set to get the jobs rolling!'))?>
	</div>
</div>

<div class = "span12  append-bottom prepend-top">
	

	
	<div class = "row-fluid"> 
		<div class = "span12  append-bottom prepend-top">
	
		<h3>Profile Picture</h3>
		
			<div class = "span3">
				<div class = "row" id = "profile_pic_container"  style="border-left: 5px solid #efefef; float:left; padding-left: 20px;" >
					<?php $profilePicture = $teamLeader->profile_picture; if($profilePicture != '' && $profilePicture!=NULL):?>
					<div id = "upload_pro_pic_bar" class = "picture_bar not_empty">
					<?php 
						echo CHtml::image(Miscellaneous::getRelativeProfilePicturePath().$profilePicture, 'Profile Picture',array());					
					?>
					</div>
					<?php else:?>
					<div id = "upload_pro_pic_bar" class = "picture_bar"></div>
					<?php endif;?>
				</div>		
			</div>
			
			
			<div class = "span5 topborder bottomborder">
				<div class = "row-fluid" style="padding: 10px;">
					<span class = "muted">Uploading you picture will help yo get noticed by client and it gives a personal touch to your company</span>
				</div>
				 <div class = "row-fluid">
				 <?php 
					$this->widget('CMultiFileUpload',array(
					'model'=>$teamLeader,
		 		    'attribute'=>'profile_picture',
		  			'name'=>'pp',  	  		
		    		'max'=>1,
					'options'=>array(				
						'onFileSelect'=>'function(e, v, m)
						{									
							var fixed = $("#profile_pic");
							var profile_pic_container = $("#profile_pic_container");
							var priorContent = profile_pic_container.html();
							profile_pic_container.html(\''.CHtml::image($baseUrl.'/css/loading.gif', 'Loading..', array('style'=>'padding-top: 50px;')).'\');			
							
												
								$("#profile_pic_form").ajaxSubmit({
										error:function(e)
										{
											$("#pp_error").text(e.responseText);
											profile_pic_container.html(priorContent);
										},
										
										success:function(r)
										{
											$("#profile_pic_container").html(r);
											if(fixed.length)
											{
												fixed.html(r);							
											}	
										}
									}
									);					
							
						}',
						
						'onFileRemove'=>'function(e, v, m){
							$("#profile_pic_container").html(\''.CHtml::image($baseUrl.'/css/loading.gif', 'Loading..', array('style'=>'padding-top: 50px;')).'\');
						
							$.get("'.$this->createUrl('profile/removeProfilePic').'", function(r){
								$("#profile_pic_container").html(r);
							});
						}',
					),
		    		'remove'=>Yii::t('ui','Remove'), 
				    //'denied'=>'', message that is displayed when a file type is not allowed
				    //'duplicate'=>'', message that is displayed when a file appears twice
		    		'htmlOptions'=>array('size'=>25),
				));
				?>
				 </div>
				 
				 <div class = "row-fluid">
				 	<div id = "pp_error" class = "span5 errorMessage">
				 		
				 	</div>
				 </div>
				
			</div>
			
	
		<?php $this->endWidget(); ?>
		</div>
		</div>
		<?php 
		$form = $this->beginWidget("BootActiveForm");
		?>
		
		<div class = "row-fluid  append-bottom">
			<div class = "span12">
			<h3 class = "prepend-top">Overview</h3>
			<blockquote>
			<?php echo $form->textArea($model, 'overview', array('id'=>'overview', 'class'=>'span8 pop',  'data-content'=>'In a few sentences, please let us know what you do and why customers should patronize your business.', 'data-original-title'=>"Brief Description",'style'=>'height: 150px;',));?>
			<div class = "row">
				<div class = "span12">
				<?php echo $form->error($model, 'overview');?>
				</div>
			</div>
			</blockquote>
			</div>
		</div>
		
		
		
		
		
		
		<div id = "skill_container" class = "row-fluid prepend-top">
		
			<div class = "row-fluid">
				<div class = "span1"><h3>Skills</h3></div>
				<div class = "span7 help-block">Use the suggestion box showing on the right or enter skills separated by commas</div>
			</div>
			
			<div class = "row-fluid">
				<div class = "span8" name = "skills">
					<blockquote>
					<?php echo $form->textField($model, 'skills', array('id'=>'skills', 'class'=>'skills'));?>
					<div class = "row">
						<div class = "span12">
							<?php echo $form->error($model, 'skills');?>
						</div>
					</div>
					</blockquote>
				</div>
				<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 						'options'=>array(
     	   					'cursor'=>'move',
   		 					),    
						));
						?>
				<div class = "sugg_cont">
					<div class = "sugg_box">
						<div style = "font-size: 16px; font-weight: bold; text-align: center; padding-bottom: 10px;">Browse Skills
							<span class="close"><?php echo CHtml::link('&times;', '#skills_tag');?></span>
						</div>	
				
						<div class = "search_box_con"><?php echo CHtml::textField('skills_search', ' ', array('id'=>'search_box')); ?></div>
				
					
						<div class="left_arrow_border"></div>
						<div class="left_arrow"></div>
						<div>
							<div class="tinyscroll">
								<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
								<div class="viewport">
									 <div class="overview">
										<ul class = "inside">					
										</ul>                   
									</div>
								</div>
							</div>	
						</div>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</div>
			
		
		</div>
		
		
		
		<h3 class = "prepend-top">Portfolio</h3>
		<p class = "help-block">Maximum cummulative size of portfolio should be <?php echo Yii::app()->params['maxPortfolioSize']?>MB</p>
		<div class = "row-fluid prepend-top">
			<div class = "span8">
				<blockquote>
				<?php echo CHtml::link('<i class = "icon-plus-sign"></i> Add Sample Work', '#', array('class'=>'btn', 'id'=>'portfolio'));?>
				</blockquote>
			</div>
		</div>
		
		<div class = "row-fluid">
			<div class = "span9">
				<div id = "portfolio-section">
				</div>		
			</div>
		</div>
		
		
		<div class = "row-fluid">
		<div class = "span10">
			<div class = "form-actions">	
					<?php echo CHtml::link('&laquo; Back', array('/serviceproviders/profile/services'), array('class'=>'btn'));?>
					&nbsp;&nbsp;&nbsp;
					<?php echo CHtml::submitButton('Save & Continue', array('class'=>'nice gold radius button', 'name'=>'submit'));?>			
			</div>
		</div>
		</div>
		
		
		<?php $this->endWidget();?>
		
		</div>
	


<?php

$cs->registerScriptFile($baseUrl.'/js/ajax-form.js', CClientScript::POS_HEAD);
$cs->registerScript('tag-skills', '
	$("#skills").tagsInput();
', CClientScript::POS_READY);

?>

<?php

$cs->registerScript('portfolio-manager','
	var goToByScroll = function(element)
	{		
		el = $.browser.opera ? $("html"): $("html, body");
		el.animate({scrollTop : $(element).offset().top}, \'slow\');		
	};
	var showForm = function(){
	var portfolio_btn = $("#portfolio");

	
	if(portfolio_btn.length)
	{									
		portfolio_btn.click(function(){
			
			$("#portfolio-section").html(\''.CHtml::image($baseUrl.'/css/loading.gif', 'Loading..', array('style'=>'padding-left: 45%')).'\');			
			$.ajax({
				url  : "'.$this->createUrl("profile/ShowPortfolioForm").'",
				type : "GET",
				success: function(response){
				var portfolio_sec = $("#portfolio-section");
					if(portfolio_sec.length)
					{
						portfolio_sec.html(response);

						goToByScroll("#portfolio-section");	
					}					
				}
			});			
			
		});

		
	}
};
showForm();
',CClientScript::POS_READY);






if($skillTips != ''){
$cs->registerScript('pop_ups','
	var pop = $(".pop");
	var skill_container = $("#skill_container");
	
	if(pop.length)
	{
		pop.each(function(){
			$(this).popover();
		});				
	}
	if (skill_container.length)
	{		
		var close = skill_container.find(".close");		
		var search_items = ['.$skillTips.'];//must be an already sorted array
		var search_list = $("div.overview ul.inside");
		var search_box = $("#search_box");
		var clear = function()
		{
			var overview = $("#overview");
			var portfolio = $("#portfolio");
			
			if(overview.length)
			{
				overview.focus(function(){
						$(".sugg_cont").hide();
				});
			}
			
			if(portfolio.length)
			{
				portfolio.click(function(){
						$(".sugg_cont").hide();
				});
			}
		}
		var populate = function()
		{
			var items = [];
			$.each(search_items, function(idx, val){
				items.push(\'<li><a href=\"#skills\">\'+val+\'</a></li>\');
			});
			search_list.append(items.join(""));
		}
		
		var transfer = function()
		{
			
			var box = $("#skills_tag");
			var selected = (box.val()+ $(this).text()).replace("add a tag","");			
			box.val(selected);						
						
			e = jQuery.Event("keypress");
			e.which = 13; //simulate pressing the enter key
			e.keyCode = 13;
			
			box.trigger(e);
		}
		
		var itemize = function()
		{
			search_list.empty();
			var entered = $.trim(search_box.val());
			var l = entered.length;
			if(l == 0)
			{
				populate();	
			}
			else 
			{
				var items = [];
				var item_zone = 0; // 0 means no item has been found, -1 means no other item will be found since the list is sorted
				$.each(search_items, function(idx, val){
					if(val.substr(0,l).toLowerCase() == entered.toLowerCase())
					{
						if(item_zone == 0)
						{
							item_zone = 1;
						}						 
						items.push(\'<li><a href=\"#skills\">\'+val+\'</a></li>\');
					}
					else
					{
						if(item_zone == 1)
						{
							item_zone = -1;
						}
						if(item_zone == -1)
						{
							return false;
						}
					}	
						
				});	
				
				search_list.append(items.join(""));
			}
		}
		if(close.length)
		{
			close.click(function(){				
				$(".sugg_cont").hide();
			});			
		}
		skill_container.delegate("input", "focus", function(e){
			if($(".sugg_cont").length)
			{
				$(".sugg_cont").show();
				
				$(".tinyscroll").tinyscrollbar();
			}
		});		
		
		search_box.bind("keyup keydown change", itemize);		
		
		populate();
		
		search_list.delegate("li", "click", transfer);
		
		clear();
		
	}	
	
', CClientScript::POS_READY);
} 
?>