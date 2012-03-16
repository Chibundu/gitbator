<?php 
	$baseUrl = Yii::app()->request->baseURL;
	$profile_picture = Miscellaneous::getProfilePicture();
	$businessName = Miscellaneous::getServiceProvider()->displayName;
 ?>
<div class = "section">		
<div class="center">
				<div class="center bold">Profile Picture</div>
				<div class="picture_bar <?php if($profile_picture!=''&& $profile_picture!=null):?> not_empty<?php endif;?>">
				<?php if($profile_picture!=''&& $profile_picture!=null):echo CHtml::image(Miscellaneous::getRelativeProfilePicturePath().$profile_picture); endif; ?>
				</div>
				<div class="center"><?php echo CHtml::link('Edit',array('profile/ProfilePic'),array('class'=>'edit_link prepend-top'))?></div>
				</div>
			</div>
			<div class = "section">
				<ul>
					<li><?php echo CHtml::link('Overview', array('profile/'))?></li>
					<li><?php echo CHtml::link('Contact Info', array('profile/contact'))?></li>
					<li><?php echo CHtml::link('Team', array('team/'))?></li>
					<li><?php echo CHtml::link('Portfolio', array('portfolios/'))?></li>
					<li><?php echo CHtml::link('Qualifications', array('qualification/'))?></li>
					<li><?php echo CHtml::link('Services', array('services/'))?></li>
					<li><?php echo CHtml::link('Verifications', array('verifications/'))?></li>
					<li><?php echo CHtml::link('Email', array('email/'))?></li>
					<li><?php echo CHtml::link('Public Profile', array("public/index", 'displayName'=>$businessName))?></li>
				</ul>
			</div>
			<div class = "section last">		
				<div class="center bold">Company Logo</div>
				<?php
				$pic = Miscellaneous::getLogo();				
				$logoPath = Miscellaneous::getRelativeLogoPath();
				
				if($pic == null || $pic==''):?>
				<div id="logo_bar"></div>
				<?php 
				else:
				?>
				<div class="center"><?php echo CHtml::image($logoPath.$pic); ?></div>
				<?php 
				endif; 
				?>
				<div class="center"><?php echo CHtml::link('Edit',array('profile/logo'),array('class'=>'edit_link prepend-top'))?></div>
		 	</div>