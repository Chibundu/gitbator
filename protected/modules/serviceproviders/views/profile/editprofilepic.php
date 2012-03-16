<?php
$this->breadcrumbs = array(
						'profile'=>array('/serviceproviders/profile'),
						'Profile Picture'
					); 
?>


<h2 class="append-bottom">Change Profile picture</h2>


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
		<div class="span6">
		<div class="picture_bar <?php if($model->profile_picture!='' && $model->profile_picture!=null):?> not_empty<?php endif;?>">
			<?php 
				if($model->profile_picture!='' && $model->profile_picture!=null): 
						echo CHtml::image(Miscellaneous::getRelativeProfilePicturePath().$model->profile_picture);
				endif;
			 ?>
		</div>
		</div>				
	</div>	
	
	<div class="row">
	
	<div class="span6">
		<?php echo $form->fileFieldRow($model, 'profile_picture',array('class'=>'span6')); ?>
	</div>
	</div>
	<div class = "row">
		<div class = "span6">
			<div class = "form-actions">												
				<?php  echo CHtml::submitButton('Upload', array('class'=>'nice gold radius button')); ?>		
			</div>
		</div>
	</div>
	
	<div class="row">
	<div class = "span6">
	<div class="hint note center">(Images are cropped to 90px X 60px)</div>
	</div>
	
	</div>
		
	<?php  $this->endWidget(); ?>


<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>	


