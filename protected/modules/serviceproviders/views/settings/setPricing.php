<?php

$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Settings'=>array('/serviceproviders/settings'),
	'Payment' =>array('serviceprovider/settings/payment'),
	'Set Pricing'
);
$baseUrl = Yii::app()->request->baseUrl;
?>
<h3>Set Pricing: <?php echo $service->name?></h3>

<div class="span11">
	<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm');?>
	<div class="span10">
		<?php echo $form->dropDownListRow($pf, 'type', CHtml::listData(RateType::model()->findAll(), 'id', 'rateType'), array('id'=>'type') )?>
	</div>
	<div class="span10" id="input"> 
	</div>
	<?php $this->endWidget();?>
</div>

<?php Yii::app()->clientScript->registerScript('showPaymentSettingsInput', '
	var showInput = function()
	{
		$("#input").html(\''.CHtml::image($baseUrl."/images/loading.gif","loading..").'\');
		
			var type = $("#type").val();
								$.ajax({
								url:"'.$baseUrl.'/serviceproviders/settings/getPaymentTypeForm",		
								type:"GET",
								data: "&type="+type+"&form="+'.CJSON::encode($pf).',		
								success:function(data)
								{
									$("#input").html(data);
								}
							});
		
	}
	showInput();
	$("#type").bind("change",function(){
		showInput();
	});

', CClientScript::POS_READY);?>