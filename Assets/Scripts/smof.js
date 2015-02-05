(function($) {
  "use strict";
  
	jQuery(document).ready(function ($) {
		 $(".toggle").click(function () {
			$(this).closest( '.smof-toggle').find( '.body' ).toggle("blind");
			if ($(this).hasClass('toggle-more')) {
				$(this).removeClass("toggle-more");
			} else {
				$(this).addClass("toggle-more");
			}
		});
	});
	
})(jQuery);