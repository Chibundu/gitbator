<?php
$this->breadcrumbs=array(
	'Packages',
);
$itemCount = count($packages);
$baseUrl = Yii::app()->request->baseUrl;
$packages_dir = Yii::app()->params['service_packages_dir'];
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/ajax-form.js", CClientScript::POS_HEAD);


?>
<div class = "row-fluid">
	<div  class = "span10 prepend-top">
	<h2>Service Packages(<?php echo $itemCount; ?>)</h2>
	</div>
</div>


<!--
Quick Fix for delete Flash
-->
<?php if(isset($_SESSION['deletedTitle'])):?>
<div id = "delete_flash_sec" class = "row-fluid">
	<div  class = "span10 prepend-top">
	<?php
		 $this->widget("ext.SimpleFlash", array('css'=>'alert-success', 'message'=>'<h3>Service Package Remove</h3> <p>You have removed the service package: <b><span id = "deletedTitle">'.$_SESSION['deletedTitle'].'</span></b></p>'));
		 unset($_SESSION['deletedTitle']);
	?>
	</div>
</div>
<?php endif; ?>

<?php if(isset($_SESSION['justAddedPackage'])):?>
<div class = "row-fluid">
	<div  class = "span10 prepend-top">
	<?php $this->widget("BootAlert");?>
	</div>
</div>

<?php endif; ?>
<div class = "row-fluid">
	<div  class = "span10 prepend-top" >
	<?php echo CHtml::link('<i class = "icon-plus-sign"></i>Add New Service Package', array('packages/create'), array('class'=>'btn'));?>
	</div>
</div>

<div class="giant-reveal-modal">
<a class="close-reveal-modal close" rel="tooltip" data-original-title = "close" data-placement = "right" >&#215;</a>		
	<div class = "g_content">		
		<div style = "width: 31px; height:31px; padding-top: 10px; margin: 0px auto;">
			<?php  echo CHtml::image(Yii::app()->request->baseUrl.'/images/ajax-loader.gif'); ?>
		</div>
	</div>	   
</div>


<?php	
	$numberOfColumns = 4;
 ?>
<div class = "row prepend-top">
	<div class = "span12">
	
		<?php if($itemCount > 0):?>
	
	<!-- Packages for this Service Provider -->
		<ul class = "thumbnails">
		<?php for ($i = 0; $i < $itemCount; $i++):?>	
		<?php $package_title_link = $this->createUrl('packages/view', array('id'=>$packages[$i]->id));?>
			
			
			<li class = "span<?php echo (12/$numberOfColumns); if(isset($_SESSION['justAddedPackage']) && $_SESSION['justAddedPackage'] == $packages[$i]->id): echo " highlight"; unset($_SESSION['justAddedPackage']); endif;?>">
				<div class = "thumbnail">
				
					<?php echo CHtml::image("$baseUrl/$packages_dir".$packages[$i]->picture);?>
					<div class = "caption">
						<h5><?php echo CHtml::link($packages[$i]->title, $package_title_link)?></h5>
							<?php $discount = $packages[$i]->discount;?>
							<div class = "row-fluid prepend-top">
								<?php if($discount > 0):?>
								<div class = "span2">
									
									<div>		
										<div style = "position: relative; top: -10px;">							
											<div style = "width: 0px; border-right: 25px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-top: 25px solid transparent;progid:DXImageTransform.Microsoft.Alpha(opacity=0); /* IE6+ */-ms-filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0); border-left: 25px solid <?php echo ($discount > 0)?'#000':'transparent'?>; border-bottom: 25px solid <?php echo ($discount > 0)?'#000':'transparent'?>;">
								
											 </div>
										</div>
										<div style = "position: relative;">
											 <div style = "position: absolute; top: -30px; font-weight: bold; color: #fff; font-size: 0.8em">
												 &nbsp;- <?php echo $discount;?>%
											 </div>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class = "span<?php echo ($discount > 0)? '3': '4'; ?>">
									<div <?php echo ($discount <= 0)? 'style = "height: 50px;"':'';?>>
										<span class = "bold"><?php echo $packages[$i]->currency->symbol.number_format($packages[$i]->cost,2); ?></span>
										<br>
										<span class = "help-block" style = "font-size: 0.85em;"><?php echo Packages::costType($packages[$i]->cost_type) ?></span>
									</div>
								</div>
								<div class = "span4">
									<span class = "bold"><?php echo $packages[$i]->delivery ?></span>
									<span class = "bold"> day<?php echo (($packages[$i]->delivery > 1)? 's' : '') ?></span> 
									<br>
									<span class = "help-block" style = "font-size: 0.85em;">Est. Delivery</span>				
								</div>
								<div class = "span<?php echo ($discount > 0)? '3 ': '4 '; ?> bold">
									<?php echo $packages[$i]->units_bought; ?> <i class = "icon-shopping-cart"></i>									
								</div>						
							</div>							
				
					</div>
							
					
				</div>
				<div class = "thumbnail" style = "margin-top:3px;">
					<div class = "caption" style = "padding: 0px;">
						<div class = "row-fluid">
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-pencil"></i> Edit', array('packages/update', 'id'=>$packages[$i]->id),array('class'=>'update_link')) ?></div>
							<div class = "span4"><?php echo CHtml::beginForm(array('packages/delete', 'id'=>$packages[$i]->id, 'ajax'=>true), 'post', array('style'=>'margin:0px;')).CHtml::link('<i class = "icon-trash"></i> Delete','#',array('class'=>'delete_link')).CHtml::endForm(); ?></div>
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-eye-open"></i> View', $package_title_link, array('class'=>'view_link')) ?></div>
						</div>
					</div>
			 	</div>
			</li>
		<?php endfor; ?>	
		</ul>
		
		<!-- Sample package in the event that this Service Provider is yet to upload any packages -->
		<?php else: ?>
			<div class = "row-fluid">
				<div class = "span12 bordered box_shadow">
				
					<div class = "row-fluid">
						<div class = "span1">
							<?php echo CHtml::image($baseUrl.'/images/sample.png');?>
						</div>
						<div class = "span9">
							<div class = "prepend-top">
							<?php $this->widget('ext.SimpleFlash', array('message'=>'<h4>Hello '.$name.', Do you know you can create packages to 
							offer as a product on the Vcubator?</h4> 
							Service packages allow you to transform your services into a single fixed price item that can be bought off the shelf 
							by clients and customers. Click on any of the samples below to view or '.CHtml::link('click here', array('packages/create')).' to create yours and start receiving orders.'));?>
							</div>
						</div>
					</div>
				
					<div class = "row append-bottom">
						
						<div class = "span3 offset1 append-bottom">
							<?php $this->widget('ext.ServicePackageWidgets.Box',array(
										'package_title'=>'Monthly Bookkeeping for just R25/Month.',
										'package_dir'=>$packages_dir,
										'package_picture'=>'samples/bk_sample.png',
										'package_title_link'=>$this->createUrl('packages/view',array('sample'=>1, 'id'=>0)),
										'currency_symbol'=>'R',
										'package_cost'=>25.00,
										'package_cost_type'=>Packages::PER_MONTH,
										'package_delivery'=>30,
										'units_bought'=>50,		
								));
								?>
						</div>
						<div class = "span3">
							<?php $this->widget('ext.ServicePackageWidgets.Box',array(
										'package_title'=>'5-page Corporate Website.',
										'package_dir'=>$packages_dir,
										'package_picture'=>'samples/service_package.png',
										'package_title_link'=>$this->createUrl('packages/view',array('sample'=>2, 'id'=>0)),
										'currency_symbol'=>'R',
										'package_cost'=>1000.00,
										'package_cost_type'=>Packages::PER_MONTH,
										'package_delivery'=>1,
										'units_bought'=>45,		
										'class'=>'light_gold_border',
								));
								?>
						</div>
						<div class = "span3">
							<?php $this->widget('ext.ServicePackageWidgets.Box',array(
										'package_title'=>'I\'ll sue and do your contracts for only R150/Month.',
										'package_dir'=>$packages_dir,
										'package_picture'=>'samples/legal_sample.png',
										'package_title_link'=>$this->createUrl('packages/view',array('sample'=>'3', 'id'=>0)),
										'currency_symbol'=>'R',
										'package_cost'=>150.00,
										'package_cost_type'=>Packages::PER_MONTH,
										'package_delivery'=>30,
										'units_bought'=>60,		
								));
								?>
						</div>
					</div>
				</div>	
			</div>
		<?php endif;?>
		
		
	</div>
</div>







			





<?php Yii::app()->clientScript->registerScript('Packages_script', '

	if($(".highlight").length)
	{
		setTimeout(function(){$(".highlight").removeClass("highlight");}, 5000);
	}
	
	
	$(".close").tooltip();
	
	
	$(".offer_box").click(function(e){
				e.preventDefault();
				var link = $(this).find(".box_title").attr("href");
				if(!link)
				{
					link = "#";
				}
				$(".giant-reveal-modal").reveal({
			 	animation: \'fadeAndPop\', //fade, fadeAndPop, none
		    	 animationspeed: 300, //how fast animtions are
		    	 closeOnBackgroundClick: false, //if you click background will modal close?
		    	 dismissModalClass: \'close\'
				});
				
				$.ajax({
					url : link,
					success : function(data){
						$(".g_content").html(data);
					} 
				});
		});
		
	$(".view_link").click(function(e){
		e.preventDefault();
		var link = $(this).attr("href");
		$(".giant-reveal-modal").reveal({
	 	animation: \'fadeAndPop\', //fade, fadeAndPop, none
    	 animationspeed: 300, //how fast animtions are
    	 closeOnBackgroundClick: false, //if you click background will modal close?
    	 dismissModalClass: \'close\'
		});
		
		$.ajax({
			url : link,
			success : function(data){
				$(".g_content").html(data);
			} 
		});
	});
	

	
	$(".delete_link").click(function(e){		
		e.preventDefault();
		var form = $(this).parent("form");
		if(form.length)
		{			
			form.ajaxSubmit({
				url : $(this).attr("action"),
				type: "post",
				dataType: "json",
				success :  function(data){							
					window.location.href = \''.$this->createUrl("packages/index").'\';
				}
			});
		}		
			
	});	
		
		
		
', CClientScript::POS_READY);?>


