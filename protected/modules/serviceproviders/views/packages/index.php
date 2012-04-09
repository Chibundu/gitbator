<?php
$this->breadcrumbs=array(
	'Packages',
);
$itemCount = count($packages);
$baseUrl = Yii::app()->request->baseUrl;
$packages_dir = Yii::app()->params['service_packages_dir'];
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/ajax-form.js", CClientScript::POS_HEAD);


?>
<div class = "row-fluid prepend-top">
	<div  class = "span4">
	<h2>Service Packages(<?php echo $total; ?>)</h2>
	</div>
	<div  class = "span8">
	<div class = "right">
	<?php $this->widget('BootPager', array('pages'=>$pages,'prevPageLabel'=>'&laquo;', 'nextPageLabel'=>'&raquo;', 'htmlOptions'=>array('class'=>'pagination')));?>
	</div>
	</div>
</div>


<div class = "row-fluid">
	<div  class = "span10 prepend-top">
	<?php
		 $this->widget("BootAlert");		 
	?>
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

<!--
Quick Fix for pause Flash
-->
<?php if(isset($_SESSION['pauseTitle'])):?>
<div id = "delete_flash_sec" class = "row-fluid">
	<div  class = "span10 prepend-top">
	<?php
		 $this->widget("ext.SimpleFlash", array('css'=>'alert-success', 'message'=>'<h3>Service Package "'.$_SESSION['pauseTitle'].'" has been put on hold.</h3> Remember you can easily restore this package anytime by clicking on the resume button. </p>'));		 
	?>
	</div>
</div>
<?php endif; ?>

<!--
Quick Fix for resume Flash
-->
<?php if(isset($_SESSION['resumeTitle'])):?>
<div id = "delete_flash_sec" class = "row-fluid">
	<div  class = "span10 prepend-top">
	<?php
		 $this->widget("ext.SimpleFlash", array('css'=>'alert-success', 'message'=>'<h3>Service Package "'.$_SESSION['resumeTitle'].'" is now active. Interested buyers are now able to buy this package. </p>'));		 
	?>
	</div>
</div>
<?php endif; ?>

<?php if(!isset($_SESSION['resumeTitle']) && !isset($_SESSION['pauseTitle']) && isset($_SESSION['justAddedPackage'])):?>
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
		<?php
		 
		$current_package = $packages[$i];
		$status = $current_package->status;
		
		$package_title_link = $this->createUrl('packages/view', array('id'=>$current_package->id));?>
			
			
			<li class = "span<?php echo (12/$numberOfColumns); if(isset($_SESSION['justAddedPackage']) && $_SESSION['justAddedPackage'] == $current_package->id): echo " highlight"; unset($_SESSION['justAddedPackage']); unset($_SESSION['resumeTitle']); unset($_SESSION['pauseTitle']); endif;?>">
				
				<div class = "row-fluid">
					<div 
						<?php if($status == Packages::PENDING_APPROVAL)
							 {
							 	echo 'style = "width: 130px; float: right;"';
							 }							 
							 else 
							 {
							 	echo 'style = "width: 70px; float: right;"';
							 }
						  ?>" style = "float: right;">					
						<div style = "float: left;">
							<div class="circle small_circle 
							<?php
							 if($status == Packages::PENDING_APPROVAL)
							 {
							 	echo "yellow";
							 }
							 else if($status == Packages::ACTIVE )
							 {
							 	echo "green";
							 }
							 else 
							 {
							 	echo "red";
							 }
							  ?>_circular_gradient animate"></div>
						</div>	
						<div style = "float: left;">&nbsp;
							<?php 
								
								if ($status == Packages::PENDING_APPROVAL)
								{
									echo "Pending Approval";	
								}
								else if($status == Packages::ACTIVE)
								{
									echo "Active";
								}
								else 
								{
									echo "Paused";
								}
							?>
						</div>
					</div>	
				
			 	</div>	
				
				
				
				<div class = "thumbnail">
						<?php if($current_package->featured_priority >= Packages::HIGH): ?>
						<div style = "position: relative">					
							<div class="ribbon-wrapper-green"><div class="ribbon-green">Featured</div></div>
						</div>
						<?php endif; ?>
					<?php echo CHtml::image("$baseUrl/$packages_dir".$current_package->picture, '', array('height'=>'180px'));?>
					<div class = "caption">
						<h5 class = "ellipsis"><?php echo CHtml::link($current_package->title, $package_title_link)?></h5>
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
												 &nbsp;- <?php echo $discount;?>%
											 </div>
										</div>
									</div>
								</div>
								<?php endif;?>
								<div class = "span<?php echo ($discount > 0)? '3': '4'; ?>">
									<div <?php echo ($discount <= 0)? 'style = "height: 50px;"':'';?>>
										<span class = "bold" style = "word-wrap: break-word; font-size: 0.95em;"><?php echo $current_package->currency->symbol.number_format($current_package->cost,2); ?></span>
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
								<div class = "span<?php echo ($discount > 0)? '3 ': '4 '; ?> bold" style = "word-wrap: break-word; font-size: 0.95em;">
									<?php echo $current_package->units_bought; ?> <i class = "icon-shopping-cart"></i>									
								</div>						
							</div>							
				
					</div>
							
					
				</div>
				<div class = "thumbnail frame" style = "margin-top:3px;">
					<div class = "caption" style = "padding: 0px;">
						<div class = "row-fluid">
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-pencil"></i> Edit', array('packages/update', 'id'=>$current_package->id),array('class'=>'update_link')) ?></div>
							<div class = "span4"><?php echo CHtml::beginForm(array('packages/delete', 'id'=>$current_package->id, 'ajax'=>true), 'post', array('style'=>'margin:0px;')).CHtml::link('<i class = "icon-trash"></i> Delete','#',array('class'=>'delete_link')).CHtml::endForm(); ?></div>
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-eye-open"></i> View', $package_title_link, array('class'=>'view_link')) ?></div>
						</div>
					
						<div class = "row-fluid">							
							<?php if($status != Packages::PENDING_APPROVAL):?>
								<?php if($current_package->featured_priority < Packages::HIGH):?>
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-star-empty"></i> Feature', array('packages/feature', 'id'=>$current_package->id),array('class'=>'feature_link')) ?></div>
								<?php endif;?>
							<?php if($status == Packages::PAUSED):?>
							<div class = "span4"><?php echo CHtml::link('<i class = "icon-play"></i> Resume', array('packages/resume', 'id'=>$current_package->id),array('class'=>'resume_link')) ?></div>
							<?php else: ?>
							<div class = "span4">								
								<?php echo CHtml::link('<i class = "icon-pause"></i> Pause', array('packages/pause', 'id'=>$current_package->id), array('class'=>'pause_link')) ?>									
							</div>
							<?php endif;?>
							<?php endif;?>
						</div>						
					</div>
			 	</div>
			 	
			 	<div class = "thumbnail frame" style = "margin-top:3px;">
					<div class = "caption" style = "padding: 0px;">	
						<div class = "row-fluid">
							<h5 style = "color: #AFCF5C;"><?php echo CHtml::image("$baseUrl/images/graph.png");?> <span style = "position: relative; top: -5px;">PACKAGE SUMMARY REPORT</span></h5>	
						</div>
						<div class = "row-fluid">
							<div class = "span4 help-block"><span style = "font-size: 0.9em">UNITS SOLD</span><h5>50</h5></div>
							<div class = "span4 help-block"><span style = "font-size: 0.9em">REVENUE</span><h5 style = "color: #3366D1;">R50</h5></div>
							<div class = "span4 help-block"><span style = "font-size: 0.9em">VIEWS</span><h5>50</h5></div>
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
	
	if($(".thumbnails li").length)
	{
		$(".thumbnails li").mouseover(function(){
			$(this).addClass("highlight");
		}).mouseout(function(){
			$(this).removeClass("highlight");
		});
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
		confirm("Are you sure you want to delete this item? Deleting this item means it will no longer be available for purchase. Click on OK to delete or Cancel to abort this request.");
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
	
	$(".pause_link").click(function(e){		
		e.preventDefault();		
		if(confirm("Are you sure you want to pause this service package? This package will no longer be available to buyers for purchase. However you can always choose to restore it by clicking on the resume button.")){
			$.ajax({
				cache : false,
				url : $(this).attr("href"),
				dataType : "json",
				data : {requestType : "private"},
				success : function(data)
				{
					window.location.href = \''.$this->createUrl("packages/index").'\';
				}
			});		
		}
			
	});	
		
	$(".resume_link").click(function(e){		
		e.preventDefault();		
		if(confirm("You are about to resume this service package. This package will now be available to buyers for purchase; however, you can always choose to pause it again if you are not available to receive orders.")){
			$.ajax({
				cache : false,
				url : $(this).attr("href"),
				dataType : "json",
				data : {requestType : "private"},
				success : function(data)
				{
					window.location.href = \''.$this->createUrl("packages/index").'\';
				}
			});		
		}
			
	});		
			
	
		
', CClientScript::POS_READY);?>


