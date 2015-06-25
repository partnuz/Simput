function SmofRepeatable( $parentNode ){
	var obj = this;
	this.$parentNode = $parentNode;
	// check what is first
	this.$addNewItem = this.$parentNode.find( '> .smof-field-body > .smof-field-repeatable-add-new' );
	this.$deleteNodes = this.$parentNode.find( '> .smof-field-body > ul > li > .smof-after-item > .smof-repeatable-delete' );
	this.$patternItemNode = this.$parentNode.find( '> .smof-field-body > ul > .smof-repeatable-pattern-item' );
	this.$items = null;
	
	this.parentsNum = 0;
	
	
	this.setSortable = function(){
		this.$parentNode.find( '> .smof-field-body > ul' ).sortable({
			handle: '.smof-before-item'
		});
	}
	

	this.addNewEvents = function(){
		
		SmofEvents.add( this.$patternItem );
		/*
		this.$patternItemClone.find( '.smof-repeatable' ).each( 
			function(){
				new SmofRepeatable( jQuery( this ) );
				
			}
		);
		*/
	}

	
	this.addNewItem = function(){
		
		console.log( 'addNewItem');
	
		this.$patternItemClone = this.$patternItemNode.clone( );
		this.$patternItemClone.removeClass( 'smof-hidden' ).removeClass( 'smof-repeatable-pattern-item' );
		console.log( this.$patternItemClone );
		
		this.obtainParentsNum();
		
		this.obtainCurrentListItems();
		
		this.assignMaxItemNameOrder();
		this.assignMaxItemIdOrder();
		
		this.replaceAttr();
		
		this.setDeleteItemEvents( this.$patternItemClone.find( '> .smof-after-item > .smof-repeatable-delete' ) );
	
		this.newItemAppend();
		
		this.addNewEvents();

	}
	
	this.newItemAppend = function(){
		this.$patternItem = this.$patternItemClone.appendTo( this.$patternItemNode.parent( 'ul' ) ).get(0);
		console.log( this.$patternItem );
		console.log( this.$patternItemNode.parent( 'ul' ) );
	}
	
	this.replaceDataName = function( $node ){
		
		var isInPatternItem = $node.parents( '.smof-repeatable-pattern-item') .first().length;
		if( isInPatternItem == 1 ){
			return;
		}
		
		var nodeName = $node.attr( 'data-smof-name' );
		
		$node.attr("name", nodeName ).removeAttr('data-smof-name');
		return $node;
	}
	
	this.assignMaxItemNameOrder = function(){
		
		var maxItemOrder = -1;
		
		this.$items.each( function(){
			
			var $container = jQuery( this ).find( '> .smof-item > .smof-container').first();
			if( !$container[ 0 ] ){
				var $container = jQuery( this ).find( '> .smof-toggle > .body > .smof-container').first();
			}
			console.log( 'container' );
			console.log( $container );

			var currentName = $container.find( '*[name]' ).first().attr('name');
			console.log( 'currentName' + currentName );
			var maxItemOrderCurrent = obj.findMaxItemNameOrder( currentName , obj.parentsNum );
			console.log( 'maxItemOrderCurrent' + maxItemOrderCurrent );
			
			if( maxItemOrderCurrent !== null && maxItemOrderCurrent > maxItemOrder ){
				maxItemOrder = maxItemOrderCurrent;
			}
		})
		
		this.maxItem = maxItemOrder + 1;
		console.log( 'maxItemOrder' + this.maxItem );
		
	}
	
	this.obtainCurrentListItems = function(){
		
		// not pattern item
		this.$items = this.$parentNode.find('ul.ui-sortable').first().find( '> li:not( .smof-repeatable-pattern-item )' );
		console.log( 'li number' );
		console.log( this.$items );
	}
	
	this.assignMaxItemIdOrder = function(){
		
		var maxItemIdOrder = -1;
		
		this.$items.each( function(){
			
			var $container = jQuery( this ).find( '> .smof-item > .smof-container').first();
			if( !$container[ 0 ] ){
				var $container = jQuery( this ).find( '> .smof-toggle > .body > .smof-container').first();
			}
			console.log( 'containerId' );
			console.log( $container );

			var currentId = $container.attr('id');
			console.log( 'currentId' + currentId );
			var maxItemIdOrderCurrent = obj.findMaxItemIdOrder( currentId , obj.parentsNum );
			console.log( 'maxItemOrderCurrent' + maxItemIdOrderCurrent );
			
			if( maxItemIdOrderCurrent !== null && maxItemIdOrderCurrent > maxItemIdOrder ){
				maxItemIdOrder = maxItemIdOrderCurrent;
			}
		})
		
		this.maxItemId = maxItemIdOrder + 1;
		console.log( 'maxItemIdOrder' + this.maxItemId );
		
	}
	
	this.replaceAttr = function(){

		this.$patternItemClone.find('*[data-smof-name]').each( 
			function(){
				
				console.log( jQuery( this ) );
				
				$element = jQuery( this );
				console.log( 'replaceable' );
				console.log( $element.attr( 'data-smof-name' ) );
				
				$element.attr( 'data-smof-name' , obj.replaceNameOrder( $element.attr( 'data-smof-name' ) , obj.maxItem , obj.parentsNum  ) );
				
				
				$element = obj.replaceDataName( $element );
				// replace name
				// change pseudo name to name
				// replace id's
				// 
				
			}
		);
		
		this.$patternItemClone.find('.smof-container').each( 
			function(){
				
				console.log( jQuery( this ) );
				
				$element = jQuery( this );
				console.log( 'replaceable_id' );
				console.log( $element.attr( 'id' ) );
				
				$element.attr( 'id' , obj.replaceIdOrder( $element.attr( 'id' ) , obj.maxItemId , obj.parentsNum  ) );
				
				// replace name
				// change pseudo name to name
				// replace id's
				// 
				
			}
		);
	}
	
	this.obtainParentsNum = function(){

		this.parentsNum = this.$parentNode.parents( '.smof-repeatable' ).length; // is this right;
		console.log( 'parentsNum' + this.parentsNum );
		
	}
	
	this.findMaxItemNameOrder = function( name , parentsNum ){

		var query = new RegExp('\\[[0-9]+\\]' , "g");
		var allNums = name.match( query );
		console.log( allNums );
		console.log( 'NameAllNums' + allNums );
		
		// convert to int
		if( allNums ){
			return parseInt( allNums[ parentsNum ].replace( /\[|\]/g , '' ) );
		}
		
	}
	
	this.findMaxItemIdOrder = function( id , parentsNum ){

		var query = /-[0-9]+/g;
		var allNums = id.match( query );
		console.log( allNums );
		console.log( 'IdAllNums' + allNums );


			
			// convert to int
			if( allNums ){
				return parseInt( allNums[ parentsNum ].replace( /-/g , '' ) );
			}

		
	}
	
	this.replaceNameOrder = function( name, replaceNum , numOrder ){
		
		console.log( name + ' ' + replaceNum + ' ' + numOrder)
		// all
		var query = new RegExp('\\[[0-9]+\\]' , "g");
		var i = -1;
		var result = name.replace( query , function( m , v){
			
			i++;
			return ( i == numOrder ) ? '[' + replaceNum + ']' : m ;
			
		});
		
		console.log( result );
		
		return result;
	}
	
	this.replaceIdOrder = function( id, replaceNum , numOrder ){
		
		console.log( id + ' ' + replaceNum + ' ' + numOrder)
		// all
		var query = /-[0-9]+/g;
		var i = -1;
		var result = id.replace( query , function( m , v){
			
			i++;
			return ( i == numOrder ) ? '-' + replaceNum : m ;
			
		});
		
		console.log( result );
		
		return result;
	}
	
	this.setDeleteItemEvents = function( $deleteNodes ){
	
		$deleteNodes.each(
			function(){
				obj.deleteItem( jQuery( this ) );
			}
		);
	}
	
	this.addNewItemEvent = function(){
		
		this.$addNewItem.click( function(){
			console.log( 'add new item event' );
			obj.addNewItem();
		});
		
	}
	
	this.deleteItem = function( $deleteNode ){
	
		$deleteNode.click(
			function() {
				jQuery(this).parents( 'li' ).first().remove();
				console.log( 'bla');
			}
		);
	}
	
	this.setSortable();
	this.addNewItemEvent();
	this.setDeleteItemEvents( this.$deleteNodes );
}

SmofRepeatable.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	console.log( typeof prefix );
	
	jQuery( document.getElementsByTagName('html')[0].getElementsByClassName( "smof-repeatable" ) ).each(function(index, value) {
		
		new SmofRepeatable( jQuery( this ) );

	});
	
}

jQuery(document).ready(function($){

	SmofRepeatable.addEvent();

});