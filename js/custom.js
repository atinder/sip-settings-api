jQuery(document).ready(function($) {
	  		$('.wrap .nav-tab-wrapper a').first().addClass('nav-tab-active');
	       	var formObj = $('div.wrap').find('.at-section-wrap');
	        formObj.hide();
	        formObj.first().fadeIn();
		
		$('.nav-tab-wrapper a').click(function(e){
			e.preventDefault();
			switch_tabs($(this));
		});

		function switch_tabs(obj){
			formObj.hide();
			$('.nav-tab-wrapper a').removeClass("nav-tab-active");
			var id = obj.attr("rel");
			$('#'+id).fadeIn();
			obj.addClass("nav-tab-active");
		}

});