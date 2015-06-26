function SmofImageSelect( parentNode ){

	var obj = this;
	this._$parentNode = parentNode;
	this._$imageNodes = this._$parentNode.find( '.smof-field-image_select-image' );
	console.log( this._$imageNodes );
	
	this.setEvents = function(){
		this._$imageNodes.each(function(index, value) {

			jQuery( this ).click( function(){
				
				obj.changeItem( jQuery( this ) );
				
			});

		});
	}
	
	this.changeItem = function( $imageNode ){
		this._$parentNode.find( '.smof-field-image_select-order-' + $imageNode.data( 'smof-order') ).prop('checked', true);
		this._$imageNodes.removeClass('smof-field-image_select-selected');
		$imageNode.addClass('smof-field-image_select-selected');
	}
	
	this.setEvents();
}

SmofImageSelect.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	prefix.find( ".smof-container-image_select" ).each(function(index, value) {
		
		new SmofImageSelect( jQuery( this ) );

	});
	
}

jQuery( function(){
	
	SmofImageSelect.addEvent();

});