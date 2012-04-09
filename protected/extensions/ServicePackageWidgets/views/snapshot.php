	<?php 
		$baseUrl = Yii::app()->request->baseUrl;
		$app = Yii::app();		
		
		$sp = $model->serviceprovider;
		
		$logo = $sp->pic;
		$logoPath = ($logo)? Miscellaneous::getRelativeLogoPath().$logo : '';
		
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
		
		$country = ($model)?$sp->address->country: 'ZA';
		$country = strtolower($country);
	?>
	<div class = "row-fluid">
			<div class = "span12">
					<div class = "row-fluid">						
						<div class = "span12" style = "position: relative; background: #E3DCD0; box-shadow: 0 0 2px rgba(0, 0, 0, 0.35), 0 85px 180px 0 #FFFFFF, 0 12px 8px -5px rgba(0, 0, 0, 0.85);">
						<?php if($model->featured_priority >= Packages::HIGH):?>						
						 <div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
						 <?php endif; ?>
							<div class = "row-fluid">
								<div class = "span2">								
									<?php echo CHtml::image((($isSample || !$logoPath) ? "$baseUrl/images/v.png" : "$logoPath"), 'Logo', array('style'=>'margin:2px;'));?>
									<?php echo CHtml::image("$baseUrl/images/flags/$country.png",'Flag', array('style'=>'padding-top: 30px;'));?>
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
					<div class = "row-fluid prepend-top">
						<div class = "span6">
							<span style = "word-wrap:break-word;"><?php echo ($model)? $model->description : $description; ?></span>
						</div>
						<div class = "span6">
							
							<?php echo CHtml::image($baseUrl.'/'.$app->params['service_packages_dir'].(($model)?"larger/".$model->picture: $picture), 'no screenshot', 
									array('class'=>'picture_frame span4 right')); ?>
						
						</div>
					</div>
					<hr>
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
		  
		  