

var SmofFontLinks = {
	'google_fonts': {
		'style_link_before' :'http://fonts.googleapis.com/css?family=',
		'style_link_after' : ''
	},
	'local': {
		'style_link' :'//link'
	},
};

function SmofFieldTypography( previewNode ){

	this._$previewNode = previewNode;
	this._$parentNode = this._$previewNode.parents( '.smof-container-typography' ).first();
	
	var obj = this;
	
	this._$fontFamilyNode = this._$parentNode.find( '.smof-field-typography-font-family' );
	this._$fontWeightNode = this._$parentNode.find( '.smof-field-typography-font-weight' );
	this._$fontSizeNode = this._$parentNode.find( '.smof-field-typography-font-size' );
	this._$lineHeightNode = this._$parentNode.find( '.smof-field-typography-line-height' );
	this._$colorNode = this._$parentNode.find( '.smof-field-typography-color' );
	
	// change this to general id
	this._styleId = 'smof-field-typography-style-'+ this._$parentNode.attr( 'id' );
	
	this.setEvents = function(){
	
		if( this._$fontFamilyNode ){
			this.fontFamily();
			this.rebuildFontWeight();
			this.addStyle();
			this.setFontFamilyEvent();
		}
		
		if( this._$fontWeightNode ){
			this.fontWeight();
			this.setFontWeightEvent();
		}
		
		if( this._$fontSizeNode ){
			this.fontSize();
			this.setFontSizeEvent();
		}
		
		if( this._$lineHeightNode ){
			this.lineHeight();
			this.setLineHeightEvent();
		}
		

		if( this._$colorNode ){
			this.color();
			this.setColorEvent();
		}

	
	}
	
	this.setFontFamilyEvent = function(){
		this._$fontFamilyNode.change( function(){
				obj.fontFamily();	
				obj.rebuildFontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontWeightEvent = function(){
		this._$fontWeightNode.change( function(){
				obj.fontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontSizeEvent = function(){
		this._$fontSizeNode.change( function(){
				obj.fontSize();
			}
		)
	}
	
	this.setLineHeightEvent = function(){
		this._$lineHeightNode.change( function(){
				obj.lineHeight();
			}
		)
	}
	
	this.setColorEvent = function(){
		this._$colorNode.change( function(){
				obj.color();
			}
		)
	}
	
	this.addStyle = function(){
		
		if( !this._$fontFamilyNode.children( ":selected" ).data( 'smof-typography-style' ) ){
			return;
		}
		
		var addStyle = false;
		var font = '';
		var weight = '';
		
		if( this._$fontFamilyNode ){
			
			font = this._$fontFamilyNode.children( ":selected" ).val().replace(/\s+/g, '+');
			addStyle = true;

		}
		
		if( this._$fontWeightNode && this._$fontFamilyNode ){

			weight = this._$fontWeightNode.children( ":selected" ).val();
				
		}
		
		if( addStyle ){
			jQuery( '#'+ this._styleId ).remove();
			if( weight ){ weight = ':' + weight;}
			jQuery('head').append('<link href="http://fonts.googleapis.com/css?family='+ font + weight +'" class="smof-field-typography-style" rel="stylesheet" type="text/css" id="'+ this._styleId +'">');
		}
	
	}
	
	this.fontFamily = function(){
		this._$previewNode.css( 'font-family' , this._$fontFamilyNode.children( ":selected" ).val() );
	}
	
	this.fontWeight = function(){
		console.log( this._$fontWeightNode.children( ":selected" ).val() );
		this._$previewNode.css( 'font-weight' , this._$fontWeightNode.children( ":selected" ).val() );
		console.log( this._$previewNode.css( 'font-weight' ) );
	}
	
	this.rebuildFontWeight = function(){

		if( obj._$fontWeightNode ){
			var fontWeightDefaultValue = obj._$fontWeightNode.data( 'smof-typography-font-weight-default' );
			obj._$fontWeightNode.find('option').remove();
			var font_weight = obj._$fontFamilyNode.children( ":selected" ).data( 'smof-typography-font-weight' );

			for( font_weight_id in font_weight ){

				var selected = ( font_weight_id == fontWeightDefaultValue ) ? 'selected="selected"' : '';


				obj._$fontWeightNode.append('<option value="' + font_weight_id + '" ' + selected +'>' + font_weight[ font_weight_id ] +'</option>')
			}
			obj._$fontWeightNode.data( 'smof-typography-font-weight-default' , '' )
			obj._$fontWeightNode.trigger( 'change' );
		}
	}
	
	this.fontSize = function(){
		this._$previewNode.css( 'font-size' , this._$fontSizeNode.val() + this._$fontSizeNode.data( 'smof-typography-font-size-unit' )  );
	}
	
	this.lineHeight = function(){

		this._$previewNode.css( 'line-height' , this._$lineHeightNode.val() + this._$lineHeightNode.data( 'smof-typography-line-height-unit' ) );
	}
	
	this.color = function(){
		this._$previewNode.css( 'color' , this._$colorNode.val() );
	}
	
	this.setEvents();
}

jQuery(function() {

	jQuery( ".smof-font-preview" ).each(function(index, value) {

		new SmofFieldTypography( jQuery( this ) );

	});

});