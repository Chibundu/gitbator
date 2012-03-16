<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = Yii::app()->baseUrl; 
 	$cs->registerCoreScript("jquery");
 	$teammember = Miscellaneous::getTeamMember(); 	
 	$sp = Miscellaneous::getServiceProvider(); 	
 	
 	$completeness = Miscellaneous::getProfileCompleteness();
 	
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head> 
  <meta charset="utf-8"> 

  <title>The Vcubator</title>
  <meta name="description" content="Virtual Business Incubation">
  <meta name="author" content="Mbagwu Chibundu">
  
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1"> 
   <!--<script>window.jQuery || document.write('<script src="<?php //echo $baseUrl; ?>/js/libs/jquery-1.6.2.min.js"><\/script>');</script>  
  --><!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script-->  
    
  <?php $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');?>
  <?php $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');?>
  <?php $cs->registerCssFile($baseUrl.'/css/custom.css');?>    
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
   <?php $cs->registerScriptFile($baseUrl.'/js/modernizr.foundation.js', CClientScript::POS_HEAD); ?>
 
</head>

<body>

   <header>   		
	<div id="header">
	<div class = "navbar navbar-fixed-top">
		<div class = "navbar-inner">
			<div class = "container-fluid">
			<a class = "btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class = "icon-bar"></span>
			<span class = "icon-bar"></span>
			<span class = "icon-bar"></span>
			</a>
			 <?php echo CHtml::link(CHtml::image($baseUrl.'/images/white-logo.png','Logo'),array('/site'), array('class'=>'brand'))?>
			<div class = "nav-collapse">
			
			
			 	<?php $this->widget('ext.MappedMenu',array(
					'items'=>array(
						array('label'=>'Dashboard', 'url'=>array('/serviceproviders')),
						array('label'=>'Packages', 'url'=>array('/serviceproviders/packages/')),
						array('label'=>'Jobs', 'url'=>array('/serviceproviders/jobs/')),
						array('label'=>'Payment', 'url'=>array('site/contact')),
						array('label'=>'Workcenter', 'url'=>array('site/login')),
						
						array('label'=>'Profile', 'url'=>array('/serviceproviders/profile/')),				
						array('label'=>'Messages', 'url'=>array('site/login')),
					),	
					'htmlOptions'=>array(				
						'class'=>'nav',				
					),	
					'id'=>'main-links',	
					'controllerMapping'=>Links::$sp_main_links,					
				)); ?>
			
				
				<ul class="nav pull-right" data-dropdown="dropdown">
					<li class="dropdown">
					<?php $fullName = $teammember->fullName;echo CHtml::link($fullName.'<b class="caret"></b>', '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown')); ?>
					
						<ul class="dropdown-menu">	
							<li>
							<?php 	$profile_thumbnail = Miscellaneous::getProfilePicture(); ?>							 	
								 	 <?php 	 	
								 	 	if($profile_thumbnail =='' || $profile_thumbnail == null):
								 	 ?>
								 	 <?php echo CHtml::image($baseUrl."/images/default_profile_small.png",'', array('style'=>'border: 1px dotted #efefef;')); ?>
								 	 <?php
								 	 	else:
											echo CHtml::image(Miscellaneous::getRelativeProfileThumbnailPath().$profile_thumbnail);		 	 		
								 	 	endif;
								 	 ?>
							</li>		
							<li class = "divider"></li>								
							<li><?php echo CHtml::link('My Profile',array('/serviceproviders/profile/'))?></li>				
							<li><?php echo CHtml::link('My PortFolio',array('/serviceproviders/portfolios/'))?></li>
							<li><?php echo CHtml::link('My Settings',array('/serviceproviders/settings/overview'))?></li>	
							<li><?php echo CHtml::link('Log Out',array('/site/logout'))?></li>
						</ul>
					</li>					
				</ul>
			
			
			</div>
			</div>
		</div>
	</div>		
	  
    
     <div id="secondary-bar">     
     	<div class="container-fluid">
	     	<div class = "row-fluid">
	     		<div class = "span2">
					<div id="menu_tray">
						<ul>
							<li class="menu_focus"><?php echo CHtml::link('',array('default/'),array('data-original-title'=>"Dashboard", 'rel'=>'tooltip', 'data-placement'=>'bottom', 'id'=>'home',"class"=>"home"))?></li>
							<li><?php echo CHtml::link('',array('/serviceproviders/settings/overview'), array('id'=>'settings', 'class'=>'settings', 'data-placement'=>'bottom', 'rel'=>'tooltip', 'data-original-title'=>'Settings'))?></li>
							<li><?php echo CHtml::link('',array('profile/'),array('data-original-title'=>"Profile", 'rel'=>'tooltip', 'data-placement'=>'bottom', 'id'=>'profile',"class"=>"profile"))?></li>
							<li><a href="#" rel = "tooltip" data-original-title="Messages" data-placement="bottom" class="mail" id = "mail"></a></li>
					
						</ul>		
					</div>
				</div>
				<div class = "span2" >					
					<div class = "row-fluid">
					<?php 
						$this->widget('zii.widgets.jui.CJuiProgressBar', array(
							'id'=>'profile_guage',
							'value'=>$completeness,									
							'htmlOptions'=>array(
								'style'=>'width: 100%; height:12px; float:left; border: 1px solid #9cb42d; margin-top: 3px;foreground: blue;'
							),
						));
					?>
					</div>
					<div class = "row-fluid quiet">
					 <span style = "font-size: 70%">profile completeness <?php echo $completeness; ?>%</span>
					</div>
				</div>	
							
			
				
			</div>		
			
		</div>
	</div>
	
	</div>
    </header>   
	


 
 	<?php 	
 		if($sp->isActivated && !isset(Yii::app()->session['prompted'])):
 			Yii::app()->session['prompted'] = "yes";
 	?>
 	
 	<div id="fillUpProfile" class="reveal-modal">
		<h2>Congratulations! Your account is now active</h2>
		<p>	Now, let's create a compelling profile that will get you high quality clients and jobs on the Vcubator.
			This will ensure yo get the following benefits.	</p>
		<ul class="itemize">
			<li>You earn more because you begin getting job offers within a few hours of completion</li>
			<li>You show up fast in search results</li>
			<li>Your profile becomes SEO friendly</li>
			<li>Your credibility is boosted</li>			
		</ul>	
		
		 <div class="modal-footer">
   <?php echo CHtml::link('Complete your profile now &raquo', array('/serviceproviders/profile/address'), array('class'=>'gold nice round button'));?>
   
  </div>
			
		<a class="close-reveal-modal close">&#215;</a>
	</div>
	
	<?php endif; ?>
	
	 	
    <?php echo $content; ?>    

   
 <div class="container goldlinks prepend-top">
   <footer >
	<center>&copy;<?php echo date('Y');?> TheVcubator.&nbsp;&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Terms and Conditions')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Contact Us'), array('/site/contact')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','About Us'), array('/site/page', 'view'=>'about')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;</center>
    </footer>
   </div>

 


  <!-- JavaScript at the bottom for fast page loading -->

  


   <!-- scripts concatenated and minified via ant build script-->   
   <?php $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END);?>
   <?php $cs->registerScriptFile($baseUrl.'/js/plugins.js', CClientScript::POS_END);?>
   <?php $cs->registerScriptFile($baseUrl.'/js/script.js', CClientScript::POS_END);?>
  
   
  <!-- end scripts-->	
 


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>





