/* 
-------------------------------------------------*/
function adwf_add_file(event, selector) {

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
		selector.find('.smof-field-upload-url').val(attachment.attributes.url);
		selector.find('.smof-field-upload-id').val(attachment.attributes.id);
		
		selector.find('.smof-field-upload-width').val('');
		selector.find('.smof-field-upload-height').val('');
		
		selector.find('.smof-field-upload-sizes-thumbnail').val('');
		selector.find('.smof-field-upload-sizes-medium').val('');
		
		if (typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.thumbnail !== 'undefined') {
			screenshotUrl = attachment.attributes.sizes.thumbnail.url;
			selector.find('.smof-field-upload-width').val( attachment.attributes.width );
			selector.find('.smof-field-upload-height').val( attachment.attributes.height );
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
			selector.find('.smof-field-upload-sizes-thumbnail').val( attachment.attributes.sizes.thumbnail.url );
		}
		
		if( typeof attachment.attributes.sizes !== 'undefined' && typeof attachment.attributes.sizes.medium !== 'undefined' ){
			selector.find('.smof-field-upload-sizes-medium').val( attachment.attributes.sizes.medium.url );
		}

		if( screenshotUrl !== '' ){
		
			selector.find('.smof-field-upload-screenshot').empty().hide().append('<img src="' + screenshotUrl + '">').slideDown('fast');
		}
		selector.find('.smof-field-upload-upload-button').unbind();
		selector.find('.smof-field-upload-remove-url').show().removeClass('hide');//show "Remove" button
		adwf_file_bindings();
	});

	// Finally, open the modal.
	frame.open();
}

function adwf_remove_file(selector) {
	selector.find('.smof-field-upload-remove-url').hide().addClass('hide');//hide "Remove" button
	selector.find('.smof-field-upload-url').val('');
	selector.find('.smof-field-upload-id').val('');
	selector.find('.smof-field-upload-width').val('');
	selector.find('.smof-field-upload-height').val('');
	selector.find('.smof-field-upload-screenshot').slideUp();
	/* selector.find('.remove-file').unbind(); */
	adwf_file_bindings();
}

function adwf_file_bindings( container ) {

	if( container !== undefined ){
		container += ' ';
	}else{
		container = '';
	}

	jQuery( container + '.smof-field-upload-remove-url').on('click', function() {
		adwf_remove_file( jQuery(this).parents('.smof-container-upload') );
	});
	jQuery( container + '.smof-field-upload-upload-button').unbind('click').click( function( event ) {
		
		adwf_add_file(event, jQuery(this).parents('.smof-container-upload'));
	});
}

jQuery(document).ready(function($){
    
    adwf_file_bindings();

});