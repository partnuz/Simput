<?php

namespace Simput\Fields\ImageSelect; class Field extends \Simput\Fields\ParentField\Field{

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
			'default' => ''
		) );
	}
	
	protected function assignNameSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ] =  array( $this -> args[ 'name_order' ] ) ;
			break;
		}
	
	}
	
	protected function assignIdSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':
				
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] ) ;
			break;
		}
	
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
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_enqueue_style( 'smof-field-image-select', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'imageSelect/field.css'  );
	
	
	}	
	public function enqueueScripts(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }

		wp_register_script( 'smof-field-image_select', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ImageSelect/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-image_select' );
	}

}

?>