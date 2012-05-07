<?php
$app = Yii::app();
$baseUrl = $app->request->baseUrl;
$app->clientScript->registerScriptFile("$baseUrl/js/spin.min.js", CClientScript::POS_HEAD);
$this->breadcrumbs=array(
	'Packages',
);

?>
<div class = "package_sec">
<div class = "row">
	<div class = "span9">		
			<?php echo CHtml::beginForm($this->createUrl('packages/search'), 'get',  array('id'=>'searchForm'))?>	
			<?php echo CHtml::textField('search', 'Website, Book keeping, Logo', array('class'=>'span6 large_search_box faded', 'id'=>'searchBox'));?>
			<?php echo CHtml::link('Search', '', array('class'=>'btn btn-primary large-btn', 'style'=>'position: relative; top:-5px;'))?>
			<?php echo CHtml::endForm();?>		
	</div>
</div>


<div class = "row-fluid">
	<div class = "no-results-found span9 prepend-top" style = "display:none;">
		<div class="alert alert-block">
			<a class="close" data-dismiss="alert">&times;</a>
			<h4 class="alert-heading">No Results Found</h4>
			<p>Sorry we are unable to find any items matching your search. Please change your search criteria or browse the service packages below.</p>
		</div>
	</div>
</div>



<div class = "row">
<div id = "search_context" class = "span9"  style = "min-height: 200px; display:none;">
</div>
</div>


<div class = "row-fluid prepend-top">
<div  class = "default_context span9" data-spy="scroll">
			<section id = "featured_packages" class = "media-section">	
			<div class = "row-fluid">
				<div class = "span8">
					<h2>Featured Packages <span><?php echo CHtml::link('View All &raquo;', array('packages/allFeaturedPackages'), array('style' => "font-size: 12px; color: #ccc;")); ?></span></h2>
				</div>
				<div class = "span4">
			 		 <div class = "right custom_pager">	
			 			 <span class = "spinner" style = "position: relative; left:-30px; top: 5px;"></span>
						<?php echo CHtml::link('<i class = "icon-chevron-left"></i>', '#', array('class'=>'prev btn')); ?>
						<span class = "current_page">1</span> of <span class = "number_of_pages"><?php echo ceil($fpCount/3); ?></span>						
						<?php echo CHtml::link('<i class = "icon-chevron-right"></i>', '#', array('class'=>'next btn')); ?>
					 </div>	
				</div>
			</div>					
				
			<section id = "fp_content"></section>		
			
					
		</section>
	<?php
	$script = ''; 
	foreach ($serviceCategories as $category):?>	
	<?php if($category->ordinaryPackagesCount > 0): ?>
		
		<?php $categoryName = $category->name; ?>
		
		<section id = "<?php echo str_replace('&', 'and', implode('_', explode(' ', $categoryName))); ?>" class = "media-section">	
			<div class = "row-fluid">
				<div class = "span8">
					<h2><?php echo $categoryName; ?> <span><?php echo CHtml::link('View All &raquo;', array('packages/category', 'id'=>$category->id), array('style' => "font-size: 12px; color: #ccc;")); ?></span></h2>
				</div>
				<div class = "span4">						
			 		 <div class = "right custom_pager">	
			 			 <span class = "spinner" style = "position: relative; left:-30px; top: 5px;"></span>
						<?php echo CHtml::link('<i class = "icon-chevron-left"></i>', '#', array('class'=>'prev btn')); ?>
						<span class = "current_page">1</span> of <span class = "number_of_pages"><?php echo ceil($category->ordinaryPackagesCount/3); ?></span>						
						<?php echo CHtml::link('<i class = "icon-chevron-right"></i>', '#', array('class'=>'next btn')); ?>
					 </div>	
				</div>
			</div>		
			<?php echo CHtml::hiddenField('category_id', $category->id);?>		
				
			<section id = "<?php echo $categoryName."_content"; ?>"></section>
			
			<div class = "visible-phone row-fluid">				
				<hr>	
			</div>
			
		</section>
		<?php			
			 endif; 
		?>
	
	<?php endforeach;?>
	
</div>

<div class = "span3">
<div class="subnav well hidden-phone default_context">
	<ul class="nav nav-list">		
		<li class = "sidelink active">
			<a href="#featured_packages">Featured Packages</a>
		</li>
		<?php foreach ($serviceCategories as $category):?>
			<?php if($category->ordinaryPackagesCount > 0): ?>
		<li class = "sidelink">
			<a href="#<?php echo str_replace('&', 'and', implode('_', explode(' ', $category->name))); ?>"><?php echo $category->name; ?></a>
		</li>
		<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>
</div>

</div>
</div>
<?php Yii::app()->clientScript->registerScriptFile($baseUrl."/js/et-packages.js", CClientScript::POS_END);?>

