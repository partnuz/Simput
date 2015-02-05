	/**
	  * Switch
	  * Dependencies 	 : jquery
	  * Feature added by : Smartik - http://smartik.ws/
	  * Date 			 : 03.17.2013
	  */
	jQuery(".smof-field-switch-enable").click(function(){

		var parent = jQuery(this).parents('.smof-container-switch');
		jQuery('.smof-field-switch-disable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.smof-field-switch-checkbox',parent).attr('checked', true);
		
		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideDown('normal', "swing");
	});
	jQuery(".smof-field-switch-disable").click(function(){
		var parent = jQuery(this).parents('.smof-container-switch');
		jQuery('.smof-field-switch-enable',parent).removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('.smof-field-switch-checkbox',parent).attr('checked', false);
		
		//fold/unfold related options
		var obj = jQuery(this);
		var $fold='.f_'+obj.data('id');
		jQuery($fold).slideUp('normal', "swing");
	});
