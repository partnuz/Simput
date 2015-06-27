/**
 * SMOF js
 *
 * contains the core functionalities to be used
 * inside SMOF
 */

jQuery.noConflict();

/** Fire up jQuery - let's dance! 
 */
 
jQuery(window).load(function(){
  //your code here

	var $ = jQuery;
	
	var smofOptionsPanel = new SmofEvents();
	
	$( "#of_container #main" ).tabs(
		{
			active : window.sessionStorage.getItem( 'of_container') || 0,
			// Triggered after a tab has been activated
			activate : function( event, ui ){
				
				//  Get future value
				var newIndex = ui.newTab.parent().children().index( ui.newTab );
				//  Set future value
				window.sessionStorage.setItem( 'of_container', newIndex );
				if( smofOptionsPanel.loadSection( newIndex ) ){
					SmofEvents.addEvent( ui.newTab.find( 'a.ui-tabs-anchor' ).attr( 'href' ) );
				}
				/*

				*/
			},
			create: function( event , ui ){
				var newIndex = ui.tab.parent().children().index( ui.tab );
				if( smofOptionsPanel.loadSection( newIndex ) ){
					console.log( ui.tab.find( 'a.ui-tabs-anchor' ).attr( 'href' ) );
					SmofEvents.addEvent( ui.tab.find( 'a.ui-tabs-anchor' ).attr( 'href' ) );
				}
				
			}
		}
	);
	
	/*
	//(un)fold options in a checkbox-group
  	jQuery('.fld').click(function() {
    	var $fold='.f_'+this.id;
    	$($fold).slideToggle('normal', "swing");
  	});

	
	//hides warning if js is enabled			
	$('#js-warning').hide();

	//Expand Options 
	var flip = 0;
				
	$('#expand_options').click(function(){
		if(flip == 0){
			flip = 1;
			$('#of_container #of-nav').hide();
			$('#of_container #content').width(755);
			$('#of_container .smof-container-section').add('#of_container .smof-container-section h2').show();
	
			$(this).removeClass('expand');
			$(this).addClass('close');
			$(this).text('Close');
					
		} else {
			flip = 0;
			$('#of_container #of-nav').show();
			$('#of_container #content').width(595);
			$('#of_container .smof-container-section').add('#of_container .smof-container-section h2').hide();
			$('#of_container .smof-container-section:first').show();
			$('#of_container #of-nav li').removeClass('current');
			$('#of_container #of-nav li:first').addClass('current');
					
			$(this).removeClass('close');
			$(this).addClass('expand');
			$(this).text('Expand');
				
		}
			
	});
	
	//Update Message popup
	$.fn.center = function () {
		this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
		this.css("left", 250 );
		return this;
	}
		
			
	$('#of-popup-save').center();
	$('#of-popup-reset').center();
	$('#of-popup-fail').center();
			
	$(window).scroll(function() { 
		$('#of-popup-save').center();
		$('#of-popup-reset').center();
		$('#of-popup-fail').center();
	});
			

	//Masked Inputs (images as radio buttons)
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	//Masked Inputs (background images as radio buttons)
	$('.of-radio-tile-img').click(function(){
		$(this).parent().parent().find('.of-radio-tile-img').removeClass('of-radio-tile-selected');
		$(this).addClass('of-radio-tile-selected');
	});
	$('.of-radio-tile-label').hide();
	$('.of-radio-tile-img').show();
	$('.of-radio-tile-radio').hide();
	*/

	

	/**	Tipsy @since v1.3 
	if (jQuery().tipsy) {
		$('.typography-size, .typography-height, .typography-face, .typography-style, .of-typography-color').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7,
		});
	}
	
	*/
	
});