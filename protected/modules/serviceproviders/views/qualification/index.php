<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Qualifications',
);
$baseUrl = Yii::app()->request->baseURL;
?>

<div class = "row-fluid">
<div class = "span4">
<h2>Qualifications(<?php echo $stat['numQual']?>)</h2>
</div>
<div class ="span8">
<div class = "right">
	 <?php echo CHtml::link('<i class = "icon-plus-sign"></i>Add Qualification', array('qualification/create'), array('class'=>'btn'));?>
		<?php echo CHtml::link('<i class = "icon-eye-open"></i>View Team Members', array('team/'), array('class'=>'btn'));?>
	</div>
</div> 
</div>


<div class="row-fluid">
	  <div style="width: 200px; margin-top: 25px; margin-bottom:3px; float: right;">	
			<div style="width: 200px;">
				<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px;color:#fff;font-weight: bold;background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-ok"></i></div>
				<div style="width: 170px; margin-bottom:1px;  height:22px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Verified Qualifications(<b><?php echo $stat['numVerifiedQual']; ?></b>)</div>			
			</div>	 
			
		 	<div style="width: 200px;">
				<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px; color:#fff;font-weight: bold; background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-remove-sign"></i></div>
				<div style="width: 170px; height:22px; margin-bottom:1px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Unverified Qualifications(<b><?php echo $stat['numUnverifiedQual']; ?></b>)</div>			
			</div>	  
			
			
			<div style="width: 200px;">
				<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px; color:#fff;font-weight: bold; background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-repeat"></i></div>
				<div style="width: 170px; height:22px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Pending Verifications(<b><?php echo $stat['numPendingQual']; ?></b>)</div>			
			</div>
	 </div>
</div> 
  	
 <div class="row-fluid prepend-top">
 <div class="span12 standout no-border no-pad"> 

<?php

$this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'qualification-grid',
	'dataProvider'=>$model->search(),  	
    'itemsCssClass'=>'table table-striped table-condensed',
	'pager'=>array('class'=>'BootPager'),
	'pagerCssClass'=>'pagination',
	//'filter'=>$model,
	'columns'=>array(
		/*'id',*/
		array(
			'name'=>'teammember_id',
			'type'=>'raw',
			'value'=>'CHtml::link($data->holder->shortName, array("team/index#".$data->holder->fullName))',			
		),
		array(
			'name'=>'qual',
			'type'=>'raw',
			'value'=>'CHtml::link($data->qual,array("view", "id"=>$data->id), array("title"=>"Click to view in full"))',			
		),
		'institution',
		'sto',	
		'ref',		
		/*'sfrom',*/			
		/*'description',*/		
		array(
			'name'=>'isVerified',
			'type'=>'raw',
			'value'=>'$data->verificationIcon',
		),
		/*
		'serviceProviders_id',
		'qualificationCategory_id',
		*/
		array(
			'class'=>'BootButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
		),
	),
)); ?>
</div>
</div>