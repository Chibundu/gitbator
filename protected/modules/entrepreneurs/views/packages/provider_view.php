	<?php $baseUrl = Yii::app()->request->baseUrl;?>
	<h3>Service Providers Profile &raquo; <?php echo $displayName; ?> </h3>
	<div class="ribbon-wrapper hidden-phone" style = "position: relative; top: 45px;">
		<div class="ribbon-front">			
			<div class = "row-fluid">
			<div class = "span4">
				<div class = "row-fluid">
					<div class = "span4">
					<?php echo CHtml::image(Miscellaneous::getRelativeProfileThumbnailPath().$profile_picture, 'Profile Picture', array('class'=>'picture_frame', 'style'=>'margin-left: 10px; margin-top: 8px;'));?>
					</div>
					<div class = "span8">
					<div class = "row-fluid">
					<div class = "span12">
					<h3><?php echo $displayName; ?></h3>
					</div>
					</div>
						<div class = "row-fluid">
					<div class = "span12" style = "font-size: 0.8em;">
					<?php echo CHtml::image("$baseUrl/images/flags/".strtolower($country).".png", 'flag');?>
					<?php echo $city; ?>, 
					<?php echo ucwords(strtolower(CountryUtility::$countries[$country]));?>
					</div>
					</div>
					</div>
				</div>
				
				
			</div>
			<div class = "span3">
				<div class = "row-fluid" style = "margin-top: 8px;">
					<div class = "span5">
						<h4>RATING</h4>
					</div>
					<div class = "span7">
					<h4>REVIEWS</h4>	
					</div>
				</div>
				<div class = "row-fluid"  style = "margin-top: 15px;">
					<div class = "span5">
					<h4><?php echo $rating; ?>%</h4>					
					</div>
					<div class = "span7">
					<?php echo CHtml::image("$baseUrl/images/vote_up.png"); ?>	
					<?php echo $positive_votes; ?>	&nbsp;&nbsp;
					
					<?php echo CHtml::image("$baseUrl/images/vote_down.png"); ?>
					<?php echo $negative_votes; ?>
					</div>
				</div>
				
			</div>
			<div class = "span2">
				<div class = "row-fluid"  style = "margin-top: 8px;">
					<div class = "span12">
						<h4>SOLD</h4>
					</div>
				</div>
				<div class = "row-fluid"  style = "margin-top: 15px;">
					<div class = "span12">
						<h4><?php echo $sold;?></h4>
					</div>
				</div>
			</div>
			<?php if($isVerified):?>
			<div class = "span3">
			<div class = "row-fluid" style = "margin-top: 8px;">
				<div class = "span12">
				<?php echo CHtml::image("$baseUrl/images/verified.png","Verified"); ?> Vcubator Verified
				</div>
			</div>
			<div class = "row-fluid"  style = "margin-top: 8px;">
					<div class = "span12">
						Member since <b><?php echo $member_since; ?></b>
					</div>
				</div>		
			</div>
			<?php endif;?>
			</div>
		</div>
		<div class="ribbon-edge-topleft"></div>
		<div class="ribbon-edge-topright"></div>
		<div class="ribbon-edge-bottomleft"></div>
		<div class="ribbon-edge-bottomright"></div>
		<div class="ribbon-back-left"></div>
		<div class="ribbon-back-right"></div>
		
		<div style = "width: 798px; background: #efefef; border: 1px solid #fff; min-height: 200px; position: relative; top: -100px;">
			<div style = "padding-top: 120px; padding-left: 10px; padding-right: 10px;">
			<h4>ABOUT ME:</h4>
			<div style = "text-align: justify;">
				<?php echo $overview; ?> &nbsp;&nbsp;
				<?php echo CHtml::link('See More &raquo;', '#', array('class'=>'see_more_link', 'style'=>'color: #d0a113'));?>
				
				<div class = "see_more" style = "display:none;">
					<div class = "row-fluid prepend-top">
					<b>Other Services Offered:</b> <?php echo $other_services; ?>
					</div>
					<div class = "row-fluid prepend-top append-bottom">
					<b>Specific Skills:</b> <?php echo $skills; ?>
					</div>
				</div>				
			</div>
			</div>
		</div>
	</div>
	
	<div class = "well prepend-top append-bottom visible-phone" style = "font-size: 0.9em;">
	<div class = "row append-bottom">	 
		<div class = "span12">
			<div class = "row prepend-top">		
				<div class = "span12">
				<?php echo CHtml::image(Miscellaneous::getRelativeProfileThumbnailPath().$profile_picture, 'Profile Picture', array('class'=>'picture_frame'));?>
				</div>		
			</div>
			<div class = "row prepend-top">		
				<div class = "span12">
				<?php echo CHtml::image("$baseUrl/images/flags/".strtolower($country).".png", 'flag');?>
					<?php echo $city; ?>, 
					<?php echo ucwords(strtolower(CountryUtility::$countries[$country]));?>
				</div>		
			</div>
			<div class = "row prepend-top">		
				<div class = "half">
					<h5>RATING</h5>			
				</div>
				<div class = "half">
					<h5><?php echo $rating; ?>%</h5>			
				</div>
			</div>
			<div class = "row prepend-top">		
				<div class = "half">
					<h5>REVIEWS</h5>			
				</div>
				<div class = "half">
					<div class = "row">
						<?php echo CHtml::image("$baseUrl/images/vote_up.png"); ?>	
						<?php echo $positive_votes; ?>				
					</div>
					<div class = "row">
					<?php echo CHtml::image("$baseUrl/images/vote_down.png"); ?>
					<?php echo $negative_votes; ?>
					</div>			
				</div>
			</div>
			<div class = "row prepend-top">		
				<div class = "half">
					<h5>SOLD</h5>			
				</div>
				<div class = "half">
					<h5><?php echo $sold;?></h5>			
				</div>
			</div>
			<div class = "row prepend-top">		
			<?php echo CHtml::image("$baseUrl/images/verified.png","Verified"); ?> Vcubator Verified
			</div>
			<div class = "row append-bottom">		
			Member since <b><?php echo $member_since; ?></b>
			</div>
			<hr>
			<div class = "row">
			<h4>ABOUT ME:</h4>
			<div style = "text-align: justify;">
				<?php echo $overview; ?> &nbsp;&nbsp;
				<?php echo CHtml::link('See More &raquo;', '#', array('class'=>'see_more_link', 'style'=>'color: #d0a113'));?>
				
				<div class = "see_more" style = "display:none;">
					<div class = "row-fluid prepend-top">
					<b>Other Services Offered:</b> <?php echo $other_services; ?>
					</div>
					<div class = "row-fluid prepend-top append-bottom">
					<b>Specific Skills:</b> <?php echo $skills; ?>
					</div>
				</div>				
			</div>
			</div>
		</div>
	</div>
	</div>
	
	<div class = "row">
	<div class = "span9">
	<h4>Packages by <?php echo $displayName; ?></h4>
	<?php $this->widget("ext.ServicePackageWidgets.PackageThumbnails", array("packages"=>$packages));?>
	</div>
	</div>
	
	<div class = "row" style = "position: relative; top: -25px;">
	<div class = "span9">	
	<div style = "width: 250px; margin-left: auto; margin-right: auto;">
	<?php $this->widget("BootPager", array("pages"=>$pages, 'prevPageLabel'=>'&laquo;', 'nextPageLabel'=>'&raquo;', "htmlOptions"=>array('class'=>'pagination', 'style'=>'position: relative; top:-15px;')));?>
	</div>
	
	
	</div>
	</div>
	
	<?php $cs = Yii::app()->clientScript->registerScript('show_provider', '
			
			if($(".see_more").length && $(".see_more_link").length)
			{
				$(".see_more_link").toggle(function(e){
					e.preventDefault();					
					$(".see_more").show();
					$(this).html("See Less &raquo;");
				}, function(e){
					$(".see_more").hide();
					$(this).html("See More &raquo;");
				});
			}
			
			', CClientScript::POS_READY);?>