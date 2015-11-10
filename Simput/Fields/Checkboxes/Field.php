<?php

namespace Simput\Fields\Checkboxes;
class Field extends \Simput\Fields\ParentMulti\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => array(),
			'type' => 'checkboxes'
		) );
	}
	
	public function validateData(){
		
		if( $this -> options[ 'validate' ] && $this -> data ){
			
			$validate = new \Smof\Validation();
		
			foreach( $this -> data as $field_key => $field ){
					
				$results[ $field_key ] = $validate -> validate( array( 'data' => $this -> data[ $field_key ]  , 'conditions' => $this -> options[ 'validate' ] ) );
						
			}
			
			if( !empty( $results ) ){
				$this -> validation_results = $results;
				$this -> data = $this -> options[ 'default' ];
			}
	
		}
		
		
	}
	
	public function setData( $data ){
		

		if( is_array( $data ) ){ 
			
			$this -> data = $data;

		}elseif( $data === '' ){
			
			$this -> data = array();
			
		}else{
		
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	public function obtainData(){
		
		return array( $this -> options[ 'id' ] => $this -> data );
	}

	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		
		$name_suffixes = array();
		
		foreach( $this -> options[ 'options' ] as $field_name => $field_value ){
			
			$name_suffixes[ $field_name ] = $this -> subframework -> getFieldName( array_merge( $this -> args[ 'name' ] , array( $field_name ) ) ) ;
			
		}
		
		$view -> setData( 'name_suffixes' , $name_suffixes );
		
		$view -> view();

	}

}

?>