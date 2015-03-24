var SmofToggle = function( $container ){
	
	var obj = this;
	
	this.$container = $container;
	
	this.onClick = function(){
		
		$container.click( this.toggle );
	}
	
	this.toggle = function(){
		
		jQuery(this).closest( '.smof-toggle').find( '.body' ).toggle("blind");
		
		if (this.$container.hasClass('toggle-more')) {
			jQuery(this).removeClass("toggle-more");
		} else {
			jQuery(this).$container.addClass("toggle-more");
		}
		
	}
	
	this.onClick();
	
}

SmofToggle.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	prefix.find( ".toggle" ).each(function(index, value) {
		
		new SmofToggle( jQuery( this ) );

	});
	
}

jQuery(function() {

	SmofToggle.addEvent();

});

var SmofEvents = function(){
	
}

SmofEvents.getPrefix = function( prefix ){
	
	var query = jQuery('html');
	
	if( prefix ){
	
		var type = typeof prefix;
		
		if( type == 'string' ){
			query = jQuery( prefix );

		}else if( prefix.nodeType ){
			query = jQuery( prefix );

		}else if( type == 'object' ){
			query = prefix;

		}
		
	}
		
	return query;

}


SmofEvents.add = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	SmofColor.addEvent( prefix );
	SmofCombobox.addEvent( prefix );
	SmofImageSelect.addEvent( prefix );
	SmofSliderui.addEvent( prefix );
	SmofSwitch.addEvent( prefix );
	SmofFieldTypography.addEvent( prefix );
	SmofUpload.addEvent( prefix );
	SmofRepeatable.addEvent( prefix );
	SmofToggle.addEvent( prefix );
}