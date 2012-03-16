<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Settings'=>array('/serviceproviders/settings'),
	'Payment',
);
$baseUrl = Yii::app()->request->baseUrl;
?>

<h3>Payment</h3>
<?php if(count($myServices)> 0):?>
<div class="row append-bottom" style="padding-bottom: 5px;">
	<div class="dec_box span11">
		<?php for($i=0; $i<count($myServices); $i++):?>
		
		<div class="row">		
			<div class="span11 <?php echo ($i % 2 == 0)?'alt': ''; ?>">
				<?php if($myServices[$i]->rate == NULL):?>	
				<div class="span3"><?php echo $myServices[$i]->name; ?></div>		
				<div class="span4 vertical_pad">
					<?php echo CHtml::beginForm(array('settings/setPricing'), 'post', array('style'=>'margin-bottom: 2px; padding-bottom: 5px'))?>
					<?php echo CHtml::hiddenField('id', $myServices[$i]->id); ?>									
					<?php echo CHtml::submitButton('Set Pricing', array('class'=>'btn default small_btn right'))?>				
					<?php echo CHtml::endForm();?>		
				</div>
				<div class="span2 vertical_pad right">
				<?php echo CHtml::image($baseUrl.'/css/img/unverified.png')?>
				</div>	
				<?php endif;?>		
			</div>		
		</div>
		
			
		<?php endfor;?>
	</div>
</div>
<?php endif; ?>
<?php if(count($myOtherServices)> 0):?>
	<h3>Other Services(<?php echo count($myOtherServices)?>)</h3>
	<div class="row" style="padding-bottom: 5px;">
		<div class="dec_box span11">
			<?php for($i=0; $i<count($myOtherServices); $i++):?>
				<div class="dec_row <?php echo ($i % 2 == 0)?'alt': ''; ?>">
					<?php echo CHtml::beginForm(array('services/deleteOtherServices'), 'post', array('style'=>'margin-bottom: 2px; padding-bottom: 5px'))?>
					<?php echo CHtml::hiddenField('id', $myOtherServices[$i]->id); ?>
					<?php echo $myOtherServices[$i]->services; ?>
					<?php echo CHtml::submitButton('Set Pricing',array('class'=>'btn default small_btn right'))?>
					<?php echo CHtml::endForm();?>
				</div>
			<?php endfor;?>
		</div>
	</div>
<?php endif; ?>