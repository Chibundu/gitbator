<?php

	$grandTotal = 0;	
	//As a rule we will not allow multi-currencies to be batched together, so it is safe to take the first symbol
	$symbol = $orders[0]['currency_symbol'];
 ?>
<table class = "table table-bordered table-striped">
<thead class = "bold"><tr><td>Item #</td><td>Description</td><td>Quantity</td><td>Amount</td><td>Discount</td><td>Total</td></tr></thead>
<?php foreach($orders as $order):?>
<tr>
	<td>
		<?php
		 	$item = $order['item'];
			echo $item;
		?>
	</td>
	<td>
		<?php 
			$description = $order['description'];
			echo $description;
		?>
	</td>
	<td>
		<?php 
			$quantity = $order['quantity'];
			echo $quantity;
		?>
	</td>
	<td>
		<b>
			<?php echo $symbol; ?>
		</b> 
		<?php 
			$unit_price = $order['unit_price'];
			echo number_format($unit_price, 2);
		?>
	</td>
	<td>		
		<?php 
			$discount = $order['discount'];
			echo ($discount > 0)? $discount."%":"-"; //Since this is an order summary form containing many orders, it is difficult to hide the discount column when there's no discount applied
		?>
	</td>
	<td>		
		<?php 
			$totalAmount = $quantity * $unit_price;
			$total = number_format($totalAmount - (($totalAmount * $discount)/100), 2) ;
			$grandTotal += $total;	
			echo "<b>". $symbol."</b> ".$total;		
		?>
	</td>
</tr>

<?php endforeach;?>
<tr><td colspan="5"><b>GRAND TOTAL</b></td><td><?php echo "<b>". $symbol."</b> ". number_format($grandTotal, 2); ?></td></tr>
</table>
<hr>