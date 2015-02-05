<?php

class Smof_Fields_Switch_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => 0,
			'text' => array( 
				'on' => __( 'On' , 'smof'),
				'off' => __( 'Off' , 'smof' )
			)
		);
	}
	
	function bodyView(){
	
		/*
		$fold = '';
		if (array_key_exists("folds",$value)) $fold="s_fld ";
		*/
		?>
		<p class="switch-options">

		<label class="smof-field-switch-enable <?php if(  $this -> data == 1 ){?>selected<?php }; ?>" data-id="<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>"><span><?php echo $this -> options[ 'text' ][ 'on' ]; ?></span></label>
		<label class="smof-field-switch-disable <?php if(  $this -> data == 0 ){?>selected<?php }; ?>" data-id="<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>"><span><?php echo $this -> options[ 'text' ][ 'off' ]; ?></span></label>
		
		<input type="hidden" class="smof-field-checkbox" name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" value="0"/>
		<input type="checkbox" id="smof-field<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>"  class="smof-field-checkbox smof-field-switch-checkbox" name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>"  value="1" <?php checked( $this -> data, 1 ); ?> />
		
		</p>
			
		<?php
	}
	
	function enqueueStyles(){
		wp_enqueue_style( 'smof-field-switch', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'switch/field.css'  );
	}
	
	function enqueueScripts(){
	
		wp_register_script( 'smof-field-switch', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'switch/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-switch' );
	
	}

}

?>