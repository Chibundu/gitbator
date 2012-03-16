<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qual')); ?>:</b>
	<?php echo CHtml::encode($data->qual); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sfrom')); ?>:</b>
	<?php echo CHtml::encode($data->sfrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sto')); ?>:</b>
	<?php echo CHtml::encode($data->sto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ref')); ?>:</b>
	<?php echo CHtml::encode($data->ref); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isVerified')); ?>:</b>
	<?php echo CHtml::encode($data->isVerified); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('serviceProviders_id')); ?>:</b>
	<?php echo CHtml::encode($data->serviceProviders_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qualificationCategory_id')); ?>:</b>
	<?php echo CHtml::encode($data->qualificationCategory_id); ?>
	<br />

	*/ ?>

</div>