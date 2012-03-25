<?php

	$baseUrl = Yii::app()->request->baseUrl;

	$email_address = '';
	$confirmation_address = '';
	$firstname = '';
	$lastname = '';	
	$security_signature = '';
	
	$orders = $orderConfig['orders'];
	$user_type = $orderConfig['user_type'];
	
	$payment_id = OrderHelper::getPOI($user_type, $order_ids);
	
	$summary = OrderHelper::getOrderSummary($orders);
	
	$amount = $summary['total'];
	$item_description = $summary['descriptions'];
	$item_name = $summary['items'];
	
	if(!empty($payer_details))
	{
		$email = $confirmation_address = $payer_details['email'];
		$firstname = $payer_details['firstname'];	
		$lastname = $payer_details['lastname'];		
	}

	$grandTotal = 0; 
	echo CHtml::beginForm($action, $method);
	
 ?> 
 <?php 
 
  $this->widget('ext.payment.orders.OrderSummary', array('orders'=>$orders));
 
 ?>
<div class = "row-fluid prepend-top">
	<?php  foreach ($configuration as $config)
	{		
		$htmlOptions = $config['htmlOptions'];
		
		if(array_key_exists('generate-data', $config['htmlOptions']))
		{
			
			$generate_data =  $htmlOptions['generate-data'];		
			unset($htmlOptions['generate-data']);			
			
			if($htmlOptions['name'] == 'signature')
			{
				$htmlOptions['value'] = md5(trim($$generate_data, '& '));
			}
			else
				$htmlOptions['value'] = $$generate_data;
		}
		
		if(isset($config['htmlOptions']['append']))
		{			
			$append = '';
			$append_val = $config['htmlOptions']['append'];
			
			if(is_array($append_val))
			{
				foreach($append_val as $key=>$value)
				{					
					$append.='&'.$key.'='.$$value;
				}
			}
			else
			{
				$append = $append_val;
			}
			unset($htmlOptions['append']);
			$htmlOptions['value'].=$append;
		}		
		
		if($htmlOptions['name'] != 'signature')
		{
			$security_signature .= "&".$htmlOptions['name']."=".urlencode($htmlOptions['value']);
		}			
		
		
		echo CHtml::tag($config['tag'], $htmlOptions);
	
	} 
	?>
	<?php
	echo CHtml::tag('input', array('name'=>'submit', 'type'=>'image', 'border'=>0, 'alt'=>'Payfast', 'src' => "$baseUrl/images/buynow_basic_logo.gif"))
	
	 .' '.CHtml::link($cancel_literal, $cancel_url, array('class'=>'right'));?>
</div>
<?php echo CHtml::endForm();?>