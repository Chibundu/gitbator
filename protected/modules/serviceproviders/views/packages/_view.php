<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('picture')); ?>:</b>
	<?php echo CHtml::encode($data->picture); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost_type')); ?>:</b>
	<?php echo CHtml::encode($data->cost_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivery')); ?>:</b>
	<?php echo CHtml::encode($data->delivery); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('instructions')); ?>:</b>
	<?php echo CHtml::encode($data->instructions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('serviceproviders_id')); ?>:</b>
	<?php echo CHtml::encode($data->serviceproviders_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('servicecategories_id')); ?>:</b>
	<?php echo CHtml::encode($data->servicecategories_id); ?>
	<br />

	*/ ?>

</div>