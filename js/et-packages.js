var package_utility = (function(){
	
	var small_spinner = new Spinner({
		  lines: 12,
		  length: 4,
		  width: 3,
		  radius: 6,
		  color: "#000",
		  speed: 2,
		  trail: 60,
		  shadow: false,
		  hwaccel: false,
		  className: "spinner",
	      zIndex: 2e9,
		  top: "auto",
		  left: "auto"
		  }),
	
		 large_spinner = new Spinner({
		  lines: 12,
		  length: 7,
		  width: 4,
		  radius: 10,
		  color: "#000",
		  speed: 2,
		  trail: 60,
		  shadow: false,
		  hwaccel: false,
		  className: "spinner",
	      zIndex: 2e9,
		  top: "auto",
		  left: "auto"
		  }), 
		 
		  
		adjustNextButtons = function()
		{
			if($(window).width() <= 480)
			{				
				$(".custom_pager").removeClass("right");
			}
		},		
		  
		showDefaultResults = function(){			
			
			var spinner = large_spinner;			
					
			$(".media-section").each(function(){
				
				var container = $(this).children("section");
				
				var id = $(this).children("input#category_id").val();
				
				var spinning = spinner.spin(this);		  		  
				
				$.ajax({			
					method : "post",
					cache : "false",
					url : (id) ? "/entrepreneurs/packages/ordinaryPackages?id="+id+"&page=1" : "/entrepreneurs/packages/featuredPackages?page=1",
					success: function(data)
					{	
						container.html(data);
				 		$(".package_title").popover();				 	
						spinning.stop();
					}
				});
			});
			
			$(".media-section").on("click", ".thumbnail", function(e){
	 			var href = $(this).find(".package_title").attr("href");
	 			window.location.href = href;
	 		});
		},
		
		showNextPage = function(){
			
			var spinner = small_spinner;
			
			$(".btn").click(function(e){				
		  		  
				e.preventDefault();
				var spinner_container = $(this).siblings(".spinner");
				
				var current_page_container = $(this).siblings(".current_page");
				var current_page = Number(current_page_container.text());
				var number_of_pages = $(this).siblings(".number_of_pages").text();
				
				var spinning = spinner.spin(spinner_container.get(0));			
				
				var next_page = 1;
						
				var parent_row = $(this).parent().parent().parent();		
				var category_id = parent_row.siblings("input#category_id").val();
				
				if(current_page > 1 && $(this).hasClass("prev"))
				{			
					next_page = --current_page;		
				}
				
				if(current_page <= number_of_pages && $(this).hasClass("next"))
				{
					if(current_page == number_of_pages)
					{
						next_page = number_of_pages;
					}
					else			
						next_page = ++current_page;
				}		
				
				
				$.ajax({			
					method : "post",
					cache : false,
					url : (category_id) ? "/entrepreneurs/packages/ordinaryPackages?id="+category_id+"&page="+next_page : "/entrepreneurs/packages/featuredPackages?page="+next_page,
					success: function(data)
					{	
						parent_row.siblings("section").html(data);		
						current_page_container.text(next_page);	
						$(".package_title").popover();
						spinning.stop();
					}
				});	
					
				
			});
		},	
		
		goToByScroll = function(element)
		{		
			el = $.browser.opera ? $("html"): $("html, body");
			el.animate({scrollTop : ($(element).offset().top - 73)}, 'slow');		
		},
		
		scrollToSection = function()
		{
			$(".sidelink a").click(function(e){
				e.preventDefault();
				var target = $(this).attr("href");
				$(".subnav .nav li.active").removeClass("active");
				$(this).parent("li").addClass("active");
				goToByScroll($(target));
			});
		},
		search = {
					search_box : $('#searchBox'),
					default_context_div : $(".default_context"),
					no_res_div : $(".no-results-found"),
					container : $("#search_context"),
					prompt : function()	{								
								this.search_box.focusout(function(e){
									if($(this).val() == "")
									{
										$(this).val("Website, Book keeping, Logo");
										$(this).addClass("faded");
									}		
								});
								
								$(".faded").focus(function(e){
									if($(this).val() == "Website, Book keeping, Logo")
									{
										$(this).val("");
									}
									$(this).removeClass("faded");
								});
							},
					go : function()
					{
						search = this;		
						
						var prepareSearchContext = function()
						{
							search.default_context_div.hide();
							search.no_res_div.hide();
							search.container.show();
							spinning = large_spinner.spin(document.getElementById("search_context"));
						};
						var showDefaultContext = function()
						{
							search.container.hide();
							search.default_context_div.show();							
						};
						var getSearchResults = function(e){
							
							e.preventDefault();
							
							if(($.trim(search.search_box.val()) != "") && (!search.search_box.hasClass("faded")))
							{
								prepareSearchContext();
								
								if(!search.fetchResults("",""))
								{									
									showDefaultContext();
									search.no_res_div.show();
								}
							}
							else
							{
								showDefaultContext();
							}
						};
						
						search.prompt();
						$(".btn-primary").click(function(e){getSearchResults(e);});
						$("form#searchForm").submit(function(e){getSearchResults(e);});
						$("#search_context").delegate("ul.thumbnails li div.thumbnail img", "click", function(e){							
							window.location.href = $(this).siblings().children("h5.ellipsis").children("a").attr("href");
						});
						
						//paginate
						(function()
								{
									$("#search_context").delegate(".pagination li a", "click", function(e){
										e.preventDefault();
										spinning = large_spinner.spin(document.getElementById("search_context"));
										search.fetchResults($(this).attr("href"));
										spinning.stop();
									});
								})();
						
						//sort
						(function()
								{
									$("#search_context").delegate(".sortBy", "click", function(e){
										e.preventDefault();										
										search.container.html("");
										spinning = large_spinner.spin(document.getElementById("search_context"));									
										search.fetchResults("", $(this).html());										
										spinning.stop();
									});
								})();
						return true;
					},
					
					fetchResults : function(url, sort)
					{			
						var search_box = this.search_box;
						var search_string = search_box.val();
						
						var action = (url == "")?search_box.parent().attr("action"):url;
						var container = this.container;
						
						var response = true;
						if(sort == "")
						{
							sort = "Price";
						}
						$.ajax({
							type : 'GET',
							data : (url == "")?{text:search_string, sort:sort}:{sort:sort},
							url : action,
							success : function(data)
							{
								if(data == false)
								{									
									response = false;
								}								
								container.html(data);								
							}
						});					
						
						return response;
					}			
					
				
			
		};
		
		return {
				
				adjustNextButtons : adjustNextButtons,
				showDefaultResults : showDefaultResults,
				showNextPage : showNextPage,
				scrollToSection : scrollToSection,
				search : search
			};
	
})();

package_utility.adjustNextButtons();
package_utility.showDefaultResults();
package_utility.showNextPage();
package_utility.scrollToSection();
package_utility.search.go();