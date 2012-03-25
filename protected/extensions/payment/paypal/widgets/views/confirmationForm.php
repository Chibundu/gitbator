<?php	

	$email = '';
	$firstname = '';
	$lastname = '';
	$firstline = '';
	$secondline = '';
	$city = '';
	$postalCode = ''; 
	$country_code ='';
	
	if(!empty($payer_details))
	{
		$email = $payer_details['email'];
		$firstname = $payer_details['firstname'];	
		$lastname = $payer_details['lastname'];
		$firstline = $payer_details['address']['firstline'];	
		$secondline = $payer_details['address']['secondline'];
		$city = $payer_details['address']['city'];
		$postalCode = $payer_details['address']['postalCode'];
		$country_code = $payer_details['address']['country_code'];
	}

	$grandTotal = 0; 
	echo CHtml::beginForm($action, $method);
	
	//As a rule we will not allow multi-currencies to be batched together, so it is safe to take the first symbol
	$symbol = $orders[0]['currency_symbol'];
 ?> 
 <?php 
  $this->widget('ext.payment.orders.OrderSummary', array('orders'=>$orders));?>
<div class = "row-fluid prepend-top">
	<?php  foreach ($configuration as $config)
	{		
		$htmlOptions = $config['htmlOptions'];
		
		if(array_key_exists('generate-data', $config['htmlOptions']))
		{
			
			$generate_data =  $htmlOptions['generate-data'];		
			unset($htmlOptions['generate-data']);			
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
					$append.='&'.urlencode($key).'='.urlencode($$value);
				}
			}
			else
			{
				$append = $append_val;
			}
			unset($htmlOptions['append']);
			$htmlOptions['value'].=$append;
		}
		
		echo CHtml::tag($config['tag'], $htmlOptions);
	
	} 
	?>
	<?php echo CHtml::link($cancel_literal, $cancel_url, array('class'=>'right'));?>
</div>
<?php echo CHtml::endForm();?>