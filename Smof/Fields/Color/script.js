//Color picker
( function( $ ){
	
	$('.smof-field-color').wpColorPicker({
		/*
		change: function( event, ui ) {
			console.log( ui.color.toRgb() );
			console.log( $('.smof-field-typography-color') );
			console.log( event.target );
			
		}
		*/
		
		change: _.throttle( function( event , ui) { 
            $(this).trigger( 'change' );
        }, 2000 )
	});
})(jQuery);
  	