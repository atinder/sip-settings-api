jQuery(document).ready(function($) {

			$('.at-upload').click(function() {
				field = $(this).attr('rel-id');
				tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 
				// when the thick box is opened set send to editor button
				set_send($(this),'#' + field);
				return false;
			});

			function set_send(parent, field) {
				// store send_to_event so at end of function normal editor works
				window.original_send_to_editor = window.send_to_editor;
			 
				// override function so you can have multiple uploaders pre page
				window.send_to_editor = function(html) {
					imgurl = $('img',html).attr('src');
					$(field).val(imgurl);
					//$(field).siblings().closest('img').attr('src', imgurl)
					tb_remove();
					// Set normal uploader for editor
					window.send_to_editor = window.original_send_to_editor;
				};
			}

			$('.at-remove').click(function(e){
				e.preventDefault();
				$(this).hide();
				field = $(this).attr('rel-id');
				$('#'+ field).val('');
				$(this).siblings().closest("img").fadeOut();
			});
 
});