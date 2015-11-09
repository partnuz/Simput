<?php

namespace Simput\Fields\Combobox; 
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'options' => array(),
			'multiple_data_sources' => false,
			
		) );
	}
	
	protected function varNameToJsVarName( $name ){

		return str_replace( '-'  , '$', $name );
		
	}
	protected function varToJsVar( $name , $val ){
		return 'var ' . $this -> varNameToJsVarName( $name ) . '=' . $val . ';';
	}
	
	public function encodeOptionsToJson(){
		
		if( is_array( $this -> options[ 'options' ] ) ){
			
			// data sources
			if( $this -> options[ 'multiple_data_sources' ] ) {
				
				foreach( $this -> options[ 'options' ] as $name => $options ){ 
					
					if( !$this -> framework -> dataSourceExists( $name ) ){
						
						if( is_array( $options ) ){
							$this -> options_converted[ $name ] = json_encode( $options );
						}else{
							
							$this -> options_converted[ $name ] = $options;
							
						}
						
					}
					
					$this -> data_source_names[] = $this -> varNameToJsVarName( $name );
				
				}
				
				$this -> data_source_names = json_encode( $this -> data_source_names );
				
			}else{
				$this -> data_source_names = json_encode( array( $this -> varNameToJsVarName( $this -> subframework -> getFieldId( $this -> args[ 'id' ] ) ) ) );
				if( is_array( $this -> options[ 'options' ] ) ){
					
					$this -> options_converted = json_encode( array_values( $this -> options[ 'options' ] ) );
					
				}else{
					$this -> options_converted = $this -> options[ 'options' ];
				}
				
			}

		}
	}
	
	public function addOptionsToExternalSource(){
		
		// data sources
		if( $this -> options[ 'multiple_data_sources' ] && is_array( $this -> options[ 'options' ]  ) ) {

			foreach( $this -> options_converted as $name => $options ){
				
				$this -> addPrintScriptsContent( $this -> varToJsVar( $name , $options ) );
			
			}
			
			
		}else{
			
			
			$this -> addPrintScriptsContent( $this -> varToJsVar( $this -> subframework -> getFieldId( $this -> args[ 'id' ] ) , $this -> options_converted ) );
			
		}

	}
	
	public function controller(){
		
		$this -> encodeOptionsToJson();
		
		$this -> addOptionsToExternalSource();
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'data_source_names' => $this -> data_source_names,
					'field_class' => $this -> obtainFieldClass()
				) 
			) 
		);
		
		$view -> view();

	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_enqueue_style( 'smof-field-combobox', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'combobox/field.css' )  ;
	
	}
	
	public function enqueueScripts(){
		 
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-dialog' );	
		wp_enqueue_script( 'jquery-ui-tooltip' );		
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_register_script( 'smof-field-combobox', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'combobox/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-combobox' );
	
	}

}

?>