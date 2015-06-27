
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
			this.previewFontFamily();
			this.rebuildFontWeight();
			this.addStyle();
			this.setFontFamilyEvent();
		}
		
		if( this.$fontWeightNode ){
			this.previewFontWeight();
			this.setFontWeightEvent();
		}
		
		if( this.$fontSizeNode ){
			this.previewFontSize();
			this.setFontSizeEvent();
		}
		
		if( this.$lineHeightNode ){
			this.previewLineHeight();
			this.setLineHeightEvent();
		}
		

		if( this.$colorNode ){
			this.previewColor();
			this.setColorEvent();
		}

	
	}
	
	this.setFontFamilyEvent = function(){
		this.$fontFamilyNode.change( function(){
				obj.previewFontFamily();	
				obj.rebuildFontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontWeightEvent = function(){
		this.$fontWeightNode.change( function(){
				obj.previewFontWeight();
				obj.addStyle();
			}
		)
	}
	
	this.setFontSizeEvent = function(){
		this.$fontSizeNode.change( function(){
				obj.previewFontSize();
			}
		)
	}
	
	this.setLineHeightEvent = function(){
		this.$lineHeightNode.change( function(){
				obj.previewLineHeight();
			}
		)
	}
	
	this.setColorEvent = function(){
		this.$colorNode.on( 'custom', {},  function( evt , color ){
			
				console.log( 'setColorEvent' );
				console.log( color );
				obj.previewColor( color );
			}
		)
	}
	
	this.addStyle = function(){
		
		if( !this.$fontFamilyNode.data( 'smof-combobox' ).weight ){
			return;
		}
		
		var addStyle = false;
		var font = '';
		var weight = '';
		
		if( this.$fontFamilyNode ){
			
			font = this.$fontFamilyNode.data( 'smof-combobox' ).value.replace(/\s+/g, '+');
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
	
	this.previewFontFamily = function(){
		this.$previewNode.css( 'font-family' , this.$fontFamilyNode.data( 'smof-combobox' ).value );
	}
	
	this.previewFontWeight = function(){

		this.$previewNode.css( 'font-weight' , this.$fontWeightNode.children( ":selected" ).val() );

	}
	
	this.rebuildFontWeight = function(){
		console.log( obj.$fontWeightNode );
		if( obj.$fontWeightNode ){
			console.log( 'rebuildFontWeight' );
			var fontWeightDefaultValue = obj.$fontWeightNode.data( 'smof-typography-weight-default' );
			obj.$fontWeightNode.find('option').remove();
			var font_weight = obj.$fontFamilyNode.data( 'smof-combobox' ).weight;
			console.log( obj.$fontFamilyNode.data( 'smof-combobox' ).weight );

			for( font_weight_id in font_weight ){

				var selected = ( font_weight_id == fontWeightDefaultValue ) ? 'selected="selected"' : '';

				obj.$fontWeightNode.append('<option value="' + font_weight[ font_weight_id ] + '" ' + selected +'>' + font_weight[ font_weight_id ] +'</option>')
			}
			obj.$fontWeightNode.data( 'smof-typography-weight-default' , '' )
			obj.$fontWeightNode.trigger( 'change' );
			

		}
	}
	
	this.previewFontSize = function(){
		this.$previewNode.css( 'font-size' , this.$fontSizeNode.val() + this.$fontSizeNode.data( 'smof-typography-font-size-unit' )  );
	}
	
	this.previewLineHeight = function(){

		this.$previewNode.css( 'line-height' , this.$lineHeightNode.val() + this.$lineHeightNode.data( 'smof-typography-line-height-unit' ) );
	}
	
	this.previewColor = function( color ){
		var color = color ||  this.$colorNode.val();
		this.$previewNode.css( 'color' , color );
	}
	
	this.setEvents();
}

SmofFieldTypography.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-font-preview" ) ).each(function(index, value) {
		
		new SmofFieldTypography( jQuery( this ) );

	});
	
}

jQuery(function() {
	
	SmofEvents.register( 'SmofFieldTypography' );

});