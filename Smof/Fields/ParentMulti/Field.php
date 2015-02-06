<?php

abstract class Smof_Fields_ParentMulti_Field extends Smof_Fields_Parent_Field{

	// suffix is NOT FULL for this type of fields
	function setNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ][] =  $this -> args[ 'name_order' ] ;
			break;
		}
	
	}
	
	// suffix is NOT FULL for this type of fields
	function setIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				
			break;
			case 'repeatable':
					
				$this -> args[ 'id_suffix' ][] = $this -> args[ 'name_order' ] ;
			break;
		}
	
	}
	
	function setData( $data ){
	
		if( !empty( $data ) ){ 

			$this -> data = array_replace_recursive( $this -> options[ 'default' ] , $data );
			
		}else{
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	public function validateData(){
		if( !empty( $this -> options[ 'validate' ] ) ){
		
			$validate = new Smof_Validation();
			foreach( $this -> options[ 'validate' ] as $validation_item => $validate_option ){
			
				$results = $validate -> validate( array( 'data' => $this -> data[ $validation_item ]  , 'conditions' => $this -> options[ 'validate' ][ $validation_item ] ) );
				
				if( !empty( $results ) ){
					$this -> validationResults[ $validation_item ] = $results;
					$this -> data[ $validation_item ] = $this -> options[ 'default' ][ $validation_item ] ;
				}
				
			}
			
		}
	}

}

?>