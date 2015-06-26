(function ( $, window, document, undefined ) {
  'use strict';

  // adding alpha support for Automattic Color.js toString function.
  if( typeof Color.fn.toString !== undefined ) {

    Color.fn.toString = function () {

      // check for alpha
      if ( this._alpha < 1 ) {
        return this.toCSS('rgba', this._alpha).replace(/\s+/g, '');
      }

      var hex = parseInt( this._color, 10 ).toString( 16 );

      if ( this.error ) { return ''; }

      // maybe left pad it
      if ( hex.length < 6 ) {
        for (var i = 6 - hex.length - 1; i >= 0; i--) {
          hex = '0' + hex;
        }
      }

      return '#' + hex;

    };

  }

  $.cs_ParseColorValue = function( val ) {

    var value = val.replace(/\s+/g, ''),
        alpha = ( value.indexOf('rgba') !== -1 ) ? parseFloat( value.replace(/^.*,(.+)\)/, '$1') * 100 ) : 100,
        rgba  = ( alpha < 100 ) ? true : false;

    return { value: value, alpha: alpha, rgba: rgba };

  };

  $.fn.cs_wpColorPicker = function() {

    return this.each(function() {

      var $this = $(this);

      // check for rgba enabled/disable
      if( $this.data('rgba') !== false ) {

        // parse value
        var picker = $.cs_ParseColorValue( $this.val() );

        // wpColorPicker core
        $this.wpColorPicker({

          // wpColorPicker: change
          change: function( event, ui ) {
			  
			console.log( ui.color.toString() ); 

            // update checkerboard background color
            $this.closest('.wp-picker-container').find('.cs-alpha-slider-offset').css('background-color', ui.color.toString());
            $this.trigger('keyup');
			console.log( 'cs_wpColorPicker' );
			$this.trigger( 'custom' , [ ui.color.toString() ] );
			/*
			throttle( );
			*/

          },

          // wpColorPicker: create
          create: function( event, ui ) {

            // set variables for alpha slider
            var a8cIris       = $this.data('a8cIris'),
                $container    = $this.closest('.wp-picker-container'),

                // appending alpha wrapper
                $alpha_wrap   = $('<div class="cs-alpha-wrap">' +
                                  '<div class="cs-alpha-slider"></div>' +
                                  '<div class="cs-alpha-slider-offset"></div>' +
                                  '<div class="cs-alpha-text"></div>' +
                                  '</div>').appendTo( $container.find('.wp-picker-holder') ),

                $alpha_slider = $alpha_wrap.find('.cs-alpha-slider'),
                $alpha_text   = $alpha_wrap.find('.cs-alpha-text'),
                $alpha_offset = $alpha_wrap.find('.cs-alpha-slider-offset');

            // alpha slider
            $alpha_slider.slider({

              // slider: slide
              slide: function( event, ui ) {

                var slide_value = parseFloat( ui.value / 100 );

                // update iris data alpha && wpColorPicker color option && alpha text
                a8cIris._color._alpha = slide_value;
                $this.wpColorPicker( 'color', a8cIris._color.toString() );
                $alpha_text.text( ( slide_value < 1 ? slide_value : '' ) );

              },

              // slider: create
              create: function() {

                var slide_value = parseFloat( picker.alpha / 100 ),
                    alpha_text_value = slide_value < 1 ? slide_value : '';

                // update alpha text && checkerboard background color
                $alpha_text.text(alpha_text_value);
                $alpha_offset.css('background-color', picker.value);

                // wpColorPicker clear button for update iris data alpha && alpha text && slider color option
                $container.on('click', '.wp-picker-clear', function() {

                  a8cIris._color._alpha = 1;
                  $alpha_text.text('');
                  $alpha_slider.slider('option', 'value', 100).trigger('slide');

                });

                // wpColorPicker default button for update iris data alpha && alpha text && slider color option
                $container.on('click', '.wp-picker-default', function() {

                  var default_picker = $.cs_ParseColorValue( $this.data('default-color') ),
                      default_value  = parseFloat( default_picker.alpha / 100 ),
                      default_text   = default_value < 1 ? default_value : '';

                  a8cIris._color._alpha = default_value;
                  $alpha_text.text(default_text);
                  $alpha_slider.slider('option', 'value', default_picker.alpha).trigger('slide');

                });

                // show alpha wrapper on click color picker button
                $container.on('click', '.wp-color-result', function() {
                  $alpha_wrap.toggle();
                });

                // hide alpha wrapper on click body
                $('body').on( 'click.wpcolorpicker', function() {
                  $alpha_wrap.hide();
                });

              },

              // slider: options
              value: picker.alpha,
              step: 1,
              min: 1,
              max: 100

            });
          }

        });

      } else {

        // wpColorPicker default picker
        $this.wpColorPicker({
          change: function() {
            $this.trigger('keyup');
          }
        });

      }

    });

  };

  $(document).ready( function(){
    $('.cs-wp-color-picker').cs_wpColorPicker({

	});
  });

})( jQuery, window, document );

var SmofColor = function(){
	
}

SmofColor.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "cs-wp-color-picker" ) ).cs_wpColorPicker({

	});


}

jQuery( function(){
	
	SmofEvents.register( 'SmofColor' );

});

  	
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
	SmofCombobox.addEvent();

});

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
	
	jQuery( prefix.getElementsByClassName( "smof-container-image_select" ) ).each(function(index, value) {
		
		new SmofImageSelect( jQuery( this ) );

	});
	
}

jQuery( function(){
	
	SmofEvents.register( 'SmofImageSelect' );
	SmofImageSelect.addEvent();

});
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
	

	this.addEventsToNewItem = function(){
		
		SmofEvents.addEvent( this.$newItem );
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
		
		this.addEventsToNewItem();

	}
	
	this.newItemAppend = function(){
		this.$newItem = this.$patternItemClone.appendTo( this.$patternItemNode.parent( 'ul' ) ).get(0);
		console.log( this.$newItem );
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
	
	console.log( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-repeatable" ) ).each(function(index, value) {
		
		new SmofRepeatable( jQuery( this ) );

	});
	
}

jQuery(function(){
	SmofEvents.register( 'SmofRepeatable' );
	SmofRepeatable.addEvent();

});
var SmofSliderui = function(){
	
}

SmofSliderui.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-sliderui" ) ).each(function(index, value) {
		
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
	SmofEvents.register( 'SmofSliderui' );
	SmofSliderui.addEvent();

});
var SmofSwitcher = function( $parent ){
	
	this.$parent = $parent;
	var obj = this;
	this.$parent.find(".smof-field-switch-enable").click(function(){


		jQuery('.smof-field-switch-disable', obj.$parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.smof-field-switch-checkbox', obj.$parent).attr('checked', true);
		
		//fold/unfold related options
		var current = jQuery(this);
		var $fold='.f_'+current.data('id');
		jQuery($fold).slideDown('normal', "swing");
		
	});
	this.$parent.find(".smof-field-switch-disable").click(function(){
		
		var parent = jQuery(this).parents('.smof-container-switch');
		jQuery('.smof-field-switch-enable',obj.$parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.smof-field-switch-checkbox',obj.$parent).attr('checked', false);
		
		//fold/unfold related options
		var current = jQuery(this);
		var $fold='.f_'+current.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});
} 
/**
  * Switch
  * Dependencies 	 : jquery
  * Feature added by : Smartik - http://smartik.ws/
  * Date 			 : 03.17.2013
  */
  
SmofSwitcher.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-container-switcher" ) ).each(function(index, value) {
		
		new SmofSwitcher( jQuery( this ) );

	});
	
}

jQuery(function() {
	SmofEvents.register( 'SmofSwitcher' );
	SmofSwitcher.addEvent();

});



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
	SmofFieldTypography.addEvent();

});
var SmofUpload = function( $parent ){
	
	var obj = this;
	this.$parent = $parent;
	
	this.addFile = function( event ){
		
		var upload = jQuery(".uploaded-file"), frame;
		var jQueryel = jQuery(this);

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( frame ) {
			frame.open();
			return;
		}

		// Create the media frame.
		frame = wp.media({
			// Set the title of the modal.
			title: jQueryel.data('choose'),
			/* add this in future
			frame: 'post',
			*/

			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: jQueryel.data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: false
			}
		});

		// When an image is selected, run a callback.
		frame.on( 'select', function() {
			// Grab the selected attachment.
			var attachment = frame.state().get('selection').first();
			frame.close();
			obj.$parent.find('.smof-field-upload-url').val(attachment.attributes.url);
			obj.$parent.find('.smof-field-upload-id').val(attachment.attributes.id);
			
			obj.$parent.find('.smof-field-upload-width').val('');
			obj.$parent.find('.smof-field-upload-height').val('');
			
			obj.$parent.find('.smof-field-upload-size-thumbnail').val('');
			obj.$parent.find('.smof-field-upload-size-medium').val('');
			
			if (typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.thumbnail !== 'undefined') {
				screenshotUrl = attachment.attributes.sizes.thumbnail.url;
				obj.$parent.find('.smof-field-upload-width').val( attachment.attributes.width );
				obj.$parent.find('.smof-field-upload-height').val( attachment.attributes.height );
			} else if ( typeof attachment.attributes.sizes !== 'undefined' ) {
				var height = attachment.attributes.height;
				for (var key in attachment.attributes.sizes) {
					var object = attachment.attributes.sizes[key];
					if (object.height < height) {
						height = object.height;
						screenshotUrl = object.url;
					}
				}
			} else {
				screenshotUrl = attachment.attributes.icon;
			}
			

			if( typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.thumbnail !== 'undefined' ){
				obj.$parent.find('.smof-field-upload-size-thumbnail').val( attachment.attributes.sizes.thumbnail.url );
			}
			
			if( typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.medium !== 'undefined' ){
				obj.$parent.find('.smof-field-upload-size-medium').val( attachment.attributes.sizes.medium.url );
			}

			if( screenshotUrl !== '' ){
			
				obj.$parent.find('.smof-field-upload-screenshot').empty().hide().append('<img src="' + screenshotUrl + '">').slideDown('fast');
			}

			obj.$parent.find('.smof-field-upload-remove-url').show().removeClass('hide');//show "Remove" button

		});

		// Finally, open the modal.
		frame.open();
		
	}
	
	this.removeFile = function(){
		
		this.$parent.find('.smof-field-upload-remove-url').hide().addClass('hide');//hide "Remove" button
		this.$parent.find('.smof-field-upload-url').val('');
		this.$parent.find('.smof-field-upload-id').val('');
		this.$parent.find('.smof-field-upload-width').val('');
		this.$parent.find('.smof-field-upload-height').val('');
		this.$parent.find('.smof-field-upload-screenshot').slideUp();
		
	}
	
	this.addEvents = function(){

		this.$parent.find( '.smof-field-upload-remove-url').on('click', function(){
			
			obj.removeFile( );
			
		});
		
		this.$parent.find('.smof-field-upload-upload-button').unbind('click').click( function( event ) {
			
			obj.addFile( event );
			
		});
		
	}
	
	this.addEvents();
}

SmofUpload.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( prefix.getElementsByClassName( "smof-container-upload" ) ).each(function(index, value) {
		
		new SmofUpload( jQuery( this ) );

	});
	
}

jQuery(function() {

	SmofEvents.register( 'SmofUpload' );
	SmofUpload.addEvent();

});