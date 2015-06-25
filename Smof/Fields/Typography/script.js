
var SmofFontLinks = SmofFontLinks || {};

SmofFontLinks[ 'google_fonts' ] = {
		'style_link_before' :'http://fonts.googleapis.com/css?family=',
		'style_link_after' : ''
};

SmofFontLinks[ 'local' ] = {
	'style_link_before' :'//link'
}

function SmofFieldTypography( previewNode ){

	this.$previewNode = previewNode;
	this.$parentNode = this.$previewNode.parents( '.smof-container-typography' ).first();
	
	var obj = this;
	
	this.$fontFamilyNode = this.$parentNode.find( '.smof-field-typography-font-family' );
	this.$fontWeightNode = this.$parentNode.find( '.smof-field-typography-font-weight' );
	this.$fontSizeNode = this.$parentNode.find( '.smof-field-typography-font-size' );
	this.$lineHeightNode = this.$parentNode.find( '.smof-field-typography-line-height' );
	this.$colorNode = this.$parentNode.find( '.smof-field-typography-color' );
	
	// change this to general id
	this.styleId = 'smof-field-typography-style-'+ this.$parentNode.attr( 'id' );
	
	this.setEvents = function(){
	
		if( this.$fontFamilyNode ){
			this.fontFamily();
			this.rebuildFontWeight();
			this.addStyle();
			this.setFontFamilyEvent();
		}
		
		if( this.$fontWeightNode ){
			this.fontWeight();
			this.setFontWeightEvent();
		}
		
		if( this.$fontSizeNode ){
			this.fontSize();
			this.setFontSizeEvent();
		}
		
		if( this.$lineHeightNode ){
			this.lineHeight();
			this.setLineHeightEvent();
		}
		

		if( this.$colorNode ){
			this.color();
			this.setColorEvent();
		}

	
	}
	
	this.setFontFamilyEvent = function(){
		this.$fontFamilyNode.change( function(){
				obj.fontFamily();	
				obj.rebuildFontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontWeightEvent = function(){
		this.$fontWeightNode.change( function(){
				obj.fontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontSizeEvent = function(){
		this.$fontSizeNode.change( function(){
				obj.fontSize();
			}
		)
	}
	
	this.setLineHeightEvent = function(){
		this.$lineHeightNode.change( function(){
				obj.lineHeight();
			}
		)
	}
	
	this.setColorEvent = function(){
		this.$colorNode.on( 'custom', {},  function( evt , color ){
			
				console.log( 'setColorEvent' );
				console.log( color );
				obj.color( color );
			}
		)
	}
	
	this.addStyle = function(){
		
		if( !this.$fontFamilyNode.children( ":selected" ).data( 'smof-typography-weight' ) ){
			return;
		}
		
		var addStyle = false;
		var font = '';
		var weight = '';
		
		if( this.$fontFamilyNode ){
			
			font = this.$fontFamilyNode.children( ":selected" ).val().replace(/\s+/g, '+');
			addStyle = true;

		}
		
		if( this.$fontWeightNode && this.$fontFamilyNode ){

			weight = this.$fontWeightNode.children( ":selected" ).val();
				
		}
		
		if( addStyle ){
			jQuery( '#'+ this.styleId ).remove();
			if( weight ){ weight = ':' + weight;}
			jQuery('head').append('<link href="http://fonts.googleapis.com/css?family='+ font + weight +'" class="smof-field-typography-style" rel="stylesheet" type="text/css" id="'+ this.styleId +'">');
		}
	
	}
	
	this.fontFamily = function(){
		this.$previewNode.css( 'font-family' , this.$fontFamilyNode.children( ":selected" ).val() );
	}
	
	this.fontWeight = function(){
		console.log( this.$fontWeightNode.children( ":selected" ).val() );
		this.$previewNode.css( 'font-weight' , this.$fontWeightNode.children( ":selected" ).val() );
		console.log( this.$previewNode.css( 'font-weight' ) );
	}
	
	this.rebuildFontWeight = function(){

		if( obj.$fontWeightNode ){
			var fontWeightDefaultValue = obj.$fontWeightNode.data( 'smof-typography-weight-default' );
			obj.$fontWeightNode.find('option').remove();
			var font_weight = obj.$fontFamilyNode.children( ":selected" ).data( 'smof-typography-weight' );

			for( font_weight_id in font_weight ){

				var selected = ( font_weight_id == fontWeightDefaultValue ) ? 'selected="selected"' : '';


				obj.$fontWeightNode.append('<option value="' + font_weight[ font_weight_id ] + '" ' + selected +'>' + font_weight[ font_weight_id ] +'</option>')
			}
			obj.$fontWeightNode.data( 'smof-typography-weight-default' , '' )
			obj.$fontWeightNode.trigger( 'change' );
		}
	}
	
	this.fontSize = function(){
		this.$previewNode.css( 'font-size' , this.$fontSizeNode.val() + this.$fontSizeNode.data( 'smof-typography-font-size-unit' )  );
	}
	
	this.lineHeight = function(){

		this.$previewNode.css( 'line-height' , this.$lineHeightNode.val() + this.$lineHeightNode.data( 'smof-typography-line-height-unit' ) );
	}
	
	this.color = function( color ){
		var color = color ||  this.$colorNode.val();
		this.$previewNode.css( 'color' , color );
	}
	
	this.setEvents();
}

SmofFieldTypography.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( document.getElementsByTagName('html')[0].getElementsByClassName( "smof-font-preview" ) ).each(function(index, value) {
		
		new SmofFieldTypography( jQuery( this ) );

	});
	
}

jQuery(function() {

	SmofFieldTypography.addEvent();

});