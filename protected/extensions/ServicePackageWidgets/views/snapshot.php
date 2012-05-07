	<?php 
		$baseUrl = Yii::app()->request->baseUrl;
		$app = Yii::app();		
		
		$sp = $model->serviceprovider;
		
		$profile_pic = $sp->teamLeader->profile_picture;
		$picPath = ($profile_pic)? Miscellaneous::getRelativeProfileThumbnailPath().$profile_pic : '';
		
		$rating = 0;
		
		if($model)
		{
			$total = $model->vote_up + $model->vote_down;
			if($total)
				$rating = round($model->vote_up*100/$total);
		}
		else if($packageRating)
		{
			$rating = $packageRating;
		}
		
		$address = $sp->address;
		$country = ($model)?$address->country: 'ZA';
		$country_str = ucwords(strtolower(CountryUtility::$countries[$country]));
		$country = strtolower($country);
	?>
	<div class = "row-fluid">
			<div class = "span12">
					<div class = "row-fluid hidden-phone">						
						<div class = "span12" style = "position: relative; background: #E3DCD0; box-shadow: 0 0 1px rgba(0, 0, 0, 0.15), 0 65px 170px 0 #FFFFFF, 0 10px 7px -4px rgba(0, 0, 0, 0.65); padding: 5px;">
						<?php if($model->featured_priority >= Packages::HIGH):?>						
						 <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
						 <?php endif; ?>
							<div class = "row-fluid">
								<div class = "span3" >								
									<div class = "row-fluid">
										<div style = "float: left; width: 60px;">
										<?php echo CHtml::image((($isSample || !$picPath) ? "$baseUrl/images/v.png" : "$picPath"), 'Logo', array('style'=>'margin:2px; border: 4px solid #FFFFFF;'));?>
										</div>
										<div class = "span7" style = "font-size: 0.75em;">
										<div class = "row-fluid"><span class = "topical"><?php echo $sp->displayName; ?></span></div>
										<div class = "row-fluid">									
										<?php echo $address->city.", "; ?>
										</div>
										<div class = "row-fluid">
										<?php echo CHtml::image("$baseUrl/images/flags/$country.png",'Flag');?>
										<?php echo $country_str;?>
										</div>
										</div>
									</div>
								</div>
								<div class = "span1">
								<div class = "row-fluid">						
								<span class = "topical"><?php echo  ($model)? $model->units_bought : $units_bought;?></span>																							
								</div>	
								<div class = "row-fluid"><i class = "icon-shopping-cart"></i></div>															
								</div>
							<div class = "span3">
								<?php if($rating):?>
								<div class = "row-fluid"><span class = "topical"><?php echo $rating; ?>%</span></div>
								<div class = "row-fluid"><span class = "quiet">Rating <i class = "icon-ok-sign"></i></span></div>
								<?php else: ?>
								<div class = "row-fluid"><span class = "topical">N/A</span></div>
								<div class = "row-fluid"><span class = "quiet">Not Rated Yet</span></div>
								<?php endif;?>
							</div>
							
							<div style = "float: left; width: 95px;">
								<div class = "row-fluid">
									<span class = "topical"><?php echo ($model)?($model->currency->symbol.' '.number_format($model->cost, 2)):$currencySymbol.' '.number_format($cost, 2); ?></span>
								</div>
								<div class = "row-fluid">
									<span class = "quiet"><?php echo Packages::costType(($model)?$model->cost_type:$cost_type); ?></span>
								</div>
							</div>
							<?php if($model->discount > 0):?>
							<div class = "span1">
								<div class = "row-fluid">
									<span class = "topical ">-<?php echo $model->discount; ?>%</span>
								</div>
								<div class = "row-fluid">
									<span class = "quiet">Discount</span>
								</div>								
							</div>
							<?php endif; ?>
							<div class = "span2">
								<div class = "row-fluid">
									<span class = "topical"><?php echo ($model)?($model->delivery.' '.(($model->delivery > 1)?'days':'day')):($delivery.' '.(($delivery > 1)? 'days': 'day')); ?></span>
								</div>
								<div class = "row-fluid">
									<span class = "quiet">Est. Delivery</span>
								</div>
							</div>
							</div>
						</div>
					</div>
					
					<!-- Mobile Only -->
						<div class = "well prepend-top append-bottom visible-phone" style = "font-size: 0.9em;">
							<div class = "row append-bottom">	 
								<div class = "span12">
									<div class = "row">		
										<div class = "span12">
										<?php echo CHtml::image((($isSample || !$picPath) ? "$baseUrl/images/v.png" : "$picPath"), 'Profile Picture', array('class'=>'picture_frame', 'style'=>'margin-bottom: 5px;'));?>
										</div>		
									</div>
									<div class = "row">		
										<div class = "span12">
										<?php echo CHtml::image("$baseUrl/images/flags/$country.png",'Flag');?>
										<?php echo $address->city; ?>, 
										<?php echo $country_str;?>
										</div>		
									</div>
									<div class = "row prepend-top">		
										<div class = "half">
											<h5>RATING</h5>			
										</div>
										<div class = "half">
											<?php if($rating):?>
											<div class = "row-fluid"><h4><?php echo $rating; ?>%</h4></div>
											<div class = "row-fluid"><span class = "quiet">Rating <i class = "icon-ok-sign"></i></span></div>
											<?php else: ?>
											<div class = "row-fluid"><span class = "topical">N/A</span></div>
											<div class = "row-fluid"><span class = "quiet">Not Rated Yet</span></div>
											<?php endif;?>
										</div>
									</div>
									<div class = "row ">		
										<div class = "half">
											<h5>SOLD</h5>			
										</div>
										<div class = "half">
										<h4><?php echo  ($model)? $model->units_bought : $units_bought;?></h4>
										</div>
									</div>
									
									<div class = "row">
										<div class = "half">
										<h5>PRICE</h5>		
										</div>
										<div class = "half">
										
										<div class = "row-fluid">
											<h4><?php echo ($model)?($model->currency->symbol.' '.number_format($model->cost, 2)):$currencySymbol.' '.number_format($cost, 2); ?></h4>
											</div>
											<div class = "row-fluid">
												<span class = "quiet"><?php echo Packages::costType(($model)?$model->cost_type:$cost_type); ?></span>
											</div>									
										</div>
									</div>
									<?php if($model->discount > 0):?>
									<div class = "row">
										<div class = "half">
										<h5>DISCOUNT</h5>
										</div>
										<div class = "half">
											<h4>-<?php echo $model->discount; ?>%</h4>						
										</div>
									</div>
								<?php endif; ?>
									<div class = "row">
										<div class = "half">
										<h5>EST. DELIVERY</h5>
										</div>
										<div class = "half">				
											<h4><?php echo ($model)?($model->delivery.' '.(($model->delivery > 1)?'days':'day')):($delivery.' '.(($delivery > 1)? 'days': 'day')); ?></h4>								
										</div>
									</div>
									<hr>
								
								</div>
							</div>
					</div>
					<!-- End Mobile Only -->
					
					
					
					<div class = "row-fluid prepend-top">
						<div class = "span6">
							<div style = "word-wrap:break-word; text-align: justify; padding-right: 5px;">
								<?php echo ($model)? $model->description : $description; ?>
							</div>
						</div>
						<div class = "span6">
							<div class = "visible-phone prepend-top">
								<?php echo CHtml::image($baseUrl.'/'.$app->params['service_packages_dir'].(($model)?"/".$model->picture: $picture), 'no screenshot', 
									array('class'=>'picture_frame')); ?>
								<hr>&nbsp;
							</div>
							<div class = "visible-desktop visible-tablet">
							<?php echo CHtml::image($baseUrl.'/'.$app->params['service_packages_dir'].(($model)?"larger/".$model->picture: $picture), 'no screenshot', 
									array('class'=>'picture_frame', 'style'=>'width: 410px; max-width: 100%; float: right;')); ?>
							</div>							
						</div>
					</div>
					<hr style = "border-color: #E3DCD0; border-size: 3px;">
					<div class = "row-fluid prepend-top">
						<h3>The Service Package Fine Print</h3>						
					</div>
					<div class = "row-fluid prepend-top">
						<h4>The deliverables</h4>	
						<div class = "span12">
							<ul class = "good_list">
							<?php 
								$deliverables = ($model)? $model->packageDeliverables: $packageDeliverables;
							 	foreach ($deliverables as $deliverable):
							 ?>
							 
							 	<li style = "word-wrap: break-word"><?php echo $deliverable->deliverable; ?></li>							 	
							 
							 <?php endforeach;?>
							 </ul>
						</div>					
					</div>
					
					<?php if(($model && count($model->packageExcluded) > 0) || !empty($packageExcluded)):?>
					<div class = "row-fluid prepend-top">
						<h4>What is not included</h4>	
						<div class = "span12">
							<ul class = "bad_list">
							<?php 
								$excluded_items = ($model)? $model->packageExcluded : $packageExcluded;
							 	foreach ($excluded_items as $excluded_item):
							 ?>
							 
							 	<li style = "word-wrap: break-word"><?php echo $excluded_item->item; ?></li>							 	
							 
							 <?php endforeach;?>
							 </ul>
						</div>					
					</div>
					<?php endif; ?>
					
					
					<?php if(($model && $model->instructions) || $instructions):?>
					<div class = "row-fluid prepend-top">
						<h4>Instructions to buyers</h4>	
						<div class = "span12" style = "margin-top: 5px;">						
							<?php echo ($model) ? $model->instructions : $instructions; ?>
						</div>					
					</div>
					<?php endif; ?>
					
				</div>				
		  </div>
		  
		  