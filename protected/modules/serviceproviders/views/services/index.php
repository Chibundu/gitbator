<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Services',
);

?>
<div class="row-fluid append-bottom">
	<div class="span6">
		<h2>Services(<?php echo count($services)?>)</h2>
	</div>
	<div class="span6">
	<div class = "right">
	<?php echo CHtml::link('<i class = "icon-plus-sign"></i>Add New Service', array('services/update'), array('class'=>'btn'));?>
	</div>	 
	</div>
</div>

<?php $this->widget('ext.bootstrap.widgets.BootAlert');?>




<div class="row-fluid append-bottom">
	<div class = "span12 standout no-border no-pad">
		<table class = "table table-striped">
		<?php for($i=0; $i<count($services); $i++):?>
		<tr>	
		<td><?php echo $services[$i]->name; ?></td>
   		 <td><div class="right"><?php echo CHtml::link('<i class = "icon-trash"></i> ', array('services/delete', 'id'=>$services[$i]->id), array('confirm'=>'Are you sure you want to remove this service?','rel'=>'tooltip', 'data-original-title'=>'delete'));?></div></td>
   		 </tr>
		<?php endfor;?>
		</table>
	
	</div>
</div>
<?php if(count($otherServices)> 0):?>
	<h2>Other Services(<?php echo count($otherServices)?>)</h2>
	<div class="row-fluid">
		<div class = "span12">
		<table class = "table">
		<?php for($i=0; $i<count($otherServices); $i++):?>
		<tr>	
		<td><?php echo $otherServices[$i]->services; ?></td>
   		 <td><div class="right"><?php echo CHtml::link('<i class = "icon-trash"></i> ', array('services/deleteOtherServices', 'id'=>$otherServices[$i]->id), array('confirm'=>'Are you sure you want to remove this service?','rel'=>'tooltip', 'data-original-title'=>'delete'));?></div></td>
   		 </tr>
		<?php endfor;?>
		</table>
		</div>
	</div>
<?php endif; ?>

