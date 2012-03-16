<div class = "row">
<div class="nine columns">
<?php
if(Yii::app()->user->hasFlash('block-message error')): ?>
<?php $this->widget('ext.bootstrap.widgets.BootAlert', array(
		'keys'=>'block-message error',
		'options'=>array(
			'displayTime'=>'600000',
		),
));?>

<?php
endif;

?>
</div>
</div>