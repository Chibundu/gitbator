<?php
$baseUrl = Yii::app()->request->baseURL;
$this->breadcrumbs=array(
'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Verifications',
);?>

<div class="row-fluid append-bottom">
	<h2>Verifications(<?php echo $count; ?>)</h2>		
</div>

<div class="row-fluid">	
	 <?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>
  </div>


<div class="row-fluid"> 
<div class="span12">
  <div style="width: 200px; margin-bottom:3px; float: right;">	
		<div style="width: 200px;">
			<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px;color:#fff;font-weight: bold;background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-ok"></i></div>
			<div style="width: 170px; margin-bottom:1px;  height:22px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Verified(<b><?php echo $verifications->verifiedCount; ?></b>)</div>			
		</div>	 
		
	 	<div style="width: 200px;">
			<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px; color:#fff;font-weight: bold; background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-remove-sign"></i></div>
			<div style="width: 170px; height:22px;  margin-bottom:1px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Unverified(<b><?php echo $verifications->unverifiedCount; ?></b>)</div>			
		</div>	  
		
		<div style="width: 200px;">
			<div style="width: 22px; height:18px; border:1px solid #dddddd; padding-top: 5px; color:#fff;font-weight: bold; background-color: #F5F5F5; float: right; text-align: center;"><i class = "icon-repeat"></i></div>
			<div style="width: 170px; height:22px; padding: 3px 2px 0px 0px; float: right; text-align: right;">Pending(<b><?php echo $verifications->pendingCount;?></b>)</div>			
		</div>	  
 </div>
</div> 
 </div>

<div class = "standout no-border">  
 <div class = "row-fluid prepend-top">
 	<div class = "span12">
 	<table class = "table table-condensed table-striped">
 	
 	<?php if($page == 1):?>
 	
 	<tr>
 		<td>Email</td>
 		<td><?php echo ($verifications->email)? '<a href = "#" data-original-title="verified" rel="tooltip"><i class = "icon-ok"></i></a>': '<a href = "#" data-original-title="unverified" rel="tooltip"><i class = "icon-remove-sign"></i></a>'; ?></td>
 		<td><div class = "right"><?php echo ($verifications->email)? '<span class="right">Verified</span>':CHtml::link('<i class = "icon-share-alt"></i> Request Verification', array('verifications/email'), array('class'=>'btn'));?></div></td>
 	</tr>
 	
 	<tr>
 		<td>Mobile Phone</td>
 		<td><?php echo ($verifications->phone)? '<a href = "#" data-original-title="verified" rel="tooltip"><i class = "icon-ok"></i></a>': '<a href = "#" data-original-title="unverified" rel="tooltip"><i class = "icon-remove-sign"></i></a>'; ?></td>
 		<td><div class = "right"><?php echo ($verifications->phone)? '<span class="right">Verified</span>':CHtml::link('<i class = "icon-share-alt"></i> Request Verification', array('verifications/mobile'), array('class'=>'btn'));?></div></td>
 	</tr>
 	
 	<tr>
 		<td>Identity</td>
 		<td>
 		<?php
			if($verifications->identity):
				echo '<a href = "#" data-original-title="verified" rel="tooltip"><i class = "icon-ok"></i></a>';						
			elseif ($verifications->isIdentityRequestSent):
				echo '<a href = "#" data-original-title="pending" rel="tooltip"><i class = "icon-repeat"></i></a>';											 
			 else:
				echo '<a href = "#" data-original-title="unverified" rel="tooltip"><i class = "icon-remove-sign"></i></a>';					 	
			endif; 					
		?></td>
		<td>
			<div class = "right">
			<?php 			
				if($verifications->identity):
					echo '<b>Verified</b>';				
				elseif ($verifications->isIdentityRequestSent):
					echo '<i>Pending</i>';											 
				else:						
				 	echo CHtml::link('<i class = "icon-share-alt"></i> Request Verification', array('verifications/identity'), array('class'=>'btn'));
				endif;		
			?>
			</div>
		</td>
 	</tr>
 	
 	<?php endif; ?>
 	
 	<?php foreach ($qual as $key => $qual):?>	
 	<tr>
 		<td>
 			<?php echo $qual->qual; ?>(ref no: <?php echo $qual->ref; ?>)
 		</td>
 		<td>
 			<?php
				if($qual->isVerified):
					echo '<a href = "#" data-original-title="verified" rel="tooltip"><i class = "icon-ok"></i></a>';					
				elseif ($verifications->isIdentityRequestSent):
					echo '<a href = "#" data-original-title="pending" rel="tooltip"><i class = "icon-repeat"></i></a>';									 
				 else:
					echo '<a href = "#" data-original-title="unverified" rel="tooltip"><i class = "icon-remove-sign"></i></a>';						 	
				endif; 					
			?>
 		</td>
 		<td>
 			<div class = "right">
 			<?php
				if($qual->isVerified):
					echo '<b>Verified</b>';					
				elseif ($verifications->isIdentityRequestSent):
					echo '<i>Pending</i>';											 
				else:						
				 	echo CHtml::link('<i class = "icon-share-alt"></i> Request Verification', array('qualification', 'id'=>$qual->id), array('class'=>'btn'));
				endif;		
			?>
			</div>
 		</td>
 	</tr>
 	<?php endforeach;?>
 	
 	</table>
 	</div>
 </div>

<div class = "pagination">
<?php
$this->widget('BootPager', array(
	'pages'=>$pages,
));
?>
</div>

</div>