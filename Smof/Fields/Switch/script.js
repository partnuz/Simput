var SmofSwitch = function( $parent ){
	
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
  
SmofSwitch.addEvent = function( prefix ){
	
	prefix = SmofEvents.getPrefix( prefix );
	
	jQuery( document.getElementsByTagName('html')[0].getElementsByClassName( "smof-container-switch" ) ).each(function(index, value) {
		
		new SmofSwitch( jQuery( this ) );

	});
	
}

jQuery(function() {

	SmofSwitch.addEvent();

});

