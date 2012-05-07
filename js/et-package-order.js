(function($) {

	// jQuery plugin definition
	$.fn.TextAreaExpander = function(minHeight, maxHeight) {

		var hCheck = !($.browser.msie || $.browser.opera);

		// resize a textarea
		function ResizeTextarea(e) {

			// event or initialize element?
			e = e.target || e;

			// find content length and box width
			var vlen = e.value.length, ewidth = e.offsetWidth;
			if (vlen != e.valLength || ewidth != e.boxWidth) {

				if (hCheck && (vlen < e.valLength || ewidth != e.boxWidth)) e.style.height = "0px";
				var h = Math.max(e.expandMin, Math.min(e.scrollHeight, e.expandMax));

				e.style.overflow = (e.scrollHeight > h ? "auto" : "hidden");
				e.style.height = (h + 6) + "px";

				e.valLength = vlen;
				e.boxWidth = ewidth;
			}

			return true;
		};

		// initialize
		this.each(function() {

			// is a textarea?
			if (this.nodeName.toLowerCase() != "textarea") return;

			// set height restrictions
			var p = this.className.match(/expand(\d+)\-*(\d+)*/i);
			this.expandMin = minHeight || (p ? parseInt('0'+p[1], 10) : 0);
			this.expandMax = maxHeight || (p ? parseInt('0'+p[2], 10) : 99999);

			// initial resize
			ResizeTextarea(this);

			// zero vertical padding and add events
			if (!this.Initialized) {
				this.Initialized = true;
				$(this).css("padding-top", 3).css("padding-bottom", 3);
				$(this).bind("keyup", ResizeTextarea).bind("focus", ResizeTextarea);
			}
		});

		return this;
	};

})(jQuery);

var package_order = (function(){
	
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
			  length: 6,
			  width: 4,
			  radius: 8,
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
		 handleErrors = function(errors, elem){		
			var elements = ["<ul>"];
			
			for(i in errors)
			{
				if(errors.hasOwnProperty(i))
				{
					elements.push("<li>"+errors[i]+"</li>"); 										
				}
			}
			elements.push["</ul>"];			
			var container = elem.closest(".box");
			if(!container.length)
			{
				container = elem.find(".box"); 
			}
			container.find(".alert").removeClass("alert-success").addClass("alert-error");
			container.find(".alert_content").html(elements.join(''));
			container.find("strong").text('The Following errors occured:');
			container.find(".alert_container").show(); 
		 },	
		 showSuccessMessage = function(elem)
		 {
			 var container = elem.find(".box");
			 container.find(".alert").removeClass("alert-error").addClass("alert-success");
			 container.find("strong").text('Message Sent:');
			 container.find(".alert_content").html("Your message was successfully posted to the service provider." +
			 		" Please note that all conversations are archived for arbitration purposes and will appear in chronological order on your conversation thread while this order is yet to be fulfilled.");
			 container.find(".alert_container").show();
			 
		 }
		 reqUrl = $("#po_form").attr("action"),
		 messageUrl = $("#msg-form").attr("action"),
		 conversation = $("section#conversation"),
		 messageContainer = $('<div class = "row-fluid"><div class = "msg-content span9"></div></div>'),
		 highlight = function(elem){
			 elem.children(".mbox").children(".row-fluid:first").addClass("highlight");
		 },
		 template = $("#temp"),
		 order_id = template.data("id"),
		 showMessage = function(message, time, type, isHighlighted){
			var mcont = template.find(".mcont");
			var newCont = mcont.clone();	
			var rows = $(".mrows");
			newCont.find(".time").text(time);					
			newCont.find(".pmess").html(message);
			if(rows.children(".mcont").length == 5)
			{
				rows.children(".mcont:last").remove();
				getPager(1);
			}			
			
			if(type == "new"){
				rows.prepend(newCont);
				if(isHighlighted){
					highlight(newCont);
				}
			}
			else
			{
				rows.append(newCont);
			}
			conversation.show();
		 },
		 uploadFile = function(e){		
			 elem = $(this);			 
			 var spinner = small_spinner.spin(document.getElementById("spinner_2"));	
			 $("#po_form").ajaxSubmit({
					url : reqUrl+"&req_type=ajax&c=file_upload",
					dataType: "json", 						
					success : function(data)
					{							
						if(data.messageType == "error")
						{ 		
							handleErrors(data.errors, elem);											
						}
						else if(data.messageType = "success")
						{
							$("#uploaded_file").html($("input#PackageOrderMsg_associated_resource").val()); 				
						} 
						spinner.stop();
					}
			}); 
		 },		 
		 updateStatus = function()
		 {
			 $.ajax({
				 url : "/entrepreneurs/packages/checkStatus",				
				 method : "GET",
				 data : {n : order_id},
				 success : function(data)
				 {
					 $(".status").remove();
					 $(".status_cont").append($(data));					 
				 } 
			 }); 
		 },
		getPager = function(page)
		{
			 $.ajax({
				 url : "/entrepreneurs/packages/getPagination",				
				 method : "GET",
				 data : {id : order_id, page : page},
				 success : function(data)
				 {
					 $(".pager").html(data);					 
				 } 
			 }); 
		},
		spin_cont = $('<div style = "width: 100px; padding: 50px; margin: 0px auto;"></div>'),
		startConvSpinner = function()
		{	
			var rows = conversation.find(".mrows");
			rows.html("");
			var dom_spin = spin_cont.appendTo(rows).get(0);			
			return large_spinner.spin(dom_spin);	
		},
		stopConvSpinner = function(spinner)
		{
			spinner.stop();
			spin_cont.remove();
		},			
		countDown = function()
		{	
			
			var counter = $(".count_down"),
			sec_cont = counter.find("span.fseconds"),					
			min_cont = counter.find("span.fminutes"),
			hr_cont = counter.find("span.fhours"),			
			d_cont = counter.find("span.fdays"),
			l_sec = $("span.lseconds"),
			l_min = $("span.lminutes"),
			l_hrs = $("span.lhours"),
			l_days = $("span.ldays"),
			start = false,
			sec = sec_cont.text(),
			min = min_cont.text(),
			hr = hr_cont.text(),
			d = d_cont.text();
			
			if(hr > 0 || min > 0 || d > 0 || sec > 0){
			var timer = setInterval(function(){
					if(!start)
					{
						start = true;
						return;
					}
					if(sec > 0)
					{
						if(sec == 2)
						{							
							l_sec.text(" second");
						}
						if(sec == 1)
						{
							l_sec.text(" seconds");
						}
						sec--;						
					}
					else
					{
						if(hr > 0 || min > 0 || d > 0)
						{
							sec = 59;
							if(min > 0)
							{
								if(min == 2)
								{
									l_min.text(" minute");
								}
								if(min == 1)
								{
									l_min.text(" minutes");
								}
								min--;
							}
							else
							{
								min = 59;
								if(hr > 0)
								{
									if(hr == 2)
									{
										l_hrs.text(" hour");
									}
									if(hr == 1)
									{
										l_hrs.text(" hours");
									}
									hr--;
								}
								else
								{
									hr = 23;
									if(d > 0)
									{
										if(d == 2)
										{
											l_days.text(" day");
										}
										if(hr == 1)
										{
											l_days.text(" days");
										}										
										d_cont.text(--d);
									}
									else if((sec == 0) && (min == 0) && (hr == 0))
									{
										clearInterval(timer);
									}
								}
								hr_cont.text(hr);
							}
							min_cont.text(min)
						}
						else
						{
							return;
						}
					}
					sec_cont.text(sec);	
				}, 1000);			
			}
						
		},
		clearGlobalMessage = function()
		{
			var osa = $(".order_success_alert");
			if(osa.length)
			{
				osa.hide();
			}
		},
		sendMessage = function()
		{
			var mElem = $("textarea.order_msg"), message = mElem.val(), form = $("#msg-form");				
			mElem.css({height:'26px'});
			mElem.blur();					
			
			form.ajaxSubmit({
				url : messageUrl + "&req_type=ajax",
				dataType: "json",
				method: "post",
				data:{order_msg:message},
				success: function(data)
				{				
					if(data.messageType == "success"){
						$(".mrows").append(messageContainer);						
						showMessage(message, data.time, "new", false);
						$("section#send_message").show();
						mElem.val("");
						showSuccessMessage(form);
						clearGlobalMessage();						
					}
					else
					{												
						handleErrors(data.errors, form);
					}
				},
			});
		},
		initializeTimer = function(){
			$.ajax({
				url  : '/entrepreneurs/packages/getOrderDeadline',
				data : {n : order_id},
				dataType : "json",
				success : function(data)
				{
					if(!data.isDue)
					{
						var time = data.time;
						$("span.fseconds").text(time.seconds);
						$("span.fminutes").text(time.minutes);
						$("span.fhours").text(time.hours);
						$("span.fdays").text(time.days);
						
						$(".count_down").show();
						countDown();
					}					
				}
			});
		},
		getConversations = function(page)
		{				 
			 spinner = startConvSpinner();			
			 $.ajax({
				 url : "/entrepreneurs/packages/getConversations",
				 dataType: "json",
				 method : "GET",
				 data : {n:template.data("id"), page : page},
				 success : function(data)
				 {
					 var messageType = data.messageType;
					 if(messageType == "success")
					 {
						 var items = data.items;						
						 for(i in items)
						 {							 
							 if(items.hasOwnProperty(i))
							 {
								 showMessage(items[i]['message'], items[i]['create_time'], "old", false);								 
							 }
						 }						
					 }
					 
					stopConvSpinner(spinner);
					 					
				 } 
			 });
			 
			getPager(page);
		};
		
		$("input#PackageOrderMsg_associated_resource").change(uploadFile);
		
		$("#po_form").ajaxForm({			
			url : reqUrl+"&req_type=ajax&c=message",
			dataType : "json", 
			success: function(data)
			{		
				console.log(data);
				if(data.messageType == "error")
				{					
					handleErrors(data.errors, $("#po_form"));
				}
				else if(data.messageType == "success")
				{						
					showMessage($("textarea.order_req").val(), data.last_modified, "new", true);
					$("#po_form").closest(".req_cont").remove();					
					$("section#send_message").show();					
					$(".nf").hide();
					$("span#ad").text(data.delivery + " days");
					$("div.rs").show();
					clearGlobalMessage();
					updateStatus();
					initializeTimer();	
					$("section#arbitration").show();
				}
			}
		});
		
		$(".msg-box").delegate(".order_msg", "keyup", function(e){			
			if(e.keyCode == 13)
			{
				sendMessage();
			}
		});
		
		$(".msg-box").delegate("input#order_ar", "change", function(e){	
			var remove_link = $('<a/>',{href:"#", 'class':'rlink right', 'html':'<i class = "icon-remove-circle"></i>Remove'});
			$("span#muploaded_file").append($(this).val()).append(remove_link);			
		});
		
		$(".msg-box").delegate(".rlink", "click", function(e){			
			e.preventDefault();
			$("#order_ar").val("");
			$(this).parent().empty();
		});
		
		$(".msg-box").delegate(".sm", "click", function(e){			
			e.preventDefault();
			sendMessage();
		});
		
		conversation.delegate(".mcont", "click", function(e){
			var pmess = $(this).find(".pmess");			
			if(pmess.hasClass("ellipsis"))
			{
				pmess.removeClass("ellipsis");				
			}
			else
			{
				pmess.addClass("ellipsis");
			}	
			$(this).children(".mbox").children(".row-fluid:first").removeClass("highlight");
		});
		
		conversation.delegate(".mcont", "mouseover", function(e){
			var row = $(this).children(".mbox").children(".row-fluid:first");
			row.addClass("white_highlight");
		});
		conversation.delegate(".mcont", "mouseout", function(e){
			var row = $(this).children(".mbox").children(".row-fluid:first");
			row.removeClass("white_highlight");
		});
		conversation.delegate(".pagination li","click", function(e){
			e.preventDefault();
			var p = $(this).children("a").attr("href").split('&');			
			if(p.length > 1)
			{
				var m = p[1].split('=');				
				getConversations(m[1]);				
			}
			else
			{
				getConversations(1);
			}			
			
		});	
	
		
		getConversations(1);
		
		countDown();
		
		jQuery("textarea[class*=expand]").TextAreaExpander();
		
})();

