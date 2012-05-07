
<div class = "row-fluid prepend-top">
	<div  class = "span10 prepend-top">
	<h2>Order Summary</h2>
	</div>
</div>

<div class = "row-fluid prepend-top">
<div class = "span9">
<?php
$orderInfo = $orderConfig['orders'];
if($mode == "purse")
{
 	$this->widget('ext.InfoFlash', array('heading'=>'Order Confirmation', 'message'=>'<b>'.$orderInfo[0]['currency_symbol'].'</b> '.number_format($orderInfo[0]['unit_price'], 2). ' will be deducted from your VPurse account when you confirm this order.'));
 }
 else
 {
 	$this->widget('ext.InfoFlash', array('heading'=>'Order Confirmation', 'message'=>"To pay for your order via <b>".ucwords($mode)."</b>, please click the ".ucwords($mode)." button below."));
 }
 
?>
</div>
</div>


<div class = "row-fluid prepend-top">
	<div class = "span9">
	
	<?php
	
			$this->widget('ext.payment.'.$mode.'.widgets.Confirmation', array(	
					'payer_details'=>$payer_details,				 
					'orderConfig'=>$orderConfig,
					'orderFulfillmentUrl'=>$orderFulfillmentUrl,
					'cancel_literal'=>'Cancel Order',
					'cancel_url'=>$this->createUrl('packages/index'),
					'hosted_button_id'=>($mode == 'paypal')?'FMLTMD64EXT2A':'',
			));		
	?>
	</div>
</div>