<div class="row-fluid">
<div class = "span10">

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id'=>'teammembers-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

<?php $this->widget('ext.pixelmatrix.EUniform', array('selector'=>':file')); ?>



	<div class="row-fluid prepend-top append-bottom">
		<div class="span7">
			<span class="note hint">You cannot have more than 4 teammembers</span>
		</div>
	</div>
			
		<?php echo $form->fileFieldRow($model, 'profile_picture'); ?>	
	
		<?php echo $form->hiddenField($model, 'id',array('name'=>'id')); ?>
		<?php echo $form->textFieldRow($model, 'firstname', array('class'=>'span8')); ?>
		<?php echo $form->textFieldRow($model, 'lastname', array('class'=>'span8')); ?>
		<?php echo $form->textFieldRow($model, 'email', array('class'=>'span8')); ?>
		<?php echo $form->textFieldRow($model, 'skill', array('class'=>'span8')); ?>
		<?php if($model->isNewRecord): echo $form->passwordFieldRow($model, 'password', array('class'=>'span8')); endif; ?>
		<?php if($model->isNewRecord): echo $form->passwordFieldRow($model, 'password_repeat', array('class'=>'span8')); endif; ?>
		<?php echo $form->textFieldRow($model, 'phone', array('class'=>'span8')); ?>		
		
		<?php
			//if(Yii::app()->user->checkAccess('sp-teamleader')):
		 		//echo $form->dropDownListRow($model, 'isTeamLeader', array(0=>'No',1=>'Yes'));
		 	//endif; 
		 ?>
		<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update',array('class'=>'medium gold nice radius button')); ?>
	</div>
	


<?php $this->endWidget(); ?>
</div>
</div>