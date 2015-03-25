<?php

abstract class Smof_Fields_ParentMulti_Field extends Smof_Fields_Parent_Field{

	// suffix is NOT FULL for this type of fields
	function assignNameSuffix(){
		
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
	function assignIdSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':
					
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] ) ;
			break;
		}
	
	}
	
	function assignData( $data ){
	
		if( !empty( $data ) ){ 

			$this -> data = array_replace_recursive( $this -> options[ 'default' ] , $data );
			
		}else{
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	public function validateData(){

		if( $this -> options[ 'validate' ] ){
			
			$validate = new Smof_Validation();
			
			if( $this -> fields ){
				$this -> getCreate() -> fieldsValidate( $this -> fields );
			}else{
				
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
	
	function obtainData(){
		
		if( $this -> fields ){
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> getCreate() -> fieldsSave( $this -> fields ) );
			
		}else{
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
			
		}
		

		
	}

}

?>