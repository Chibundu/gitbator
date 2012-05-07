
<h3 class = "append-bottom">Manage and Track Order #<?php echo $order_id; ?></h3>

<?php if(Yii::app()->user->hasFlash('success')):?>
<div class = "row-fluid prepend-top order_success_alert">
	<div class = "span9">		
		<?php $this->widget('ext.InfoFlash', array('css'=>'alert-success', 'message'=>Yii::app()->user->getFlash('success'))); ?>
		<hr>
	</div>
</div>
<?php endif;?>

<?php if(Yii::app()->user->hasFlash('error')):?>
<div class = "row-fluid prepend-top">
	<div class = "span9">		
		<?php $this->widget('BootAlert'); ?>
		<hr>
	</div>
</div>
<?php endif;?>

<?php $this->widget('ext.ServicePackageWidgets.PackageOrder', array(			
			'status'=>$status,
			'package_pic'=>$package_pic,
			'package_title'=>$package_title,
			'instructions'=>$instructions,
			'spId'=>$spId,
			'spName'=>$spName,
			'dateOrdered'=>$dateOrdered,
			'order_id'=>$order_id,
			'order_req'=>$order_req,
			'etPic'=>$etPic,
			'etName'=>$etName,
			'tlName'=>$tlName,
			'tlPic'=>$tlPic,
			'isReqSent'=>$isReqSent,
			'hasMessage'=>$hasMessage,
			'duration'=>$duration,
		));
?>

