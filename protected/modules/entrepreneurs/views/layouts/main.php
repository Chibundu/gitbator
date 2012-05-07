<?php 
	$cs = Yii::app()->clientScript;
	$cs->registerCoreScript("jquery");
	$baseUrl = Yii::app()->baseUrl;
	$entrepreneur = Miscellaneous::getEntrepreneur();
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
						array('label'=>'Dashboard', 'url'=>array('/entrepreneurs')),
						array('label'=>'Packages', 'url'=>array('/entrepreneurs/packages/')),
						array('label'=>'Jobs', 'url'=>array('/entrepreneurs/jobs/')),
						array('label'=>'Classroom', 'url'=>array('/entrepreneurs/classroom')),
						array('label'=>'Mentor', 'url'=>array('/entrepreneurs/mentor')),
						array('label'=>'Workcenter', 'url'=>array('/entrepreneurs/workcenter')),
						array('label'=>'Payment', 'url'=>array('/entrepreneurs/payment')),						
						array('label'=>'Profile', 'url'=>array('/entrepreneurs/profile/')),				
						array('label'=>'Messages', 'url'=>array('/entrepreneurs/message')),
					),	
					'htmlOptions'=>array(				
						'class'=>'nav',				
					),	
					'id'=>'et-main-links',	
					'controllerMapping'=>Links::$et_main_links,					
				)); ?>
			
				
				<ul class="nav pull-right" data-dropdown="dropdown">
					<li class="dropdown">
					<?php echo CHtml::link($entrepreneur->firstname." ".$entrepreneur->lastname.' <b class="caret"></b>', '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown')); ?>
					
						<ul class="dropdown-menu">		
							<li><?php echo CHtml::link('Log Out',array('/site/logout'))?></li>
						</ul>
					</li>					
				</ul>
			
			
			</div>
			</div>
		</div>
	</div>		
	  
    
     <div id="secondary-bar" class = "row-fluid hidden-phone">    				
			<div class = "span12">
			<span class = "right" style = "padding: 4px;">
			<?php echo CHtml::image("$baseUrl/images/icon-purse.png",'V-Purse', array('style'=>'position: relative; top: -2px;')).' 
		 	<span style = "font-size: 1.5em; font-weight: bold;">R</span><span style = "font-size: 1.4em;">'.number_format($entrepreneur->purse, 2). 
		 	'</span>'; ?>
		 	</span>
			</div>			
	</div>
	<div class = "row visible-phone">    				
			<div class = "right">			
			<?php 
				echo CHtml::image("$baseUrl/images/purse_mobile.png",'V-Purse').
				'<span style = "font-size: 1.0em; font-weight: bold;">R</span><span style = "font-size: 1.0em;">'.number_format($entrepreneur->purse, 2). 
		 		'</span>';
			 ?>		 	
			</div>			
	</div>
	<div class = "row visible-phone">
	<hr>
	</div>
	</div>
    </header>   
	



	
	 <div class = "container">	
    	<?php echo $content; ?>    
    </div>

   
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

<?php $cs->registerCss('progress-bar-style', '.ui-widget-header{background: url('.$baseUrl.'/css/img/green_bg.png);}');?>



