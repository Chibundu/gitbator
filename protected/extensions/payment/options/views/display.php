<?php $imgUrl = Yii::app()->request->baseUrl."/css/img/";?>
<table class = "table table-condensed bordered box_shadow">  
<?php foreach($options as $option):?>
  <tr>
    <td><?php echo CHtml::radioButton('payment_option', ($option['name']=='purse')?true:false, array('value'=>$option['name'], 'class'=>'payment_option')); ?></td>
    <td style = "text-align: center;"><?php echo CHtml::image("$imgUrl".$option['img']);?></td>
  </tr>
<?php endforeach;?>
</table>








<?php 
	$cs = Yii::app()->clientScript;	
	$cs->registerScript('payment_display_widget', '
		$(".payment_option").click(function(){	
			$(".thin_gold_border").removeClass("thin_gold_border");	
			$(this).parent().parent().addClass("thin_gold_border");
		});
	', CClientScript::POS_END);
?>
