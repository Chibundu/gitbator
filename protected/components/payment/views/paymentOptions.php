<?php
$this->breadcrumbs = array(	
	ucwords($this->module->id)=>array('/'.$this->module->id),
	ucwords($this->id)=>array('/'.$this->module->id.'/'.$this->id),
	ucwords($this->action->id)=>array($this->action->id),
	'Payment Options'
); 
$baseUrl = Yii::app()->request->baseUrl; 
echo CHtml::beginForm($action, 'POST');
echo CHtml::hiddenField('payment_id', $model->id);
echo CHtml::hiddenField('cancel_url', $cancel_url);
?>	
		
  <table class = "table table-condensed table-striped standout no-border">
  <?php
  	$i = 0;
   foreach ($options as $key=>$option):
  	$tc = '';
  	if(!empty($transactionCharge[$key]['multiply']))
  	{
  		$tc.=($transactionCharge[$key]['multiply']*100).'%';
  	}
  	if(!empty($transactionCharge[$key]['add']))
  	{  		
  		//if the payment currency differs with that of the payment gateway, then convert to the payment currency
  		if(isset($transactionCharge[$key]['currency']) && $currency != $transactionCharge[$key]['currency'])
  		{
  			$add = CurrencyConverter::convert($transactionCharge[$key]['currency'], $transactionCharge[$key]['add'], $currency);
  		}
  		else
  		{
  			$add = $transactionCharge[$key]['add'];
  		}
  		$add = number_format($add, 2);
  		$tc.=" + $currency$add.";
  	}
  	if($transactionCharge[$key]['multiply'] == 0)
  	{
  		$tc = 'No charges apply here.';
  	}
  ?>
    <tr>   
      <td>
        <input type="radio" name="Payment_Option" value="<?php echo $key; ?>" id="Payment_Options_<?php echo $i++; ?>"  />
       </td>
     	<td>     	 
       	 <?php echo CHtml::image($baseUrl.'/images/'.$brands[$key])?>       	
     	</td>
     	 <td>        	 	       	
       	<h4><?php echo $option ?></h4>
       	Transaction Charge: <?php echo $tc; ?>
     	</td>
     	
    </tr>
  <?php endforeach; ?>
  </table>
  <div class="form-actions prepend-top">
  <?php echo CHtml::submitButton('Cancel', array('name'=>'cancel', 'class'=>'btn'));?>
  &nbsp;&nbsp; 
  <?php echo CHtml::submitButton('Proceed', array('name'=>'proceed', 'class'=>'gold nice radius button'));?>
  </div>
<?php echo CHtml::endForm(); ?>
<?php
Yii::app()->clientScript->registerScript('payment','	
				var rows = $("table tr");
				var rb = $("table tr input:radio");
				if(rows.length)
				{		
					rows.each(
					function()
					{
						$this = $(this);				
						$this.children("td").css({"border-left":"none"});
						$this.children("td").first().css({"padding-left":"40px"});			
					}
				);	 	
		}
		if(rb.length)
		{			
			rb.click(function()
			{		
				rb.parent("td").parent("tr").removeClass("alt");				
				$(this).parent("td").parent("tr").addClass("alt");			
			});
		}
	', CClientScript::POS_READY);  
?>