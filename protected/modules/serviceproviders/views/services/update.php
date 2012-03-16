<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Services'=>array('services/'),
	'Update Services'
);

?>

<h2>Add Services</h2>
<span class="hint note">All fields marked <span class="required">*</span> are required</span>
<?php $this->widget('ext.bootstrap.widgets.BootAlert',array('htmlOptions'=>array('class'=>'prepend-top')));?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'categories'=>$categories,'cat_id'=>$cat_id)); ?>
<?php
Yii::app()->clientScript->registerScript('validateServices','
	function validateServices(){		
		var n = $("input:checked").length;
		if(n >'.Yii::app()->params['maxServices'].'){
			alert("You cannot register for more than 5 services!");
			return false;
		}	
		return true;
} 
', CClientScript::POS_END);
	
?>