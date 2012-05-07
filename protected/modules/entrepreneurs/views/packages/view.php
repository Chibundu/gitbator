<div class = "row-fluid">
	<div class = "span9">
		<div class = "row-fluid">
			<div class = "span10">
				<h2><?php echo $package->title; ?></h2>
			</div>
			<div class = "span2">
				<div class = "right">
					<?php echo CHtml::link('<i class = "icon-shopping-cart icon-white"></i> Order', array('packages/orderPackage', 'id'=>$package_id), array('class'=>'btn-success btn btn-large order'));?>
				</div>
			</div>
		</div>
		<div class = "row-fluid prepend-top append-bottom">
			<div class = "span8">
				<?php  $this->widget('BootAlert'); ?>
			</div>
		</div>
		<div class = "row-fluid payment_method append-bottom" style = "display: none;">
			<div class = "span8">
			<hr style = "border: 3px solid #F0F0F0">
			<h3>Payment Method</h3>
			<span class = "help-block quiet"><i>Please select a payment method and click on the "Proceed" button below</i></span>
			<?php $this->widget('ext.payment.options.Display');?>
			<hr style = "border: 3px solid #F0F0F0">	
			<?php echo CHtml::link("Proceed &raquo;", "#", array('class'=>'proceed btn btn-primary btn-large'));?>
			</div>
		
		</div>
		
		
		<?php $this->widget('ext.ServicePackageWidgets.SnapShot', array('model'=>$package));?>
		
	</div>
	<div class = "span3">
		<div class = "hidden-phone rounded" style = "background: #efefef; padding-top: 10px; margin-top: 40px; width: 90%;">
			<div style = "width: 70%; margin: 0px auto;">
			<h4 style = "margin-bottom: 10px;">Similar Packages</h4>
			<?php $this->widget("ext.ServicePackageWidgets.PackageThumbnails", array("packages"=>$similar_services, 'isMini'=>true));?>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class = "span9 prepend-top">	
			<hr style = "border-color: #E3DCD0; border-size: 3px;">	
			<h3>Other Services from <?php echo $name;?> <span><?php echo CHtml::link('View All &raquo;', array('packages/viewByProvider', 'id'=>$id), array('style' => "font-size: 12px; color: #ccc;")); ?></span></h3>
			<?php $this->widget("ext.ServicePackageWidgets.PackageThumbnails", array("packages"=>$other_packages));?>		
	</div>
</div>

<?php Yii::app()->clientScript->registerScript('view_utility', '

			$(".package_title").popover();
			
			$(".order").toggle(function(e){
					e.preventDefault();
					
					
					$(this).text("Cancel");
					
					$(".payment_method").show();
			}, function(e){
					e.preventDefault();
					$(this).html(\'<i class = "icon-shopping-cart icon-white"></i> Order\');
					$(".payment_method").hide();
			});
			
			$(".proceed").click(function(e){
				e.preventDefault();
				window.location.href = $(".order").attr("href")+"&mode="+$(".payment_option").val();
			});			
			
		
		', CClientScript::POS_READY);
?>