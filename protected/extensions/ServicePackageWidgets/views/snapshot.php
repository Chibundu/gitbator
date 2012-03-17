	<?php 
		$baseUrl = Yii::app()->request->baseUrl;
		$app = Yii::app();		
		
		$logo = Miscellaneous::getLogo();
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
		
		$country = ($model)?$model->serviceprovider->address->country: 'ZA';
		$country = strtolower($country);
	?>
	<div class = "row">
			<div class = "span10">
				<div style = "background: #dbdbdb; border: 1px solid #CACACA;" >
					<div class = "row-fluid">
					
							<div class = "span2">
								<div class = "row-fluid">
									<div class = "span8">
										<?php echo CHtml::image((($isSample || !$logoPath) ? "$baseUrl/images/v.png" : "$logoPath"), 'Logo', array('style'=>'margin: 3px;'));?>										
									</div>
									<div class = "span4"><?php echo CHtml::image("$baseUrl/images/flags/$country.png",'Flag', array('style'=>'margin-left: 5px; padding-top: 30px;'));?></div>
								</div>
							</div>
							
							<div class = "span1">
								<div class = "row-fluid topical">			
										
										<div class = "span4">
										<span class = "right"><?php echo  ($model)? $model->units_bought : $units_bought;?></span>
										</div>
										<div class = "span8">
										<?php echo CHtml::image("$baseUrl/images/shopping.png", '', array('style'=>'margin-top: 5px;')); ?>
										</div>
															
								</div>									
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
							<div class = "span2">
								<div class = "row-fluid">
									<span class = "topical right"><?php echo ($model)?($model->currency->symbol.' '.number_format($model->cost, 2)):$currencySymbol.' '.number_format($cost, 2); ?></span>
								</div>
								<div class = "row-fluid">
									<span class = "right quiet"><?php echo Packages::costType(($model)?$model->cost_type:$cost_type); ?></span>
								</div>
							</div>
							<div class = "span2">
								<div class = "row-fluid">
									<span class = "topical right"><?php echo ($model)?($model->delivery.' '.(($model->delivery > 1)?'days':'day')):($delivery.' '.(($delivery > 1)? 'days': 'day')); ?></span>
								</div>
								<div class = "row-fluid">
									<span class = "right quiet">Est. Delivery</span>
								</div>
							</div>
							<div class = "span2">
								<div style = "width: 0px; float: right; border-top:30px solid #000; border-right:30px solid #000; border-left:30px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-bottom:30px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);"></div>
								<div style = "position: relative; float: right;">
									<div style = "position: absolute;color: #fff; font-weight: bold;  top:10px; left: 25px; font-size: 1.1em;">-<?php echo $model->discount; ?>%</div>
								</div>
							</div>
						</div>
					</div>
					<div class = "row-fluid prepend-top">
						<div class = "span6">
							<?php echo ($model)? $model->description : $description; ?>
						</div>
						<div class = "span6" >
							<?php echo CHtml::image($baseUrl.'/'.$app->params['service_packages_dir'].(($model)?"larger/".$model->picture: $picture), ''); ?>
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
							 
							 	<li><?php echo $deliverable->deliverable; ?></li>							 	
							 
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
							 
							 	<li><?php echo $excluded_item->item; ?></li>							 	
							 
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
		  
		  