<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = Yii::app()->baseUrl; 
 	$cs->registerCoreScript("jquery");
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> 
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
 <meta charset="utf-8"> 

  <title>The Vcubator</title>
  <meta name="description" content="Virtual Business Incubation">
  <meta name="author" content="Mbagwu Chibundu">
  
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  
  <?php $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');?> 
  <?php $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');?>
  <?php $cs->registerCssFile($baseUrl.'/css/custom.css');?> 
   
      
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
   <?php $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js', CClientScript::POS_END); ?> 
</head>

<body>
	 <div class="container">
	 <header>
      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="row">
        <div class = "offset9 span3">
        	<div class = "right">
        	<?php $this->widget('ext.components.language.XLangMenu', array(
							'encodeLabel'=>false,
			    			'hideActive'=>false,
							'items'=>array(
								'en'=>XHtml::imageLabel('flags/us.png','English',true),    				
								'es'=>XHtml::imageLabel('flags/es.png','Espanol',true),
			    				'zu'=>XHtml::imageLabel('flags/za.png','Zulu',true),   			
							),
			)); ?>
			</div>
        </div>
      </div>

      <!-- Example row of columns -->
      <div class="row prepend-top">
       	<div class = "span3">
       		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          	</a>
       		<?php echo CHtml::link(CHtml::image($baseUrl.'/css/img/logo.png'), array('site/index'), array('class'=>'brand'));?>       		
       	</div>
       	<div class = "span9">
	        <nav class="nav-collapse right">
		     	<?php $this->widget('zii.widgets.CMenu',array(
		     	'htmlOptions'=>array(				
						'class'=>'nav',				
					),	
				'items'=>array(
					array('label'=>Yii::t('general', 'Home'), 'url'=>array('site/index')),
					array('label'=>Yii::t('general', 'How it works'), 'url'=>array('site/page', 'view'=>'how_it_works')),				
					array('label'=>Yii::t('general', 'Log in'), 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest, array('class'=>'last')),
					array('label'=>Yii::t('general', 'Log out'), 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest, array('class'=>'last'))
					),
				)); ?>	            		
	        </nav>
        </div>
      </div>
     </header>
   </div>


   

	 <div class="container prepend-top blue_bg">	
	
		<div class = "row prepend-top">			 
		 <div class="span5">	
		 	<div style = "padding-left: 20px;"> 
		 		<h1><?php echo Yii::t('general', 'Instant access to world class Virtual Business Incubation...');?></h1>
				<div class = "splash">					
					<ul>
						<li><?php echo Yii::t('general', 'Get your business off the ground')?></li>
						<li><?php echo Yii::t('general','Guarantee the success of your business');?></li>
						<li><?php echo Yii::t('general','Gain access to funding');?></li>
						<li><?php echo Yii::t('general','Get quality services at discounted rates');?></li>
						<li><?php echo Yii::t('general','Enjoy high quality mentoring');?></li>									
					</ul>
					   <?php echo CHtml::link(Yii::t('general', 'Register Now')." &raquo;", array('site/register'), array('class'=>'nice large gold button round'));?>
					  <div class = "row">
     <div class = "span6">
     	<div id = "intro-video" class="modal hide fade">  		
  			<div id = "video_container" class="modal-body">
  			 <iframe width="530" height="315" src="http://www.youtube.com/embed/xLzMqC5xwAI?rel=0" frameborder="0" allowfullscreen></iframe>
 			</div>  						
		 </div>
     </div>
     </div>
					<div id = "intro_video" class = "span3 greenlinks" style = "margin-top: 5px;">							
					<?php echo CHtml::link('<i class = "icon-facetime-video"></i> '.Yii::t('general', 'Introduction to the vcubator'), '#intro-video', array('class'=>'video', 'data-toggle'=>'modal', 'title'=>'Introduction to the Vcubator')); ?>
					</div>              
					            	
			   </div>
			 </div>			   			   
	    	</div>
	  		
	    	<div class="span6 offset1">
	    		<div style = "padding-right: 20px;">
			    	<div class="carousel">
		  			<!-- Carousel items -->
		 			 <div class="carousel-inner">
		  				 <div class="item active">
	                		<?php echo CHtml::image($baseUrl.'/images/splash/splash-1.png'); ?>	                		
	              		</div>
	              		 <div class="item">
	                		<?php echo CHtml::image($baseUrl.'/images/splash/splash-2.png'); ?>                	
	              		</div>
	              		 <div class="item">              		 	
	                		<?php echo CHtml::image($baseUrl.'/images/splash/splash-3.png'); ?>                		
	              		</div>
		 			 </div>
		 			 <!-- Carousel nav -->
					  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		  			  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
					</div>
				</div>
	    	</div>	
	    				
		</div>
	</div>

     <div class = "container">    
     <div class="row prepend-top">
     	<div class = "span12">
     		<?php echo $content; ?>     		
     	</div> 
     </div>

     </div>  
	
	
	  
		
	 
     
	<div class = "container greenlinks">
	
      <footer>
        <p>&copy;<?php echo date('Y');?> TheVcubator.&nbsp;&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Terms and Conditions')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','Contact Us'), array('site/contact')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;<?php echo CHtml::link(Yii::t('general','About Us'), array('site/page', 'view'=>'about')); ?>&nbsp;&nbsp;.&nbsp;&nbsp;</p>
      </footer>
    </div>


  



 


  <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
  <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
  <![endif]-->
  
  <!-- scripts concatenated and minified via ant build script--> 
  <script defer src="<?php echo $baseUrl.'/js/script.js'?>"></script> 
  <script type="text/javascript" src="<?php echo $baseUrl?>/js/jquery.fitvids.js"></script>
	  
  <!-- end scripts-->	
  
</body>
</html>
<?php 
Yii::app()->clientScript->registerScript('js-carousel-slider','
$(".carousel").carousel();
$("#video_container").fitVids();
', CClientScript::POS_READY);
?>