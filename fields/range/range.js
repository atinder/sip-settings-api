jQuery(document).ready(function($) {


			$('.at-range').on('change',function(){
				rangeVal = $(this).val();
				$(this).siblings().closest("input").val(rangeVal);
				
			});
 
});
