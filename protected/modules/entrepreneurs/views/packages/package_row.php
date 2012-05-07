<?php $service_packages_dir = Yii::app()->request->baseUrl.'/'.Yii::app()->params['service_packages_dir'];?>
<div class = "row-fluid">
<div class = "span12">
<ul class = "thumbnails">
<?php 
	foreach($packages as $current_package):
	
	$package_title_link = $this->createUrl('packages/view', array('id'=>$current_package->id));
	$status = $current_package->status;
?>

<li class = "span4">	
	<div class = "thumbnail picture_frame_mini">
	<?php if($current_package->featured_priority >= Packages::HIGH): ?>
			<div style = "position: relative">					
				<div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
			</div>
	<?php endif; ?>
		
			<div class = "package_pic"><?php echo CHtml::link('<img alt="No screen shot" src="'.$service_packages_dir.$current_package->picture.'">', $package_title_link) ?></div>
				
				<div class = "caption">
						<h5 class = "ellipsis"><?php echo CHtml::link($current_package->title, $package_title_link, array('rel'=>'popover', 'data-content'=>$current_package->description, 'data-original-title'=>$current_package->title, 'data-placement'=>'bottom', 'class'=>'package_title'))?></h5>
							<?php $discount = $current_package->discount;?>
							<div class = "row-fluid prepend-top">
								<?php if($discount > 0):?>
								<div class = "span2">
									
									<div>		
										<div style = "position: relative; top: -10px;">							
											<div style = "width: 0px; border-right: 25px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-top: 25px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-left: 25px solid <?php echo ($discount > 0)?'#000':'transparent'?>; border-bottom: 25px solid <?php echo ($discount > 0)?'#000':'transparent'?>;">
								
											 </div>
										</div>
										<div style = "position: relative;">
											 <div style = "position: absolute; top: -30px; font-weight: bold; color: #fff; font-size: 0.7em;">
												 &nbsp;<?php echo $discount;?>% <br>&nbsp;&nbsp;off
											 </div>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class = "span<?php echo ($discount > 0)? '4': '5'; ?>">
									<div <?php echo ($discount <= 0)? 'style = "height: 50px;"':'';?>>
										<span class = "bold" style = "word-wrap: break-word; font-size: 0.95em;"><?php echo $current_package->currency->symbol.$current_package->cost; ?></span>
										<br>
										<span class = "help-block" style = "font-size: 0.85em;"><?php echo Packages::costType($current_package->cost_type) ?></span>
									</div>
								</div>
								<div class = "span4">
									<span class = "bold" style = "word-wrap: break-word; font-size: 0.95em;"><?php echo $current_package->delivery ?></span>
									<span class = "bold"> day<?php echo (($current_package->delivery > 1)? 's' : '') ?></span> 
									<br>
									<span class = "help-block" style = "font-size: 0.85em;">Est. Delivery</span>				
								</div>
								<div class = "span<?php echo ($discount > 0)? '2 ': '3 '; ?> bold" style = "word-wrap: break-word; font-size: 0.95em;">
									<?php echo $current_package->units_bought; ?> <i class = "icon-shopping-cart"></i>									
								</div>						
							</div>							
				
					</div>
	</div>
</li>
<?php endforeach;?>
</ul>
</div>
</div>