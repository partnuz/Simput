<?php

class Smof_Fields_Color_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);

	public $editor_options;
	public $default_options = array(

			
	);

	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'type' => 'color'
		) );
	}
	
	
	function bodyView(){
		
		$this -> viewValidationResult();
	
		?>

			<input "<?php $this -> viewName(); ?> class="smof-field-color cs-wp-color-picker <?php echo $this -> formFieldClass(); ?>"  type="text" value="<?php echo esc_attr( $this -> data ); ?>" <?php if( !empty( $this -> options[ 'default' ] ) && empty( $this -> data ) ){?>data-default-color=<?php echo $this -> options[ 'default' ]; }; ?> />
				
		<?php
	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'smof-field-color', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'color/field.css' )  ;
	}
	
	function enqueueScripts(){
	
		wp_enqueue_script( 'wp-color-picker' );
		
		wp_register_script( 'smof-field-color', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'color/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-color' );
	}

}

?>