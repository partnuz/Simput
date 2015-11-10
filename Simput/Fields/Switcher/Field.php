<?php

namespace Simput\Fields\Switcher;
class Field extends \Simput\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'default' => 0,
			'options' => array( 
				'on' => __( 'On' , 'smof'),
				'off' => __( 'Off' , 'smof' )
			)
		) );
	}
	
	public function controller(){
		
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$view -> view();
	
	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_enqueue_style( 'smof-field-switcher', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'switcher/field.css'  );
	}
	
	public function enqueueScripts(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_register_script( 'smof-field-switcher', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'switcher/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-switcher' );
	
	}

}

?>