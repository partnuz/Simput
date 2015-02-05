function AdwfAddNew(){
	jQuery( ".smof-repeatable .add_new" ).click(function() {
	
		var pattern_item = jQuery(this).parents( '.smof-repeatable' ).find( '.smof-repeatable-exemplar' );
		var pattern_item_clone = pattern_item.clone();
		var pattern_item_select_name = pattern_item.find( 'select' ).attr( 'data-name' );
		pattern_item_clone.find( 'select' ).attr("name", pattern_item_select_name).removeAttr('data-name');
		pattern_item_clone.removeClass().appendTo( jQuery(this).parent().children( 'ul' ) );
		
		AdwfSelectSortableDelete();
		console.log( "add new" );
	});
}



function SmofRepeatable( $parentNode ){
	var obj = this;
	this._$parentNode = $parentNode;
	this._$addNewNode = this._$parentNode.find( '.smof-repeatable-add-new' );
	this._$deleteNodes = this._$parentNode.find( '.smof-repeatable-delete' );
	this._$patternItemNode = this._$parentNode.find( '.smof-repeatable-pattern-item' );
	
	this.setSortable = function(){
		this._$parentNode.find( 'ul' ).sortable();
	}
	
	this.addNewItem = function(){
	
		var patternItemClone = this._$patternItemNode.clone();
	
	}
	
	this.setDeleteItemEvents = function(){
	
		this._$deleteNodes.each(
			function(){
				obj.deleteItem( jQuery( this ) );
			}
		);
	}
	
	this.deleteItem = function( $deleteNode ){
	
		$deleteNode.click(
			function() {
				jQuery(this).parent().remove();
				console.log( 'bla');
			}
		);
	}
	
	this.setSortable();
	this.addNewItem();
	this.setDeleteItemEvents();
}

jQuery(document).ready(function($){

	jQuery( '.smof-repeatable' ).each( 
		function(){
			new SmofRepeatable( jQuery( this ) );
			
		}
	);

});