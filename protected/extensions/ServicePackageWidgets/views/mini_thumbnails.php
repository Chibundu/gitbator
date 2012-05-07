<?php
$app = Yii::app(); 
$service_packages_dir = $app->request->baseUrl."/".$app->params['service_packages_dir'];?>
<ul class = "thumbnails">
<?php 
	foreach($packages as $current_package):	
	$status = $current_package['status'];
?>

<li class = "span12">	
	<div class = "thumbnail picture_frame_mini">
	<?php if($current_package['featured_priority'] >= Packages::HIGH): ?>
			<div style = "position: relative">					
				<div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
			</div>
	<?php endif; ?>
		<img alt="No screen shot" src="<?php echo $service_packages_dir.$current_package['picture']; ?>" style = "cursor: pointer;">
		<div class = "caption">
		<h5 class = "ellipsis"><?php echo CHtml::link($current_package['title'], array('packages/view', 'id'=>$current_package['id']), array('class'=>'package_title', 'rel'=>'popover', 'data-original-title'=>$current_package['title'], 'data-content'=>$current_package['description'], 'data-placement'=>'left'))?></h5>
		<?php $discount = $current_package['discount'];?>
							<div class = "row-fluid prepend-top">
								<?php if($discount > 0):?>
								<div class = "span2">
									
									<div>		
										<div style = "position: relative; top: -2px; left: -10px;">							
											<div style = "width: 0px; border-right: 19px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-top: 19px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-left: 19px solid <?php echo ($discount > 0)?'#000':'transparent'?>; border-bottom: 19px solid <?php echo ($discount > 0)?'#000':'transparent'?>;">
								
											 </div>
										</div>
										<div style = "position: relative;">
											 <div style = "position: absolute; top: -22px; left: -10px; font-weight: bold; color: #fff; font-size: 0.68em;">
												 &nbsp;<?php echo $discount;?>% <br>&nbsp;&nbsp;off
											 </div>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class = "span<?php echo ($discount > 0)? '4': '5'; ?>">
									<div <?php echo ($discount <= 0)? 'style = "height: 35px;"':'';?>>
										<span class = "bold ellipsis" style = "font-size:0.75em"><?php echo $current_package['symbol'].$current_package['cost']; ?></span>
										<br>
										<span class = "help-block" style = "font-size: 0.65em;"><?php echo Packages::costType($current_package['cost_type']) ?></span>
									</div>
								</div>
								<div class = "span4">
									<span class = "bold" style = "word-wrap: break-word; font-size:0.75em"><?php echo $current_package['delivery'] ?>
									 day<?php echo (($current_package['delivery'] > 1)? 's' : '') ?></span> 
									<br>
									<span class = "help-block" style = "font-size: 0.65em;">Est. Delivery</span>				
								</div>
								<div class = "span<?php echo ($discount > 0)? '2 ': '3 '; ?> bold" style = "word-wrap: break-word; font-size:0.75em">
									<?php echo $current_package['units_bought']; ?> <br><i class = "icon-shopping-cart"></i>									
								</div>						
							</div>					
		</div>
			
	</div>
</li>
<?php endforeach;?>
</ul>

<?php $app->clientScript->registerScript('thumnail_utility', '
			$(".thumbnails").on("click", ".thumbnail", function(e){
				window.location.href = $(this).find(".package_title").attr("href");
			});
			
			
		
		', CClientScript::POS_READY);?>
