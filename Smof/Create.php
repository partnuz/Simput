<?php
namespace Smof;
class Create{
	
	protected $framework;
	protected $subframework;
	
	function __construct( array $args ){
		$this -> setArgs( $args );
	}
	
	protected function setArgs( array $args ){
		
		$this -> args = $args;
		$this -> framework = $this -> args[ 'framework' ];
		$this -> subframework = $this -> args[ 'subframework' ];

		
	}
	
	private function createField( $class_name , $data, $options, $args = array() ){
		
		if( class_exists( $class_name ) ){
			
			$field = new $class_name( $options, $args );
			
			if( $field -> getOutput() ){

				$field -> setData( $data );
				$field -> initiateFields();
				
				return $field;
			}
			
		}
	}
	
	public function createFieldFromOptions( $data, $options, $args = array() ){
		
		if( $class_name = $this -> fieldClassName( $options[ 'type' ] ) ){
			return $this -> createField( $class_name , $data, $options, $args );
		}
		
	}
	
	public function fieldClassName( $field_slug ){
		
		$field_name = __NAMESPACE__ .'\\Fields\\' . $this -> framework -> underscore2Camelcase( $field_slug ). '\\Field' ;
		
		return ( class_exists( $field_name ) ? $field_name : false );
	}
	
	public function fieldsView( $fields ){
		if( !is_array( $fields ) ){
			return;
		}
		foreach( $fields as $field ){
			$field -> controller();
		}
	}
	
	public function fieldsValidate( array $fields ){

		foreach( $fields as $field ){
			
			$field -> validateData();

		}

	}
	
	public function obtainFieldsData( array $fields ){
		$data = array();
		foreach( $fields as $field ){

			$field_data = $field -> obtainData();
			
			if( is_array( $field_data ) ){
				$data = array_merge_recursive( $data , $field_data );
			}
		}
		return $data;
	}
	
	public function createFieldsFromOptions( array $options , $data , $args = false ){
	
		$fields = array();
		
		if( $args === false ){
			$args = array( 'view' => $this -> subframework -> view , 'subframework' => $this -> subframework );
		}
		
		foreach ( $options as $option ){
			
			$field_properties = $this -> framework -> setFieldProperties( $option[ 'type' ]);
			
			if( $field_properties === false){
				continue;
			}
			
			if( $field_properties[ 'inheritance' ] === 'children' ){
				$field_data = $data;
			}else{

				
				$field_data = ( !isset( $data[ $option[ 'id' ] ] ) ) ? null  : $data[ $option[ 'id' ] ];
				
			}
			
			$field = $this -> createFieldFromOptions( $field_data , $option , $args );
			if( is_object( $field ) ){
				$fields[] = $field;
			}

		}
		
		return $fields;	
	}
	
}


?>