<h1>Assign Privileges</h1>
<div class = "prepend-top">
<?php $this->widget('BootAlert');?>
</div>

<div class = "standout">
<?php echo CHtml::beginForm(array('accessControl/assign', 'post'));?>
<div class = "row-fluid">

<div class = "span4"><span class = "custom-label">Parent</span><?php echo CHtml::dropDownList('parent', NULL, CHtml::listData(Authitem::model()->findAll(), 'name', 'name')); ?></div>

<div class = "span6"><span class = "custom-label">Child</span><?php echo CHtml::dropDownList('child', NULL, CHtml::listData(Authitem::model()->findAll(), 'name', 'name')); ?>
&nbsp; &nbsp;<?php echo CHtml::submitButton('GO', array('class'=>'btn'));?>
</div>

</div>
<?php echo CHtml::endForm();?>

</div>

<div class = "row-fluid prepend-top">
<?php
$this->widget('CTreeView',array(
	'id'=>'authitem-treeview',
	'data'=>Authitemchild::model()->getTreeItems(),
	'control'=>'#treecontrol',
	'animated'=>'fast',
	'collapsed'=>false,
	'htmlOptions'=>array(
		'class'=>'gray'
	)
));
?>

</div>