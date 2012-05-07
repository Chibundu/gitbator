<?php
$this->breadcrumbs = array(
						'profile'=>array('/serviceproviders/profile'),
						'Profile Picture'
					); 
?>

<h2 class="append-bottom">Change Logo</h2>
<?php $this->widget('ext.pixelmatrix.EUniform', array('selector'=>':file')); ?>


<div class="row">
<div class = "span6">
<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
</div>	
</div>
<?php 
		$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(	    
	    'enableAjaxValidation'=>false,
	    'htmlOptions' =>array('enctype'=>"multipart/form-data" )
	
	));
	?>
	<div class="row bottomborder">
		<div class="span5">
		<?php
				$pic = Miscellaneous::getLogo();				
				$picPath = Miscellaneous::getRelativeLogoPath();
				
				if($pic == null || $pic==''):?>
				<div id="logo_bar"></div>
				<?php 
				else:
				?>
				<div class="center"><?php echo CHtml::image($picPath.$pic); ?></div>
				<?php 
				endif; 
		?>
		</div>				
	</div>	
	
	<div class="row">
	
	<div class="span5">
		<?php echo $form->fileFieldRow($model, 'pic', array('class'=>'span5')); ?>
	</div>	
	
	</div>
	<div class = "row">
	<div class = "span5">
	<div class = "form-actions">											
		<?php  echo CHtml::submitButton('Upload', array('class'=>'nice gold radius button')); ?>
	
	</div>
	</div>
	</div>
	
	<div class="row prepend-top">
	<div class = "span12">
		<div class="hint note center">(Images are cropped to 90px X 60px)</div>
	</div>
	</div>
		
	<?php  $this->endWidget(); ?>
	

