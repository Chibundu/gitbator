<?php
$baseUrl = Yii::app()->request->baseURL;
$this->breadcrumbs=array(
	'Profile'=>array('profile/'),
	'Email',
);?>

<div class="row-fluid">
<div class = "span8"><h2>Primary Email(<?php echo $email; ?>)</h2></div>
<div class="span4"><?php echo CHtml::link('<i class = "icon-share-alt"></i> Change', array('#'), array('class'=>'btn', 'id'=>'changeLink'));?> </div>
</div>

<div class="row-fluid">
<div class="span8 prepend-top">
<?php $this->widget('ext.bootstrap.widgets.BootAlert');?>
</div>
</div>

<div class="row-fluid">
<div id="editForm" class="<?php echo ($teamLeader->hasErrors('email'))?'':'hide' ?> border">
<div class = "row-fluid">
<div class = "span12 standout no-border">

<?php  $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm')?>

<?php  echo $form->textFieldRow($teamLeader,'email',array('class'=>'span6')); ?>
	
<div class="row-fluid">
	<div class="span4">
		<?php  echo CHtml::submitButton('update',array('class'=>'nice gold radius button')); ?>
	</div>
</div>
<?php $this->endWidget();?>
</div>
</div>
</div>
</div>
<?php Yii::app()->clientScript->registerScript('toggleEdit','			
	$("#changeLink").bind("click",
		function(event)
		{	
			event.preventDefault();
			if($("#editForm").length)
			{				
				$("#editForm").slideDown(1000);
			}		
		}
	);
',CClientScript::POS_READY);?>

