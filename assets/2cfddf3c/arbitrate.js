(function arbitrate()
{
	var aOpt = $("input.rb"),
	rb_btn = $(".ra-btn"),
	goToByScroll = function(element)
	{		
		el = $.browser.opera ? $("html"): $("html, body");
		el.animate({scrollTop : $(element).offset().top}, 'slow');		
	},
	initMessageBox = function(val)
	{
		var cont = $("div.fcp"), topic = cont.find(".help-block");		
		if(val == "forced_cancel"){
			topic.text("Cancellation message to other party");
		}
		else if(val == "mutual_cancel"){
			topic.text("Reason for cancellation");
		}
		else if(val == "varbitrate")
		{
			topic.text("Arbitration Message");
		}
		cont.show();
	},
	highlight = function(elem, val)
	{
		elem.siblings().removeClass("highlight");
		elem.addClass("highlight");
		initMessageBox(val);
	};
	
	rb_btn.click(function(){
		if(rb_btn.html() == '<i class="icon-hand-up icon-white"></i> Request Arbitration'){
		    $(".a-options").show();
			rb_btn.html("Hide Request Form");
			rb_btn.removeClass("btn-danger");
			goToByScroll(".a-options");
		}
		else
		{			
			$(".a-options,  .fcp").hide();
			rb_btn.html('<i class = "icon-hand-up icon-white"></i> Request Arbitration');
			rb_btn.addClass("btn-danger");
			console.log($(".ra-btn :selected"));
		}
	});
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent(), $(this).val());
	});
	
	
})();