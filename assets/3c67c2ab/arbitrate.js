(function arbitrate()
{
	var aOpt = $("input.rb"),
	initMessageBox = function()
	{
		var cont = $("div.fcp");
		cont.show();
	},
	highlight = function(elem)
	{
		elem.siblings().removeClass("highlight");
		elem.addClass("highlight");
		initMessageBox();
	};
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent());
	});
	
})();