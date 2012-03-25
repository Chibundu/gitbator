<?php		
	 $this->beginContent('/layouts/main');
	 
	 $app = Yii::app();
	 $params = $app->params;	 
	 
	 
	 $baseUrl = $app->request->baseUrl;
	 $profile_picture = Miscellaneous::getProfilePicture();	
	 
	 $infoBox = Miscellaneous::getLayoutInfoBox();
	 
	 $sp = $infoBox['sp'];	 
	 $v_count = $sp->getVerificationCount();
	 $portfolioSize = (($sp->portfolioSize * 100)/$params['maxPortfolioSize']);
	 $portfolioCount = count($sp->portfolio);
	 $id = $sp->normalizeSPId();
	 
	 $verification = $sp->verification;
	 
	 $isEmailVerified = $verification->email;
	 $isMobileVerified = $verification->phone;					
	 
	 $address = $sp->address; 
	 $country_code = $address->country;	 
	 $country = CountryUtility::$countries[$country_code];
	
	 $country_code = strtolower($country_code);
	 $city = $address->city;
	 
	 $tagline = $sp->tagline;
	 $businessName = $sp->businessName;
	 $accountType = $sp->accountType;
	 
	
	 $primaryEmail = $infoBox['tlEmail'];
	 
	 				 	
	 $teamMembers = $infoBox['tms'];

	 $teamMember = $infoBox['tm'];
	 
	 $uncompleted = $infoBox['uncompleted'];
	 $completeness = $infoBox['completeness'];
	  
	 $page_links = new Links($this->id);
	 $links = $page_links->getLinks();
	 $user = $app->user;
	 
	 $timeBox = Time::ConvertTo12HrFormat($sp->currentTime);
	 $time = $timeBox['time'];
	 $date = $timeBox['date'];
	 
	 
 ?>
 
 
  <div class="container-fluid">
      <div class="row-fluid prepend-top">
        <div class="span2">
        <ul class="thumbnails">
       		<li class = "span10">       		
      			<?php echo CHtml::link(CHtml::image(($teamMember->profile_picture != NULL)?Miscellaneous::getRelativeProfilePicturePath().$teamMember->profile_picture:$baseUrl."/css/img/profile_silhouette.png", 'Profile Picture'), array('/serviceproviders/profile/profilePic'), array('class'=>'thumbnail', 'rel'=>'tooltip', 'data-original-title'=>'Change Profile Picture')); ?>    		
       		</li>
       	</ul>  
       	  <?php if(count($uncompleted) > 0):?>
      	
          <div id = "uncompleted">
          	<ul>
          		<li><span class = "bold">Complete your profile</span></li>
          		<li>          			
          			<?php 
						$this->widget('zii.widgets.jui.CJuiProgressBar', array(
							'id'=>'profile_guage2',
							'value'=>$completeness,									
							'htmlOptions'=>array(
								'style'=>'width: 100%; height:15px; float:left;border: 1px solid #9cb42d;'
							),
						));
					?>
          		</li>
          		<li><?php echo $completeness?>% complete</li>
          		<?php foreach($uncompleted as $uc): ?>
          		<li><?php echo CHtml::link($uc[0], $uc[1]);?></li>
          		<?php endforeach;?>
          	</ul>
          </div>
          <?php endif;?>     	
          <div class="sidebar-nav">
        
          <?php $this->widget('SideMenu', array('links'=>$links)); ?>
          </div>
        </div><!--/span-->
        <div class="span7">
       <?php if(!$isEmailVerified):?>
		
        <?php $this->widget('ext.SimpleFlash', array(					
					'message'=>'
	 		<h3>'.((isset(Yii::app()->session['welcome']))? Yii::app()->session['welcome'] : 'Verify your E-mail') . '</h3>	 	 	
			 	<ul class = "prepend-top" style = "list-style: square;">
			 		<li>A link was sent to your email <b> '.$primaryEmail.' </b></li>
			 		<li>Click on the link to activate your Vcubator Service Provider account</li>
			 		<li>If you did not receive an email, click on the button below to resend it.</li>			 		
			 	<ul>				 		 		 	
			 	<p class = "prepend-top"><a href = "#" class = "btn">Resend Activation Link &raquo;</a></p>
	 	',
					'css'=>'alert-warning'
			));?>
		
		<?php endif;?>
			
		<div class = "row-fluid append-bottom">
			<div class = "span12" style = "border-bottom: 1px solid #efefef;">
				<div class = "row-fluid">
				<?php if($accountType == 'company'):?>
					<div class = "span2">
						
						<div class = "top_logo">											
							<?php echo CHtml::link(CHtml::image(($sp->pic!=null)?Miscellaneous::getRelativeLogoPath().$sp->pic : $baseUrl.'/css/img/logo_placeholder.png','Logo'),array('profile/logo'), array('rel'=>'tooltip', 'data-original-title'=>'Change Logo', 'data-placement'=>'right'));?>
						</div>
						
					</div>
					<div class = "span2">
					<?php if($businessName):?>
					<div><span class = "gold-font" style = "font-size: 1.1em;"><?php echo $businessName; ?></span></div>
					<?php endif;?>	
					<?php if($tagline):?>
					<div><span style = "font-size: 75%; font-style: italic;" class = "quiet" ><?php echo $tagline; ?></span></div>
					<?php endif;?>
					&nbsp;
					</div>
				<?php else:?>
					<div class = "span4">&nbsp;</div>
				<?php endif; ?>
					<div class = "span8 reduced-font-size" style = "padding-top: 40px;">									
						<div class = "right">	
						<span class = "gold-font"><?php echo CHtml::link($id,'#', array('rel'=>'tooltip', 'data-original-title'=>'My Vcubator ID', 'class'=>'gold-font', 'style'=>'text-decoration: none; ')) ?> </span>
						<span class = "separator"></span>
						<span ><?php echo (($city)? "$city, ": ""). ucwords(strtolower($country)); ?></span>									
						
						<span><img src="<?php echo $baseUrl.'/images/flags/'.$country_code.'.png'; ?>"></span><span class = "separator"></span>
																
							<span class = "clock">&nbsp;</span> <span id="clock" class = "gold-font bold"><?php echo $time;?></span><?php echo '  <b>'. $sp->formattedTimeZone. '</b>';?>
							<span class = "gold-font"><?php echo $date ?> </span>
						</div>
						
						
							
						
					</div>
				</div>
			</div>
		</div>
        <?php echo $content; ?>		
        </div><!--/span-->
        <div class = "span3">
       			<div class="span10 prepend-top">	
	<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="notice_panel prepend-top">
		<div class = "nt-head top-rounded">
		<h4>Verifications<span class="label default"><?php echo $sp->getVerificationCount(); ?></span></h4>
		</div>
		<div class = "notice_panel_content">
			<div class = "nt-item-row-first">
				<div class = "three-fifths left">
					<i class = "icon-envelope"></i>Email
				</div>
				<div  class = "two-fifths left">
				
				<i class = "<?php echo ($isEmailVerified)? "icon-ok-sign" : "icon-remove-sign"?>"></i><?php echo ($isEmailVerified)? "Verified": "Unverified"?>
				</div>
			</div>
			
			<div class = "nt-item-row">
				<div class = "three-fifths left">
				<i class = "phone"></i>Mobile
				</div>
				<div  class = "two-fifths left">
				<i class = "<?php echo ($isMobileVerified)? "icon-ok-sign" : "icon-remove-sign"?>"></i><?php echo ($isMobileVerified)? "Verified": "Unverified"?>
				</div>
			</div>
			<div class = "nt-item-row">
				<div class = "three-fifths left">
				<i class = "icon-user"></i>Identity
				</div>
				<div  class = "two-fifths left">
					<i class = "<?php
								if($verification->identity):
									echo 'icon-ok-sign';
								elseif($verification->isIdentityRequestSent):
									echo 'icon-repeat';
								else:
									echo 'icon-remove-sign';
								endif; 
								?>">
					</i><?php
								if($verification->identity):
									echo 'Verified';
								elseif($verification->isIdentityRequestSent):
									echo '<i>Pending</i>';
								else:
									echo 'Unverified';
								endif; 
								?>
				</div>
			</div>		
			
			
			
					
		</div>		
				
		</div>
		<?php $this->endWidget();?>
		
		
		<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="notice_panel prepend-top">
		<div class = "nt-head top-rounded">
		<h4>Team<span class="label  label-success"><?php echo count($teamMembers); ?></span></h4>
		</div>
		<div class = "notice_panel_content">
			<?php foreach ($teamMembers as $teamMember):?>
				<div class = "nt-item-row-first">
					<div class = "half left">
						<?php if($teamMember->isTeamLeader):?>
							Admin:
						<?php else: ?>
							Member:
						<?php endif;?>
					</div>
					<div  class = "half left">
						<?php echo $teamMember->firstname.' '. $teamMember->lastname; ?>
					</div>
			 </div>
			<?php endforeach;?>				
		</div>		
				
		</div>
		<?php $this->endWidget();?>
		
		
		
		<?php $this->beginWidget('zii.widgets.jui.CJuiDraggable', array(
   	 'options'=>array(
     	   'cursor'=>'move',
   		 ),    
	));
	?>
		<div class="notice_panel prepend-top">
		<div class = "nt-head top-rounded">
			<h4>Portfolio<span class="label <?php echo ($portfolioCount > 0)? 'label-success': 'label-default'?>"><?php echo $portfolioCount; ?></span></h4>
		</div>
		<div class = "notice_panel_content">	
			<div class = "nt-item-row-first" style="background-color: #fff;">
					<?php 
								$this->widget('zii.widgets.jui.CJuiProgressBar', array(
									'id'=>'progress',
									'value'=>$portfolioSize,									
									'htmlOptions'=>array(
													'style'=>'width: 95%; height:20px; float:left; border: 1px solid #9cb42d;'
													),
									));
								?>
			 </div>			
			<span style = "margin-left: 5px;">
				<?php echo $sp->portfolioSize; ?>MB of <?php echo $params['maxPortfolioSize']?>MB
			</span>			 
		</div>		
				
		</div>
		<?php $this->endWidget();?>
		
	</div>
        </div><!-- span -->
      </div><!--/row-->
  </div>

<?php

$time = Time::getTimeComponents($sp->currentTime);
$hr = $time['hr'];
$min = $time['min'];
$sec = $time['sec'];
$mer = $time['mer'];

$app->clientScript->registerScript('clock','
	var min = '.$min.';
	var hr = '.$hr.';
	var mer = "'.$mer.'";
	var sec = '.$sec.';
	var clock = $("#clock");
	var updateTime = function()
	{
		if(++sec >= 60)
		{
			sec = 0;
			if(++min >= 60){		
				min = "00";
		 		if(++hr > 12)
		 		{
		 			hr = hr - 12;
		 			mer = (mer == "AM")? "PM" : "AM";
		 		}		 
			}
			if(min>0 && min< 10)
			{
				min = "0"+min;
			}
			if(clock.length)
			{
				clock.html(hr+":"+min+" "+mer);
			}
		}
						
	}

	setInterval(function()
	{
		updateTime();
	}, 1000);
	
', CClientScript::POS_END);?>


 
 <?php $this->endContent(); ?>

<?php 
	if(isset(Yii::app()->session['welcome']))
		unset(Yii::app()->session['welcome']);
?>

