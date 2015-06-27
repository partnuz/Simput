// @koala-append '../../Fields/Color/script.js';
// @koala-append '../../Fields/Combobox/script.js';
// @koala-append '../../Fields/ImageSelect/script.js';
// @koala-append '../../Fields/ParentRepeatable/script.js';
// @koala-append '../../Fields/Sliderui/script.js';
// @koala-append '../../Fields/Switcher/script.js';
// @koala-append '../../Fields/Typography/script.js';
// @koala-append '../../Fields/Upload/script.js';

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
	
	jQuery( prefix.getElementsByClassName( "toggle" ) ).each(function(index, value) {
		
		new SmofToggle(  this  );

	});
	
}

jQuery( function(){
	
	SmofEvents.register( 'SmofToggle' );

});

// register all fields names
var SmofFieldRegister = [];

// adds events
var SmofEvents = function(){
	this.loadedSections = [];
	
}

SmofEvents.prototype.loadSection = function( section_id ){
	if( this.loadedSections.indexOf( section_id ) == -1 ){
		this.loadedSections.push( section_id );
		return true;
	}else{
		return false;
	}
}


SmofEvents.registered_events = [];

SmofEvents.getPrefix = function( prefix ){
	
	var node = document.getElementsByTagName('html')[ 0 ];
	
	if( prefix ){
	
		var type = typeof prefix;
		
		if( type == 'string' ){
			node = document.querySelector( prefix );

		}else if( prefix.nodeType ){
			node = prefix;

		}else if( type == 'object' ){
			node = prefix[ 0 ];

		}
		
	}
		
	return node;

}


SmofEvents.addEvent = function( prefix ){
	
	var prefix = SmofEvents.getPrefix( prefix );
	
	// execute them here, remove code below
	
	console.log( prefix );
	
	var registered_events_length = this.registered_events.length;
	
	for( var i = 0; i < registered_events_length; i++ ){

		window[ this.registered_events[ i ] ].addEvent( prefix );
		
	}
	
	
	
	/*
	SmofColor.addEvent( prefix );
	SmofCombobox.addEvent( prefix );
	SmofImageSelect.addEvent( prefix );
	SmofSliderui.addEvent( prefix );
	SmofSwitcher.addEvent( prefix );
	SmofFieldTypography.addEvent( prefix );
	SmofUpload.addEvent( prefix );
	SmofRepeatable.addEvent( prefix );
	SmofToggle.addEvent( prefix );
	*/
}

SmofEvents.register = function( event_name ){
	
	this.registered_events.push( event_name );
};