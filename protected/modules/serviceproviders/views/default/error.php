<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="row span16">
<h3>Error <?php echo $code; ?></h3>

<div class="row error span15">
<?php echo CHtml::encode($message); ?>
</div>

</div>