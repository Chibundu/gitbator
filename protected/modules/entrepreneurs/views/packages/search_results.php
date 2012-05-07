<?php
	$numPackages = count($packages);
	$service_packages_dir = Yii::app()->request->baseUrl.'/'.Yii::app()->params['service_packages_dir'];
?>
<div class = "row append-bottom">
<div class = "span9">
<hr>
<div class = "row">
<div class = "span5">
<?php if($mode == "search"):?>
Displaying <b><?php echo $numberOfResults; ?></b> Search Results for <span class = "gold-font"><?php echo $search; ?></span>
<?php elseif($mode == "category" && $numPackages > 0):?>
<h2><?php echo $category_name;?></h2>
<span class = "help-block">Displaying <b><?php echo $numberOfResults; ?></b> service packages</span>
<?php elseif($mode == "featured") :?>
<h2>Featured Packages</h2>
<?php else :?>
&nbsp;
<?php endif;?>
</div>
<?php if($mode == "featured"):?>
	<div class = "span4">
		<span class = "right help-block">Filter by : 
		<?php echo CHtml::link('Price', array('packages/allFeaturedPackages', 'page'=>$current_page, 'sort'=>"Price"), array('class'=>'sortBy'.(($sortedBy == "Price")?" highlight": "")));?> | 
		<?php echo CHtml::link('Discount', array('packages/allFeaturedPackages', 'page'=>$current_page, 'sort'=>"Discount"), array('class'=>'sortBy'.(($sortedBy == "Discount")?" highlight": "")));?> | 
		<?php echo CHtml::link('Rating', array('packages/allFeaturedPackages', 'page'=>$current_page, 'sort'=>"Rating"), array('class'=>'sortBy'.(($sortedBy == "Rating")?" highlight": "")));?> | 
		<?php echo CHtml::link('Best Selling', array('packages/allFeaturedPackages', 'page'=>$current_page, 'sort'=>"Best Selling"), array('class'=>'sortBy'.(($sortedBy == "Best Selling")?" highlight": "")));?></span>
	</div>
<?php else: ?>
<span class = "right help-block">Filter by : 
		<?php echo CHtml::link('Price', array('packages/category', 'page'=>$current_page, 'id'=>$category_id, 'sort'=>"Price"), array('class'=>'sortBy'.(($sortedBy == "Price")?" highlight": "")));?> | 
		<?php echo CHtml::link('Discount', array('packages/category', 'page'=>$current_page, 'id'=>$category_id, 'sort'=>"Discount"), array('class'=>'sortBy'.(($sortedBy == "Discount")?" highlight": "")));?> | 
		<?php echo CHtml::link('Rating', array('packages/category', 'page'=>$current_page, 'id'=>$category_id, 'sort'=>"Rating"), array('class'=>'sortBy'.(($sortedBy == "Rating")?" highlight": "")));?> | 
		<?php echo CHtml::link('Best Selling', array('packages/category', 'page'=>$current_page, 'id'=>$category_id, 'sort'=>"Best Selling"), array('class'=>'sortBy'.(($sortedBy == "Best Selling")?" highlight": "")));?></span>
<?php endif;?>
</div>

</div>
<div class = "span3">
<div class="subnav well hidden-phone default_context">
	<ul class="nav nav-list">	
		<?php foreach ($categories as $category):?>			
		<li class = "sidelink <?php echo (($category['id'] == $category_id)?"active":"");?>">
			<?php echo CHtml::link($category['name'], array('packages/category', 'id'=>$category['id']));?>			
		</li>
		
		<?php endforeach;?>
	</ul>
</div>
</div>
</div>

<?php if($numPackages > 0):?>
<div class = "row">
<div class = "span9">
<ul class = "thumbnails">
<?php 
	foreach($packages as $current_package):
	
	$package_title_link = $this->createUrl('packages/view', array('id'=>$current_package['id']));
	$status = $current_package['status'];
?>

<li class = "span3">	
	<div class = "thumbnail picture_frame_mini">
	<?php if($current_package['featured_priority'] >= Packages::HIGH): ?>
			<div style = "position: relative">					
				<div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
			</div>
	<?php endif; ?>
		<img alt="No screen shot" src="<?php echo $service_packages_dir.$current_package['picture']; ?>" style = "min-height: 145px; cursor: pointer;" >
				<div class = "caption">
						<h5 class = "ellipsis"><?php echo CHtml::link($current_package['title'], $package_title_link)?></h5>
							<?php $discount = $current_package['discount'];?>
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
												 &nbsp;- <?php echo $discount;?>%
											 </div>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class = "span<?php echo ($discount > 0)? '4': '5'; ?>">
									<div <?php echo ($discount <= 0)? 'style = "height: 50px;"':'';?>>
										<span class = "bold" style = "word-wrap: break-word; font-size: 0.95em;"><?php echo $current_package['symbol'].number_format($current_package['cost'],2); ?></span>
										<br>
										<span class = "help-block" style = "font-size: 0.85em;"><?php echo Packages::costType($current_package['cost_type']) ?></span>
									</div>
								</div>
								<div class = "span4">
									<span class = "bold" style = "word-wrap: break-word; font-size: 0.95em;"><?php echo $current_package['delivery'] ?></span>
									<span class = "bold"> day<?php echo (($current_package['delivery'] > 1)? 's' : '') ?></span> 
									<br>
									<span class = "help-block" style = "font-size: 0.85em;">Est. Delivery</span>				
								</div>
								<div class = "span<?php echo ($discount > 0)? '2 ': '3 '; ?> bold" style = "word-wrap: break-word; font-size: 0.95em;">
									<?php echo $current_package['units_bought']; ?> <i class = "icon-shopping-cart"></i>									
								</div>						
							</div>
							
										
				
					</div>
	</div>
</li>
<?php endforeach;?>
</ul>
</div>
</div>
<div class = "row">
	<div class = "span9" style = "position: relative; top: -10px;">
		<div style = "width: 250px; margin-left: auto; margin-right: auto;">
			<?php $this->widget('BootPager', array('pages'=>$pages,'prevPageLabel'=>'&laquo;', 'nextPageLabel'=>'&raquo;', 'htmlOptions'=>array('class'=>'pagination')));?>
		</div>	
	</div>	
</div>				
<?php else:?>
<div class = "row">
	<div class = "span9" style = "position: relative; top: -10px;">
	Sorry there are no packages matching your search. Try browsing through the categories at the right side of your screen.
	</div>	
</div>		
<?php endif;?>