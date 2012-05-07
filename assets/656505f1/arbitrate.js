(function arbitrate()
{
	var aOpt = $("input.rb"),
	highlight = function(elem)
	{
		elem.addClass("highlight");
		console.log(elem.siblings());
	};
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent());
	});
	
})();