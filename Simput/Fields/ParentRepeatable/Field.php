<?php

namespace Simput\Fields\ParentRepeatable;
abstract class Field extends \Simput\Fields\ParentField\Field{

	public function setData( $data ){
	
		if( $data !== null && ( is_array( $data ) && !empty( $data ) && isset( $data[ 0 ] ) ) ){
			
			$default_pattern = ( isset( $this -> options[ 'default' ] ) ) ? $this -> options[ 'default' ] : null ;
			
			foreach( $data as $data_key => $data_val ){

				if( is_array( $data_val ) && is_array( $default_pattern ) && $default_pattern !== null ){
					$this -> data[ $data_key ] = array_replace_recursive(  $default_pattern , $data_val );

				}else{
					$this -> data[ $data_key ] = $data_val;
				}
				
			}
			
		}else{

			$this -> data = array();
		}

	}
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'toggle' => false
		) );
	}
	
	public function validateData(){
		foreach( $this -> data as $data_key => $data_val ){
		
			if( is_array( $this -> options[ 'validate' ] ) && array_filter( $this -> options[ 'validate' ] ) ){
		
				$validate = new \Smof\Validation();
				
				if( $this -> fields ){
					
					$this -> getCreate() -> fieldsValidate( $this -> fields[ $data_key ] );
					
				}else{
					
						foreach( $this -> options[ 'validate' ] as $validation_item => $validate_option ){
						
							$results = $validate -> validate( array( 'data' => $this -> data[ $data_key ][ $validation_item ]  , 'conditions' => $this -> options[ 'validate' ][ $validation_item ] ) );
							
							if( !empty( $results ) ){
								$this -> validationResults[ $data_key ][ $validation_item ] = $results;
								$this -> data[ $data_key ][ $validation_item ] = $this -> options[ 'default' ][ $validation_item ] ;
							}
							
						}
					
				}
			
			}
		}
	}
	
	public function obtainData(){
		
		if( $this -> fields ){
			
			foreach( $this -> fields as $field_key => $fields ){
				
				$this -> data[ $field_key ] = $this -> getCreate() -> obtainFieldsData( $fields );
			}
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $data );
			
		}else{
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
			
		}
		
	}
	
	
	// suffix is NOT FULL for this type of fields
	protected function assignNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
	
	}
	
	// suffix is NOT FULL for this type of fields
	protected function assignIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
	
	}

	

	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_enqueue_style( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ParentRepeatable/field.css' )  ;
	
	}
	
	public function enqueueScripts(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_register_script( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ParentRepeatable/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-parent_repeatable' );
	
	}
	
}

?>