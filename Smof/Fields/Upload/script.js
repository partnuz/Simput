/* 
-------------------------------------------------*/

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