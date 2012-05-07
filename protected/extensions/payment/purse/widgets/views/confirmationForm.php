<?php
	$grandTotal = 0; 
	echo CHtml::beginForm($action, $method);
	
	//As a rule we will not allow multi-currencies to be batched together, so it is safe to take the first symbol
	$symbol = $orders[0]['currency_symbol'];
 ?> 
 <?php 
  $this->widget('ext.payment.orders.OrderSummary', array('orders'=>$orders));?>
<div class = "row-fluid prepend-top">
	<?php echo CHtml::submitButton('Confirm', array('class' => 'btn btn-success btn-large'));?>
	<?php echo CHtml::link($cancel_literal, $cancel_url, array('class'=>'right'));?>
</div>
<?php echo CHtml::endForm();?>