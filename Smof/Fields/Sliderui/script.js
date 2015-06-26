var SmofSliderui = function(){
	
}

SmofSliderui.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	prefix.find( ".smof-sliderui" ).each(function(index, value) {
		
		var obj   = jQuery(this);
		var sId   = "#" + obj.data('id');
		var val   = parseInt(obj.data('val'));
		var min   = parseInt(obj.data('min'));
		var max   = parseInt(obj.data('max'));
		var step  = parseInt(obj.data('step'));
		
		//slider init
		obj.slider({
			value: val,
			min: min,
			max: max,
			step: step,
			range: "min",
			slide: function( event, ui ) {
				jQuery(sId).val( ui.value );
			}
		});

	});
	
}

jQuery(function() {

	SmofSliderui.addEvent();

});