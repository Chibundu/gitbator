<?php
	$teamLeader = $sp->teamLeader;
	$verification = $sp->verification;
	$qualifications = $sp->qualAndHolder;
	$baseUrl = Yii::app()->request->baseURL;
	
?>
<div class = "standout">
<div class="row-fluid">

<h2><?php echo $sp->displayName;?>
 	<span style="color: #ccc; font-style: italic; font-size: 10px;"><?php echo $sp->tagline; ?></span>
 </h2> 
 </div>

 <div class="row-fluid"> 
   </div>
   <?php if($sp->businessName != ''):?>
    <div class="row-fluid"> 	

	  <div class="span3">
	 	 	<h5><?php echo ucwords($sp->accountType); ?></h5>
	 	 </div>
	<div class="span5">
		<div class="row-fluid">
	 		<?php if($sp->pic != '' && $sp->pic != Null):?>  
  			<?php echo CHtml::image(Miscellaneous::getRelativeLogoPath().$sp->pic);?>
	   		<?php endif; ?>
   		</div>
   		<div class="row-fluid">
   		<?php echo $sp->businessName; ?>
   		</div>
	</div>
	
	 <div class="span3">
	 	 	<?php
	 	 	 if($verification->identity): echo '<i class = "icon-ok-sign"></i> '.'<span class="hint note"><i>Verified</i></span>';
	 	 	 endif;
	 	 	 ?>
	 	 </div>
	</div> 
	<?php endif;?>
 

  <div class="row-fluid prepend-top"> 	 	
	 	<div class="span3 bold">
	 		<h5>Member Since</h5>
	 	</div>
	 	<div class="span6"> 	
	 		<?php echo date('d, M, Y', $sp->created_on)?>
	 	</div> 	
 </div>	
 	

 <div class="row-fluid prepend-top"> 	
	<div class="span3">
		<h5>Rating</h5>
	 </div>
	 <div class="span6"> 	
	 		<?php $this->widget('CStarRating',array(
				'minRating'=>1,
				'maxRating'=>5,		
    			'name'=>'rating',
    			'value'=>$sp->rating,
   				'readOnly'=>true,		
				));
			 ?>
	 </div>
 </div>

 <div class="row-fluid prepend-top"> 	
 	<div class="span3">
 		<h5>Services Offered</h5>
 	</div>
 	<div class="span6"> 	
 		<?php echo ($sp->getServices()!= '')?$sp->getServices():'None specified yet'; ?>
 	</div> 	
 </div>
 
  <div class="row-fluid prepend-top"> 	
 	<div class="span3">
 		<h5>Specific Skills</h5>
 	</div>
 	<div class="span6"> 	
 		<?php echo ($sp->getSkills())? $sp->getSkills() : 'None specified yet'; ?>
 	</div> 	
 </div>
 

 
  <?php if(count($qualifications) > 0):?>  
  <div class="row-fluid prepend-top"> 
	 	<div class="span3">
	 		<h5>Qualifications</h5>
	 	</div>
	 	<div class="span9">
	 	<?php foreach ($qualifications as $i => $qual):?>
	 		<div class="row-fluid">	
	 			 		
 				<div class="span3">
 					<?php echo $qual->holder->fullName; ?>
 				</div>
 				<div class="span3">
 					<?php echo $qual->qual; ?>
 				</div>
 				<div class="span3">
	 				<?php
 				 if($qual->isVerified):
 					 echo '<span class="hint note right"><i class = "icon-ok-sign"></i> <i>Verified</i></span>';	 													 
				 else:
				 	echo '<span class="hint note right"><i class = "icon-remove-sign"></i> <i>Unverified</i></span>';										 	
				endif; 			
 				?>			
 				</div>	 			
	 		 			
	 		</div>
	 	<?php endforeach;?>
	 	</div>
	 </div>
	 
 	<?php endif; ?>

 
 <?php if($sp->overview != '' && $sp->overview != NULL): ?>
  <div class="row-fluid prepend-top"> 	
 	<div class="span3 bold">
 	About Us 
 	</div>
 	<div class="span6"> 	
 		<?php echo $sp->overview; ?>
 	</div> 	
 </div>

 <?php endif;
 if(count($sp->portfolio) > 0): 
 ?>
 <hr />
 <div class="row-fluid prepend-top">
 	<h5>Portfolio</h5> 
 	</div>
 <div class="row-fluid">	
<?php $this->widget('ext.portfolio.PortfolioWidget', array('portfolio'=>$sp->portfolio));?>
 </div>
  <hr />
 <?php endif; ?>
</div> 
 
