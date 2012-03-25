<?php

function array_remove_key() { 
    $args = func_get_args(); 
    $arr = $args[0]; 
    $keys = array_slice($args,1); 
     
    foreach($arr as $k=>$v) { 
        if(in_array($k, $keys)) 
            unset($arr[$k]); 
    } 
    return $arr; 
} 

Yii::app()->clientScript->registerCss('neutralize','
	.neutralize
	{
		border: none;
		width: auto;
		height: auto;		
		box-shadow: none;
		-webkit-box-shadow:none;
	}
',
''
);
$this->breadcrumbs = array(	
	ucwords($this->module->id)=>array('/'.$this->module->id),
	ucwords($this->id)=>array('/'.$this->module->id.'/'.$this->id),
	ucwords($this->action->id)=>array($this->action->id),
	'Order'
);	
//initialize transaction-specific data
$firstname = '';
$lastname = '';
$email = '';
$address_firstline = '';
$address_secondline = '';
$address_city = '';
$address_country = '';
$address_country_code = '';
$postal_code = '';
$payment_id = '';
$enc_payment_id = '';
$item_name = '';
$item_description = '';
$unit_price = '';
$confirmation_address = '';

$security_signature='';
$cu = new CountryUtility();
if(substr($payment->payer, 0, 2) == 'sp')
{
	$spId = substr($payment->payer, 3);
	//get the Service Provider who is making the payment
	$tm = Miscellaneous::getTeamMember();
	$firstname = $tm->firstname;
	$lastname = $tm->lastname;
	$email = $tm->email;
	$confirmation_address = $tm->email;
	$address = $tm->serviceProvider->postalAddress;
	 
	$address_firstline = $address->firstline;
	$address_secondline = $address->secondline;
	$address_city = $address->city;
	$address_country = CountryUtility::$countries[$address->country];
	$address_country_code = $address->country;
	$postal_code = $address->postalCode;
}
$currency = Currencies::model();
$enc = new Encryption();
$unit_price = $payment->amount;
$item_name = $payment->for;
$item_description = 'Payment for '.$payment->for;
$payment_id = $payment->id;
$enc_payment_id = $enc->encryptData($payment_id, Yii::app()->params['enc_key']);

?>
<h3>Confirm Order</h3>
<div class="row-fluid prepend-top">
	<div class="span10 standout no-border no-pad">
		<table class="table table-condensed table-striped">		
		<?php if($order == null):?>
		<thead><tr><th>Description</th><th>Amount</th></tr></thead>
		<tbody><tr><td><?php echo $payment->for; ?></td><td><?php echo $payment->amount; ?></td></tr></tbody>
		<?php else:
		$cc = $currency->findByPk($order->currencies_id)->symbol; 
		?>
		<thead><tr><th>Description</th><th>Unit Price</th><th>Quantity</th><th>Amount</th></tr></thead>
		<tbody><tr><td><?php echo $payment->for; ?></td><td><?php echo $cc.$order->unit_price?></td><td><?php echo $order->qty; ?></td><td><?php echo $cc.$order->amount?></td></tr></tbody>
		<?php endif; ?>		
		</table>
	</div>
</div>
<div class="form-actions prepend-top">
<?php
$paymentTransaction = Yii::app()->paymentTransaction;
$config = $paymentTransaction->gatewayConfig;
$signature = '';
if(isset($config))
{
	if(isset($config[$payment->type][$payment->meansOfPayment]))
	{		
		$action_specific_config = $config[$payment->type][$payment->meansOfPayment];
		
		$content = '';
		$form = array('tag'=>'form');
		$formOptions = array();
		$i = 0;
		$submitButtonEntered = false;
		foreach ($action_specific_config as $a_config)
		{			
			if(($a_config['tag']!='form') && !(array_key_exists('generate-data', $a_config['htmlOptions'])))
			{		
				if(array_key_exists('append', $a_config['htmlOptions'])) 
				{
					if(isset($a_config['htmlOptions']['value']) && isset($a_config['htmlOptions']['append']))
					{
						$append = "&".$a_config['htmlOptions'];
						if(is_array($a_config['htmlOptions']['append']))
						{
							$append = '';
							foreach ($a_config['htmlOptions']['append'] as $key=>$value)
							{
								$append.="&".urlencode($key)."=".urlencode($$value);
							}
							unset($a_config['htmlOptions']['append']);
						}
						$a_config['htmlOptions']['value'].=$append;						
					}
				}						
				$content.= CHtml::tag($a_config['tag'], $a_config['htmlOptions']);
				if(array_key_exists('name', $a_config['htmlOptions']) && array_key_exists('value', $a_config['htmlOptions'])){
					
					if(strcasecmp($a_config['htmlOptions']['name'],'submit') == 0 || $a_config['htmlOptions']['value'] != '')
					{						
						$submitButtonEntered = true;
					}
					if($i++ == 0){
						$signature.=$a_config['htmlOptions']['name'].'='.urlencode($a_config['htmlOptions']['value']);
					}
					else
					{
						$signature.='&'.$a_config['htmlOptions']['name'].'='.urlencode($a_config['htmlOptions']['value']);
					}
				}
			}
			else if(($a_config['tag']!='form') && (array_key_exists('generate-data', $a_config['htmlOptions'])))
			{				
				$generate_data =  $a_config['htmlOptions']['generate-data'];
				$htmlOptions = $a_config['htmlOptions'];
				$htmlOptions =	array_remove_key($htmlOptions, 'generate-data');
				
				if($generate_data == 'security_signature')
				{	
						//echo $signature; exit;						
						$htmlOptions['value'] = md5($signature);										
				}
				else
				{					
					$htmlOptions['value'] = $$generate_data;					
					if(array_key_exists('name', $htmlOptions) && array_key_exists('value', $htmlOptions)){
						if(strcasecmp($htmlOptions['name'],'submit') == 0)
						{
							$submitButtonEntered = true;
						}
						if($i++ == 0){
							$signature.=$htmlOptions['name'].'='.urlencode($htmlOptions['value']);
						}
						else 
						{
							$signature.='&'.$htmlOptions['name'].'='.urlencode($htmlOptions['value']);
						}
					}
				}
				if(array_key_exists('append', $a_config['htmlOptions'])) 
				{
					if(isset($a_config['htmlOptions']['value']) && isset($a_config['htmlOptions']['append']))
					{
						$append = "&".$a_config['htmlOptions'];
						if(is_array($a_config['htmlOptions']['append']))
						{
							$append = '';
							foreach ($a_config['htmlOptions']['append'] as $key=>$value)
							{
								$append.="&".urlencode($key)."=".urlencode($$value);
							}
							unset($a_config['htmlOptions']['append']);
						}
						$a_config['htmlOptions']['value'].=$append;						
					}
				}
				$content.= CHtml::tag($a_config['tag'], $htmlOptions);
								
			}
			else
			{				
				$formOptions = $a_config['htmlOptions'];
			}
						
		}
		if($submitButtonEntered)
		{			
			$content.= CHtml::link('<i class = "icon-remove"></i>Cancel Order', array($this->id.'/cancel', 'id'=>$payment->id), array('class'=>'btn', 'style'=>'margin-left: 20px; position: relative; top: -10px;'));	
		}		
		else
		{
			$content.= CHtml::submitButton('Submit', array('class'=>'primary btn')).CHtml::link('Cancel Order', array($this->id.'/cancel', 'id'=>$payment->id), array('class'=>'btn', 'style'=>'margin-left: 20px;'));
		}
		if(!empty($form))
		{
			echo CHtml::tag('form', $formOptions, $content, true);	
		}		
		
	}
}


?>

</div>

