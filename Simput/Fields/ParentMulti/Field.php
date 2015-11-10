<?php

namespace Simput\Fields\ParentMulti;
abstract class Field extends \Simput\Fields\ParentField\Field{
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'validate' => array()
		) );
	}

	// suffix is NOT FULL for this type of fields
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
	
	// suffix is NOT FULL for this type of fields
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
	
	public function setData( $data ){
	
		if( is_array( $data ) ){ 

			$this -> data = array_replace_recursive( $this -> options[ 'default' ] , $data );
			
		}else{
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	public function validateData(){

		if( array_filter( $this -> options[ 'validate' ] ) ){
			
			if( $this -> fields ){
				$this -> getCreate() -> fieldsValidate( $this -> fields );
			}else{
				
				$validate = new \Smof\Validation();
				
				foreach( $this -> options[ 'validate' ] as $validation_item => $validate_option ){
					
					if( !$validate_option ){ continue; }
				
					$results = $validate -> validate( array( 'data' => $this -> data[ $validation_item ]  , 'conditions' => $this -> options[ 'validate' ][ $validation_item ] ) );
					
					if( !empty( $results ) ){
						$this -> validationResults[ $validation_item ] = $results;
						$this -> data[ $validation_item ] = $this -> options[ 'default' ][ $validation_item ] ;
					}
					
				}
			}
		}

	}
	
	public function obtainData(){
		
		if( $this -> fields ){
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> getCreate() -> obtainFieldsData( $this -> fields ) );
			
		}else{
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
			
		}
		
	}
	
	public function viewValidationResults( $field_id ){
		
		if( !$this -> fields ){
					
			if( !empty( $this -> validation_results[ $field_id ] ) ) {

				var_dump( $this -> validation_results[ $field_id ] );
				
			}
			
		}

	}

}

?>