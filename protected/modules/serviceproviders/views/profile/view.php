<?php
$baseUrl = Yii::app()->request->baseURL; 
Yii::app()->clientScript->registerCssFile($baseUrl.'/assets/js/css/ui-lightness/jquery-ui-1.8.16.custom.css');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery-1.3.2.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery-ui-1.7.2.custom.js');
Yii::app()->clientScript->registerScriptFile($baseUrl.'/assets/js/jquery.jcoverflip.js');
?>
<div id="content" class="span-24">

<div class="span-5">
	<div id="side_bar">
		<div class = "subtitle">Profile</div>
			<div id = "section">		
				<div style="margin-left: 30px; padding-top: 2px; color: #ccc;">Profile picture</div>
				<div id="picture_bar"></div>
				<div class="decorated_link"><a href="#" >Edit</a></div>
			</div>
			<div>
				<ul>
					<li class="focus"><a href="#" >Overview</a></li>
					<li><a href="#">Contact Info</a></li>
					<li><a href="#">Team</a></li>
					<li><a href="#">Portfolio</a></li>
					<li><a href="#">Qualifications</a></li>
					<li><a href="#">Skills</a></li>
					<li><a href="#">Verifications</a></li>
					<li><a href="#">Email</a></li>
					<li><a href="#">View Public Profile</a></li>
				</ul>
			</div>
			<div id = "section">		
				<div style="margin-left: 30px; padding-top: 2px; color: #ccc;">Company Logo</div>
				<div id="logo_bar"></div>
				<div class="decorated_link"><a href="#" >Edit</a></div>
		   </div>
	</div>
</div>

<div class="span-14" id = "top-info" >
	<div id="top_logo"></div>
	<div style="float: left; width: 420px;">
		<div style="color: #D0A113;  font-weight: bold;">Company Name</div>
		<div style="color: #ccc; font-style: italic; font-size: 12px;">Tagline, Tagline, Tagline</div>
		<div style="width: 100px; float: left; margin: 2px; padding: 2px; font-size: 11px; color: #0086d6">Profile Id: VPS-385 </div>
		<div style="width: 150px; float: left; margin: 2px; padding: 2px; font-size: 11px; color: #0086d6">
		Johannesburg, South Africa 
		</div>	
		<div style="float: left;"><img src="<?php echo $baseUrl; ?>/images/South-Africa-Flag-48.png"></div>	
		<div style="width: 100px; float: left; margin: 2px; padding: 2px; font-size: 11px; color: #0086d6">Local Time: 2:40pm </div>
	</div>	
</div>
<div class="span-14 prepend-top" style="padding-bottom: 10px;">
	<h1>Overview</h1>
	<div class="span-4 solid append-bottom">
	Minimum Hourly Rate
	</div>
	<div class="span-9 append-bottom">
	$10
	</div>
	
	<div class="span-4 solid append-bottom">
	Expertise
	</div>
	<div class="span-9 append-bottom">
	Design and Multimedia, Web design, etc
	</div>
	
	<div class="span-4 solid append-bottom">
	Skills
	</div>
	<div class="span-9 append-bottom">
	Dreamweaver, PHP, Photoshop, 3D designs and extensive knowledge of 3D max
	extensive design and conceptualization
	</div>
	
	<div class="span-4 solid append-bottom" >
	Service Description
	</div>
	<div class="span-9 append-bottom">
	-
	</div>
	
	<div class="span-4 solid append-bottom" >
	Keywords
	</div>
	<div class="span-9 append-bottom">
	3D designer, Photoshop, CorelDraw X5
	</div>			
	<div class="span-4 solid append-bottom" >
	Portfolio
	</div> 
	<div class="span-9 append-bottom">
	-
	</div>	
	<?php $this->renderPartial('_portfolio')?>
		
	
</div>
<div class="span-5 last prepend-top" style="min-height: 100px; background-color: #f7f7f7;">
<div class="span-4 solid" style="padding-top: 5px;">Verifications<span class="note_highlight">2</span></div>
<div class="span-5">
	<div class="note_left">Email</div>
	<div class="note_right good">Verified</div>
</div>
<div class="span-5">
	<div class="note_left">Mobile</div>
	<div class="note_right good">Verified</div>
</div>
<div class="span-5">
	<div class="note_left">Credentials</div>
	<div class="note_right bad">Unverified</div>
</div>
</div>	

<div class="span-5 last prepend-top" style="min-height: 100px; background-color: #f7f7f7;">
<div class="span-5 solid" style="padding-top: 5px;">
<div style="float: left;">Team<span class="note_highlight">3</span></div>
<div style="float: right; margin-right: 2px; "><a href="#" style="width: 50px; height: 22px; display: block; text-decoration: none; padding-left: 10px; color: #fff; background: url(<?php echo $baseUrl ?>/css/img/dec_link_bg.png) no-repeat;">Edit</a></div>
</div>

<div class="span-5">
	<div class="note_left">Administrator</div>
	<div class="note_right">Kofi Oroh</div>
</div>
<div class="span-5">
	<div class="note_left">Members</div>
	<div class="note_right">Onyeka Osuala<br> Ben Onuoha</div>
</div>

</div>	




</div>