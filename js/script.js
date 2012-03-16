/* Author: 

*/
$(document).ready(function(){
	var gallery = $("#featured");
	if(gallery.length)
	{
		gallery.orbit({
		     animation: 'fade',                  // fade, horizontal-slide, vertical-slide, horizontal-push
		     animationSpeed: 800,                // how fast animtions are
		     timer: true, 			 // true or false to have the timer
		     advanceSpeed: 4000, 		 // if timer is enabled, time between transitions 
		     pauseOnHover: false, 		 // if you hover pauses the slider
		     startClockOnMouseOut: false, 	 // if clock should start on MouseOut
		     startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
		     directionalNav: true, 		 // manual advancing directional navs
		     captions: true, 			 // do you want captions?
		     captionAnimation: 'fade', 		 // fade, slideOpen, none
		     captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
		     bullets: false,			 // true or false to activate the bullet navigation
		     bulletThumbs: false,		 // thumbnails for the bullets
		     bulletThumbLocation: '',		 // location from this file where thumbs will be
		     afterSlideChange: function(){}, 	 // empty function 
		     fluid: true                         // or set a aspect ratio for content slides (ex: '4x3') 
		});
	}
	
	
	var intro_video_link = $("#ivl");
	if(intro_video_link.length)
	{
		intro_video_link.click(function() {
			$.fancybox({
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none',
				'title'			: this.title,				
				'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
				'type'			: 'swf',
				'swf'			: {
				'wmode'			: 'transparent',
				'allowfullscreen'	: 'true'
				}
			});

		return false;

		
		});
	}

	
	var intro_modal = $('#fillUpProfile');
	if(intro_modal.length)
	{		
		intro_modal.reveal({
			 animation: 'fadeAndPop', //fade, fadeAndPop, none
		     animationspeed: 300, //how fast animtions are
		     closeOnBackgroundClick: true, //if you click background will modal close?
		     dismissModalClass: 'close'
		});		
	}	

});

var validateServices = function()
						{	
							var selected_services = $("input:checked");
							var selected_customservices = $('.other_service');
							var ss_length = selected_services.length;							
							
							if(ss_length > 0 && ss_length <= 5)
							{								
								if(ss_length + selected_customservices.length <= 5){									
									return true;
								}
								else
								{	
									selected_customservices.each(function(){
										if($(this).val()!= '')
										{
											alert("You cannot select more than 5 services!");
											return false;
										}
									});
										
									return true;
								}
							}							
							else if(ss_length > 5)
							{
								alert('You cannot select more than 5 services!');
								return false;
							}							
							else
							{
								for(var i = 0; i < selected_customservices.length; i++)
								{
									if($(selected_customservices[i]).val() != '')
									{
										return true;
									}
								}										
								alert('You must select or enter a service to be a service provider!');
								return false;							
							}
							return false;
						};
						
var submitProfilePic =  function submitProfilePic()
							{
								$(this).ajaxSubmit(function(r){						
									$("#profile_pic_container").html(r);						
								});
								return false;
							};