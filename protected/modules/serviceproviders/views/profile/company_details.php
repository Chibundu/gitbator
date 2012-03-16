<div class = "row-fluid">
	<div class = "span12">
	<?php $this->widget('ext.indicator.Tracker.ProgressTracker', array(
			'levels'=>array('Address Data', 'Register Services', 'Other Information', 'Company Details'),
			'current'=>4,
	))
	;?>
	
	<h1><?php echo ($model->accountType == "company")?"Company":"Freelancer"?> Details</h1>
	
	<div class = "row-fluid">
		<div class = "span8 prepend-top">
			<?php $this->widget('ext.SimpleFlash', array('message'=>'<h3>Good Job! Your profile is almost ready.</h3>
			Now let\'s round it up'))?>
		</div>
	</div>
	
		<div class = "row-fluid">
			<div class = "span5">
		
			<?php
				$form = $this->beginWidget('BootActiveForm');?>
			
			
			<?php echo $form->textFieldRow($model, 'displayName', array('class'=>'span12 pop', 'data-original-title'=>'Display Name', 'data-content'=>'Please enter your name as you would love it to appear to Clients(Entrepreneurs).')); ?>
			
			<?php if($model->accountType == 'company'):?>
			
				<?php echo $form->textFieldRow($model, 'businessName', array('class'=>'span12 pop','data-original-title'=>'Business Name', 'data-content'=>'Please enter the official name of your business or company.')); ?>
				<?php echo $form->textFieldRow($model, 'tagline', array('class'=>'span12 pop', 'data-original-title'=>'Tagline', 'data-content'=>'If you have a slogan or motto, please enter it here')); ?>
				<?php echo $form->textFieldRow($model, 'businessRegType', array('class'=>'span12 pop', 'data-original-title'=>'Registration', 'data-content'=>'How was your company registered? CC, PTY? Please enter here.')); ?>
				<?php echo $form->textFieldRow($model, 'businessRegNo', array('class'=>'span12 pop', 'data-original-title'=>'Registration Number', 'data-content'=>'Please enter your company\'s registration number here')); ?>
				
				<?php echo $form->dropDownListRow($model,'regYear',RecentYearRange::$years, array('class'=>'span5 pop', 'data-original-title'=>'Registration Year', 'data-content'=>'What year was your company registered?')); ?>
				
			<?php endif;?>
			
				</div>		
		</div>
			
		
			
			<div class = "row-fluid" id="keywords_container">
				<div class = "span12">
					<div class = "row-fluid">
						<div class = "span5">					
							<?php echo $form->textFieldRow($model, 'keywords', array('id'=>'keywords', 'class'=>'keywords span12'));?>					
						</div>
						<div class = "span4">
						<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 						'options'=>array(
     	   					'cursor'=>'move',
   		 					),    
						));
						?>
							<div class = "keyword_cont">
								<div class = "sugg_box">
									<div style = "font-size: 16px; font-weight: bold; text-align: center; padding-bottom: 10px;">Browse Keywords
										<span class="close"><?php echo CHtml::link('&times;', '#keywords_tag');?></span>
									</div>	
							
									<div class = "search_box_con"><?php echo CHtml::textField('keywords_search', ' ', array('id'=>'search_box')); ?></div>
							
								
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
								
						<?php $this->endWidget();?>
							</div>
						</div>
				 </div>	
			</div>				
	
		
		
		
			<div class = "row-fluid">
				<div class ="span6">
					<p class="form-actions">
					<?php echo CHtml::link('&laquo; Back', array('otherInfo'), array('class'=>'btn')) ?>
					&nbsp; &nbsp; &nbsp;
					<?php echo CHtml::submitButton('Finish', array('class'=>'nice gold radius button', 'id'=>'services_submit', 'name'=>'services_submit'));?>
				 	</p>
				 </div>
			 </div>
		
			
			
		<?php  $this->endWidget();  ?>
			
	</div>
</div>


<?php

	$cs = Yii::app()->clientScript;
	$baseUrl = Yii::app()->request->baseUrl;
	
	$cs->registerScript('pop_ups','
		var pop = $(".pop");
		if(pop.length)
		{
			pop.each(function(){
				$(this).popover();
			});				
		}	
	
	var keywords_container = $("#keywords_container");
	
	
	if (keywords_container.length)
	{		
		var close = keywords_container.find(".close");		
		var search_items = ['.$suggestions.'];//must be an already sorted array
		var search_list = $("div.overview ul.inside");
		var search_box = $("#search_box");
		var clear = function()
		{						
			pop.focus(function(){
				$(".keyword_cont").hide();
			});
						
		};
		
		var populate = function()
		{
			var items = [];
			$.each(search_items, function(idx, val){
				items.push(\'<li><a href=\"#keywords\">\'+val+\'</a></li>\');
			});
			search_list.append(items.join(""));
		}
		
		var transfer = function()
		{						
			var box = $("#keywords_tag");
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
						items.push(\'<li><a href=\"#keywords\">\'+val+\'</a></li>\');
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
				$(".keyword_cont").hide();
			});			
		}
		keywords_container.delegate("input", "focus", function(e){
			if($(".keyword_cont").length)
			{
				$(".keyword_cont").show();
				
				$(".tinyscroll").tinyscrollbar();
			}
		});		
		
		search_box.bind("keyup keydown change", itemize);		
		
		populate();
		
		search_list.delegate("li", "click", transfer);
		
		clear();
		
	}	
		
	$("#keywords").tagsInput();	
		
	', CClientScript::POS_READY);
	
	
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

