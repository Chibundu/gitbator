<div class = "form ajax_update"> 
<?php
$form = $this->beginWidget('CActiveForm', array(
			'enableAjaxValidation'=>true,	
			'action'=>array('profile/index'),		
		));
 ?>
<div class = "row-fluid"> 
 <div class="span4">		
		Keywords
		</div>		
		
		
		
<div class="span7">		
		<?php echo $form->textField($model,'keywords', array('class'=>'span7')); ?>
		<?php echo $form->error($model,'keywords'); ?>
</div>
	
				
<div class="span1"><?php echo CHtml::submitButton("Update", array('class'=>'btn btn-small')) ?></div>
</div>	
 
 <?php $this->endWidget(); ?>
 
 </div>
 