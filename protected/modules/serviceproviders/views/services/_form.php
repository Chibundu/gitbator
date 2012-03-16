<?php
	$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'services-form',
	'enableAjaxValidation'=>false,
));
	$baseUrl = Yii::app()->request->baseURL; 
	if(isset(Yii::app()->session['selectedCategory'])){
		$model->categories_id = Yii::app()->session['selectedCategory'];
	}
	else if($cat_id != 0)
	{
		$model->categories_id = $cat_id;
	}
?>
<span class="help-block note" >Please select a category. Choose 'Other' if you can't find the service you wish to add in any of the categories</span>
<div class="dec_box alt prepend-top" style="padding:10px 0px 0px 10px;">	
	<?php echo $form->dropDownListRow($model,'categories_id',$categories, array('id'=>'cat','class'=>'span6','maxlength'=>45)); ?>
</div>
	
	

<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('showServices',
'
	var showServices =	function(){ 

							$("#services").html(\''.CHtml::image($baseUrl."/images/loading.gif","loading..").'\');
								var category = $("#cat").val();
								$.ajax({
								url:"'.$baseUrl.'/serviceproviders/services/getServices",		
								type:"GET",
								data: "&id="+category,		
								success:function(data)
								{
									$("#services").html(data);
								}
							});
						}

	showServices();	
	
	$("#cat").bind("change",function(){
	showServices();
	});
	
', CClientScript::POS_READY);
?>
<div id="services">
</div>
