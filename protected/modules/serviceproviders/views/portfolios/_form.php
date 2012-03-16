<div class="row-fluid">
<div class="span10">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'portfolios-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="help-block append-bottom">Fields with <span class="required">*</span> are required.<br /><br />
	<span class="hint note">Upload any work samples(images/documents) here.
	Supported file types include: jpg,png,gif,pdf,ppt,doc,docx.
	</span>
	</p>

	<?php echo $form->errorSummary($model); ?>
	<?php echo CHtml::hiddenField('id', $model->id); ?>
	<?php echo $form->fileFieldRow($model, 'resource_location', array('class'=>'span10 pop', 'data-original-title'=>'Associated Graphics', 'data-content'=>'Remember what they say about pictures being worth a thousand words? Yes! Capture the attention of Vcubator entrepreneurs with a descriptive image of this portfolio Item.')); ?>
	
	<?php echo $form->textFieldRow($model,'tag',array('maxlength'=>45, 'class'=>"span10 pop", 'data-original-title'=>'Title', 'data-content'=>'Please enter a caption for this portfolio item')); ?>	
	<?php echo $form->textFieldRow($model,'associated_link',array('maxlength'=>45, 'class'=>"span10 pop",'data-original-title'=>'Associated Link', 'data-content'=>'Do you have a website that can further illustrate this portfolio item? Please enter the link to such a site here. For example: http://www.example.com')); ?>	
	<?php echo $form->textAreaRow($model,'Description',array('cols'=>'50', 'rows'=>'10','class'=>"span10 pop", 'data-original-title'=>'Portfolio Description', 'data-content'=>'In a few words(less than 500 characters), please describe this portfolio item.')); ?>
	<div class="form-actions">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'nice gold button')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
</div>
<?php Yii::app()->clientScript->registerScript('portfolio-tips', '
var pop = $(".pop");
	if(pop.length)
	{
		pop.each(function(){
			$(this).popover();
		});				
	}
', CClientScript::POS_READY);?>