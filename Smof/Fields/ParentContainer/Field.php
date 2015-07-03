<?php

namespace Smof\Fields\ParentContainer; 
abstract class Field extends \Smof\Fields\ParentField\Field{
	
	protected $meta_data = array();
	
	public function appendMetaData( $data ){
		
		array_push( $this -> meta_data , $data );

	}
	
	public function getMetaData(  ){
		
		return $this -> meta_data;
	}
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'validate' => array()
		) );
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions(
		$this -> options[ 'fields' ] , 
		$this -> data,
		array( 
			'subframework' => $this -> args[ 'subframework' ],
			'parent_class' => $this

		) 
		
		);
	
	}
	
	public function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	public function obtainData(){
		return $this -> getCreate() -> obtainFieldsData( $this -> fields );
	}
	


}

?>