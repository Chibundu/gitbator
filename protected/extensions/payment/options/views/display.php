<div class = "rounded bordered no_bottom_border">
	<?php foreach($options as $option):?>
	<div class = "row-fluid bottom_bordered <?php echo ($option['name']=='purse')? 'thin_gold_border':''?>">		
			<div class = "span3" style = "padding-top: 20px;"><?php echo CHtml::radioButton('payment_option', ($option['name']=='purse')?true:false,array('value'=>$option['name'], 'class'=>'payment_option', 'style'=>'margin-left: 20px;')); ?></div>
			<div class = "span9" style = "padding-top: 3px;padding-top: 3px;"><?php echo CHtml::image($option['graphic']);?></div>		
	</div>
<?php endforeach;?>
</div>



<?php 
	$cs = Yii::app()->clientScript;	
	$cs->registerScript('payment_display_widget', '
		$(".payment_option").click(function(){	
			$(".thin_gold_border").removeClass("thin_gold_border");	
			$(this).parent().parent().addClass("thin_gold_border");
		});
	', CClientScript::POS_END);
?>
