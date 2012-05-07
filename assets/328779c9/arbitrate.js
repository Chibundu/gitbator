(function arbitrate()
{
	var aOpt = $("input.rb"),
	highlight = function(elem)
	{
		console.log(elem);
	};
	
	aOpt.click(function(){
		highlight($(this).parent().parent().parent().parent().addClass("highlight"));
	});
	
})();