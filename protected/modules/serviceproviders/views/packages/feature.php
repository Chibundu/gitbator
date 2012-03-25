<?php 
	$app = Yii::app();
	$baseUrl = $app->request->baseUrl;		
?>
<div class = "row-fluid prepend-top">
	<h2>Feature Package (id# <?php $normalizedId = $package->normalizedId;
echo $normalizedId?>)</h2>
</div>

<div class = "row-fluid prepend-top">
	<div class = "span9">
    <?php $this->widget('BootAlert'); ?>
	</div>
</div>

<div class = "row-fluid prepend-top">
	<div class = "span9">
		<?php $this->widget('ext.InfoFlash', array('heading'=>'What does it mean to feature a package?', 'message'=>'Featuring a package gives it prominence and makes it show  before others in search results and other displays on the Vcubator.'))?>	
	</div>
</div>


<div class = "row-fluid prepend-top">
	<div class = "span3">
	<?php echo CHtml::image($baseUrl."/".$app->params['service_packages_dir'].$package->picture, '', array('class'=>'picture_frame'))?>
	</div>
	<div class = "span6">
	<h3><?php echo $package->title; ?></h3>
	</div>
</div>


<div class = "row-fluid prepend-top">
<div class = "span9">
<hr>
</div>
</div>

<div class = "row-fluid prepend-top">
<div class = "span9">
	<h4>Price: <?php echo "$currency_symbol $price";?></h4>
	<h4>Feature Duration: <?php echo $duration?> Days</h4>
</div>
</div>

<div class = "row-fluid prepend-top">
You have decided to fetaure this package ID # <b><?php echo $normalizedId; ?></b>. This package will be featured for <b>30 days</b> and  <b>R200</b> will charged.
</div>

<div class = "row-fluid prepend-top">
<h3>Select Payment Method</h3>
</div>

<div class = "row-fluid">
<div class = "span6 prepend-top">
<?php $this->widget('ext.payment.options.Display');?>
</div>
</div>


<div class = "row-fluid">
	<div class = "span6">
		<?php echo CHtml::link('Buy <i style = "position: relative; top: 6px;" class = "icon-shopping-cart icon-white"></i> ', array('packages/confirmFeatureOrder', 'id'=>$id, 'mode'=>'purse'), array('class'=>'prepend-top buy btn btn-success large-btn'));?>
	</div>
</div>


<?php $app->clientScript->registerScript('feature-js', '

		$(".payment_option").change(
			function()
			{
				var payment_option = $(this).val();
				$(".buy").attr({
					\'href\' :\'/serviceproviders/packages/confirmFeatureOrder?id='.$id.'&mode=\'+ payment_option
				});
				
			}
		);		
				
		', CClientScript::POS_END);
?>

		