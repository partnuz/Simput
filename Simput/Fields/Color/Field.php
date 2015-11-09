<?php

namespace Simput\Fields\Color;
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);

	public $editor_options;
	public $default_options = array(

			
	);

	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'type' => 'color'
		) );
	}
	
	
	public function controller(){
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'field_class' => $this -> obtainFieldClass()
				) 
			) 
		);
		
		$view -> view();
	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'wp-color-picker' );
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_enqueue_style( 'smof-field-color', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'color/field.css' )  ;
	}
	
	function enqueueScripts(){
	
		wp_enqueue_script( 'wp-color-picker' );
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_register_script( 'smof-field-color', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'color/script.js', array( 'jquery' , 'wp-color-picker' ) );
		wp_enqueue_script( 'smof-field-color' );
	}

}

?>