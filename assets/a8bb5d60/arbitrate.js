(function arbitrate()
{
	var aOpt = $("input.rb"),
	highlight = function(elem)
	{
		console.log(elem.parent(". rtb"));
	};
	
	aOpt.click(function(){
		highlight($(this));
	});
	
})();