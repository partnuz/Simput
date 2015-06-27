 (function( $ ) {
$.widget( "ui.combobox", {
	_create: function() {
		
		this.wrapper = $( "<span>" )
		.addClass( "smof-combobox" ).insertBefore( this.element );
		
		this.wrapper.append( this.element );

		
		console.log( this.element );
		
	
		this._createAutocomplete();
		this._createShowAllButton();
	},
	_createAutocomplete: function() {
		
		var ref = this;
		
		var source_names = this.element.data( 'smof-source-name' );
		var source = [];
		for( name_key in source_names ){

			source = source.concat( window[ source_names[ name_key ] ] );
			
		}
		
		var realSource = source;

		this.element.autocomplete({
			delay: 0,
			minLength: 0,
			source: realSource,
			select: function( event, ui ) {

				$( this ).data( 'smof-combobox' , ui.item );
				ref._selectTriggerChange();
				return true;
			},
			create: function( event, ui ) {
				
				var currentVal = $( this ).val();

				var data = $( this ).autocomplete( "option" , "source" ) || [];
				var currentItemData = [];

				data.map(function ( item ) {
					  if ( item.value && item.value.toLowerCase() == currentVal.toLowerCase() ) {
						return currentItemData = item;
					  }
				});
				
				console.log( currentItemData );
				$( this ).data( 'smof-combobox' , currentItemData );

				ref._selectTriggerChange();

				return true;
			}
		})
		.tooltip({
			tooltipClass: "ui-state-highlight"
		});
		/*
		this._on( this.input, {
			autocompleteselect: function( event, ui ) {
				ui.item.option.selected = true;
				this._trigger( "select", event, {
				item: ui.item.option
				});
				this._selectTriggerChange();
			},
			autocompletechange: "_removeIfInvalid"
		});
		*/
	},
	_createShowAllButton: function() {
		var input = this.element,
		wasOpen = false;
		$( "<a>" )
		.attr( "tabIndex", -1 )
		.attr( "title", "Show All Items" )
		.tooltip()
		.appendTo( this.wrapper )
		.button({
		icons: {
		primary: "ui-icon-triangle-1-s"
		},
		text: false
		})
		.removeClass( "ui-corner-all" )
		.addClass( "smof-combobox-toggle ui-corner-right" )
		.mousedown(function() {
		wasOpen = input.autocomplete( "widget" ).is( ":visible" );
		})
		.click(function() {
		input.focus();
		console.log( wasOpen );
		// Close if already visible
		if ( wasOpen ) {
		return;
		}
		// Pass empty string as value to search for, displaying all results
		input.autocomplete( "search", "" );
		});
	},


	_selectTriggerChange: function(){
		this.element.trigger( "change" );
	}
});
})( jQuery );

var SmofCombobox = function(){
	
}

SmofCombobox.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-field-combobox" ) ).each(function(index, value) {
		
		if( jQuery( this ).parents( '.smof-repeatable-pattern-item' ).first().get( 0 ) ) {
			
		}else{
			jQuery( this ).combobox();
			/*
			console.log( jQuery( this ).autocomplete( "search", jQuery( this ).val() ) );
			*/

		}

	});
	
}

jQuery(function() {
	
	SmofEvents.register( 'SmofCombobox' );

});
