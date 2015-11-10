<?php

namespace Simput\Fields\Sliderui;
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
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => 1,
			'range' => array( 
				'min' => 0,
				'max' => 1,
				'step' => 0
			),
			'edit' => 'readonly'
		) );
	}
	
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$view -> view();
		
	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_enqueue_style( 'smof-field-sliderui', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'sliderui/field.css'  );
	}
	
	public function enqueueScripts(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_register_script( 'smof-field-sliderui', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'sliderui/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-sliderui' );
	
	}

}

?>