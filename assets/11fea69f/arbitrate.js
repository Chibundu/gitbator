(function arbitrate()
{
	var aOpt = $("input.rb"),
	highlight = function(elem)
	{
		elem.siblings().removeClass("highlight");
		elem.addClass("highlight");		
	};
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent());
	});
	
})();