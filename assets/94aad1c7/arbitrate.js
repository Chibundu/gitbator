(function arbitrate()
{
	var aOpt = $("input.rb"),
	initMessageBox = function(val)
	{
		var cont = $("div.fcp"), topic = cont.find(".help-block");
		console.log(topic);
		if(val == "forced_cancel"){
			topic.text("Cancellation message to other party");
		}
		else if(val == "mutual_cancel"){
			topic.text("Reason for cancellation");
		}
		else
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
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent(), $(this).val());
	});
	
})();