<?php
$this->breadcrumbs = array(
							'Service Provider'=>array('/serviceproviders'),
							'Profile'=>array('profile/'),
						'Contact',						
					);
 ?>
  <h2>Addresses(2)</h2>
   <div class="row-fluid prepend-top"> 	
  <?php $this->widget('BootAlert'); ?>	 
 	</div>
  
 <div class="row-fluid"> 
	 <h4>Physical</h4>	 	 
	 <div class="row-fluid append-bottom">
	  <?php if ($address->firstline != ''):?>
		 <div class="ten columns" style="border-bottom: 1px solid #f3f3f3;">
			 <?php echo $address->firstline; ?><br/>
			 <?php if($address->secondline != ''):echo $address->secondline."<br/>"; endif; ?>			
			 <?php echo $address->city; ?><br/>
			<?php if($address->province != 'International'):?>
				  <?php echo $address->province; ?><br/>
			<?php endif;?>
			 <?php echo CountryUtility::$countries[$address->country]; ?><br/>			 
			 <div class="row-fluid prepend-top append-bottom">
	 		<?php echo CHtml::link('<i class="icon-pencil"></i> Edit', array('contact/editAddress'), array('class'=>'btn'));?>
	 		</div>
		 </div>
	<?php else:?>
	<?php echo CHtml::link('<i class="icon-plus-sign"></i> Enter a physical address', array('contact/editAddress'), array('class'=>'btn'));?>	
	 <?php endif;?>
	 </div>
	 
	 
	 <h4>Postal</h4>	 
	 <div class="row-fluid">
	 	 <?php if ($postal_address->firstline != ''):?>
		 <div class="ten columns">		
			 <?php echo $postal_address->firstline; ?><br/>
			 <?php if($postal_address->secondline != ''):echo $postal_address->secondline."<br/>"; endif; ?>
			 <?php if($postal_address->postalCode != ''):echo $postal_address->postalCode."<br/>"; endif; ?>			 
			 <?php echo $postal_address->city; ?><br/>
			 	<?php if($postal_address->province != 'International'):?>
				  <?php echo $postal_address->province; ?><br/>
			<?php endif;?>
			 <?php echo CountryUtility::$countries[$postal_address->country]; ?><br/>
			 <div class="row-fluid prepend-top">
	 		<?php echo CHtml::link('<i class="icon-pencil"></i> Edit', array('contact/editPostalAddress'), array('class'=>'btn'));?>
	 		</div>
			 
			 
		 </div>
		 <?php else:?>
		 <?php echo CHtml::link('<i class="icon-plus-sign"></i> Enter a postal address', array('contact/editPostalAddress'), array('class'=>'btn'));?>
		 <?php endif;?>		 
	 </div>	
	
 </div>