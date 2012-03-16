<h2 class = "prepend-top">Profile Overview</h2>



<?php $this->widget('BootAlert'); ?>


<div class="row-fluid prepend-top">
		<div class="span4 bold bold">		
			Account Type
		</div>		
		<div class="span7"><?php echo $profile_overview['account_type']?></div>
		<div class="span1"></div>	
</div>

<div class="row-fluid prepend-top ">
		<div class="span4 bold">		
			Subscription Package
		</div>		
		<div class="span7"><?php echo $profile_overview['subscription_package']?></div>
		<div class="span1"></div>	
</div>
<div class="row-fluid prepend-top" id="display_name">
		<div class="span4 bold">		
			Display Name
		</div>		
		<div class="span7"><?php echo ($profile_overview['display_name'] != '')?$profile_overview['display_name']:'-'; ?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editDisplayName'), array('update'=>'#display_name'), array('rel'=>'tooltip', 'data-original-title'=>'edit'));?></div>	
</div>
<?php if($profile_overview['account_type'] == 'company'):?>
<div class="row-fluid prepend-top "  id="company">
		<div class="span4 bold">		
		Business Name
		</div>		
		<div class="span7"><?php echo ($profile_overview['company']!='')?$profile_overview['company']:'-';?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editCompany'), array('update'=>'#company'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>	
</div>
<div class="row-fluid prepend-top"  id="tagline">
		<div class="span4 bold">		
		Tagline
		</div>		
		<div class="span7"><?php echo $profile_overview['tagline'];?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editTagline'), array('update'=>'#tagline'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>	
</div>
<?php endif; ?>
<div class="row-fluid prepend-top "  id="primaryContact">
		<div class="span4 bold">		
		Primary Contact
		</div>		
		<div class="span7"><?php echo $profile_overview['primary_contact'];?></div>
		<div class="span1"><?php echo CHtml::Link("<i class = \"icon-pencil\"></i>", array('/serviceproviders/team/update'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>	
</div>

<div class="row-fluid prepend-top"  id="services">
		<div class="span4 bold">		
		Services
		</div>		
		<div class="span7"><?php echo $profile_overview['services'];?></div>
		<div class="span1"><?php echo CHtml::link("<i class = \"icon-pencil\"></i>",array('/serviceproviders/services/update'), array('rel'=>'tooltip', 'data-original-title'=>'edit'))?></div>	
</div>
<div class="row-fluid prepend-top "  id="skills">
		<div class="span4 bold">		
		Skills
		</div>		
		<div class="span7"><?php echo $profile_overview['skills'];?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editSkills'), array('update'=>'#skills'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>
</div>
<div class="row-fluid prepend-top"  id="overview">
		<div class="span4 bold">		
		Overview
		</div>		
		<div class="span7"><?php echo $profile_overview['overview'];?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editOverview'), array('update'=>'#overview'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>	
</div>

<div class="row-fluid prepend-top "  id="keywords">
		<div class="span4 bold">		
		Keywords
		</div>		
		<div class="span7"><?php echo $profile_overview['keywords'];?></div>
		<div class="span1"><?php echo CHtml::ajaxLink("<i class = \"icon-pencil\"></i>", array('/serviceproviders/profile/editKeywords'), array('update'=>'#keywords'), array('rel'=>'tooltip', 'data-original-title'=>'edit')); ?></div>	
</div>
