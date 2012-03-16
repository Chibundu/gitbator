<?php
$this->breadcrumbs=array(
	'Service Provider'=>array('/serviceproviders'),
	'Profile'=>array('profile/'),
	'Team',
);
?>
<?php $this->widget('ext.bootstrap.widgets.BootAlert'); ?>

<div class="row">
	<div class="span2">
		<h2>Team</h2>
	</div>
	<div class="span9">
		<?php echo CHtml::link('<i class = "icon-plus-sign"></i> Add New Team Member', array('team/create'), array('class'=>'btn right'));?>
	</div>
</div>

 <div class="row"> 
  
 <?php foreach ($teammembers as $teammember){ ?>
 	<div class="row span12 prepend-top">	 
 	<div class="span3 picture_bar <?php echo ($teammember->profile_picture != '')? 'not_empty':''; ?>">
	 <?php if($teammember->profile_picture != ''): 
	 		echo CHtml::image(Miscellaneous::getRelativeProfilePicturePath().$teammember->profile_picture);
	 	   
	 	   
	 	   endif;
	  ?>
	</div>
	<div class="span8">
	<h5><a style="text-decoration: none" name="<?php echo $teammember->fullName; ?>"><?php echo $teammember->fullName; ?></a> 
	 
	 <?php if($teammember->isTeamLeader):?>
	 <span class="label important">Admin</span>
	 <?php endif; ?><br/>	
	 
	 </h5>	
	   <?php 
	  	$qualifications = $teammember->qualifications;
	  	if(($n = count($qualifications)) != 0):
	  ?>	  
	  <span class="note">
	
	  <?php 	  	
	  	for($i = 0; $i < $n; $i++)
	  	{
	  		if($i == 0):
	  			echo $qualifications[$i]->qual;	  			  			
	  		else:
	  			echo ', '.$qualifications[$i]->qual;
	  		endif;
	  		if($i == $n - 1):
	  			echo '.';
	  		endif;
	  	}
	  ?>
	  
	  </span>
	 
	  <br/>
	  <?php endif; ?>
	 
	  <br/>
	 <span class="icon-envelope"></span> <?php echo $teammember->email; ?><br/>		 
	 <span class="phone"></span> 
	 <?php 
	 	if($teammember->phone==''):
	 		echo 'nil';	 	
	 	else: 
	 		echo $teammember->phone;
	 	endif;
	  ?>
	 
	  <?php 
	  	$skills = $teammember->skills;
	  	if(($n = count($skills)) != 0):
	  ?>
	  
	   <br/>
	  <span class="bold">Skills</span>:
	  <?php 	  	
	  	for($i = 0; $i < $n; $i++)
	  	{
	  		if($i == 0):
	  			echo $skills[$i]->name;	  			  			
	  		else:
	  			echo ', '.$skills[$i]->name;
	  		endif;
	  		if($i == $n - 1):
	  			echo '.';
	  		endif;
	  	}
	  ?>
	  <?php endif; ?>
	  
	   
	  
	  <div class = "btn-group">
	   		<?php echo CHtml::link('Manage <span class="caret"></span>', '#', array('class'=>'btn dropdown-toggle', 'data-toggle'=>'dropdown'))?>
	   		<ul class = "dropdown-menu">
	   			<li><?php echo CHtml::link('<i class = "icon-pencil"></i>Edit', array('team/update', 'id'=>$teammember->id));?></li>
	   			<li><?php echo CHtml::link('<i class = "icon-trash"></i>Remove', array('team/update', 'id'=>$teammember->id, 'remove'=>true), array('confirm'=>'Are you sure you want to remove this team member'));?></li>
	   			<li><?php echo CHtml::link('<i class = "icon-plus"></i>Add Qualification', array('qualification/create', 'id'=>$teammember->id));?></li>
	   		</ul>
	   		
	   </div>
	 </div>
	 
	 
	 </div>
	 	 
	 
	<?php } ?>
 </div>	 
