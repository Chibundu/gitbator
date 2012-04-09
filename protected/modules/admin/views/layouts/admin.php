<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = Yii::app()->request->baseUrl;
	 $page_links = new Links($this->id);
	 $links = $page_links->getLinks($this->module->id);
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
  <?php $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.css');?>
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
			<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'SP Management', 'url'=>array('/admin/default/index')),
						array('label'=>'Entrepeneur Management', 'url'=>array('/admin/ent/index')),
						array('label'=>'Access Control', 'url'=>array('/admin/accessControl/index')),
						array('label'=>'Reports', 'url'=>array('/admin/reports')),						
					),	
					'htmlOptions'=>array(				
						'class'=>'nav',				
					),	
					'id'=>'main-links'										
				)); ?>
			
				
			
			</div>
			</div>
		</div>
	</div>
	</div>
    </header>   
	


	
	 <div class = "container-fluid" style = "margin-top: 40px;">
	 	<div class = "row-fluid prepend-top">
	 		<div class = "span3">
	 			 <div class="sidebar-nav">
          			<?php $this->widget('ext.SideMenu', array('links'=>$links)); ?>
          		</div> 
	 		</div>
	 		<div class = "span9">
	 			<?php echo $content; ?>    	
	 		</div>
	 	</div>	    		
    </div>    
 
   
 <div class="container-fluid prepend-top">
 <hr>
   <footer >
	<center>&copy;<?php echo date('Y');?> TheVcubator.&nbsp;&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Terms and Conditions')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Contact Us'), array('/site/contact')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','About Us'), array('/site/page', 'view'=>'about')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;</center>
    </footer>
   </div>
 </div>
 


  <!-- JavaScript at the bottom for fast page loading -->

  


   <!-- scripts concatenated and minified via ant build script-->   
  <script defer src="<?php echo $baseUrl.'/js/bootstrap.min.js'?>"></script>  
   <script defer src="<?php echo $baseUrl.'/js/script.js'?>"></script>  
  <!-- end scripts-->	
 


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
</body>
</html>



