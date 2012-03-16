<?php
$this->breadcrumbs=array(	
	'Settings'=>array('/serviceproviders/settings'),
	'Currency',
);?>
<div class = "row-fluid">
<div class="span10">
<h2 class="append-bottom">My Currency: <?php $currency = Currencies::model()->findByPk($model->currency_id); echo $currency->literal.'('.$currency->code.')';?></h2>
<?php
$this->widget('ext.bootstrap.widgets.BootAlert');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm'); 
?>
<?php 

echo $form->dropDownListRow($model, 'currency_id', CHtml::listData(Currencies::model()->findAll(),'id','literal')); ?>
<p class="form-actions">
<?php
echo CHtml::submitButton('Submit', array('class'=>'nice gold radius button'));
?>
</p>
<?php 
$this->endWidget(); 
?>
</div>

</div>
