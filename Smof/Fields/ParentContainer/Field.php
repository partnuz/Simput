<?php

namespace Smof\Fields\ParentContainer; 
abstract class Field extends \Smof\Fields\ParentField\Field{
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'validate' => array()
		) );
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data );
	
	}
	
	public function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	public function obtainData(){
		return $this -> getCreate() -> obtainFieldsData( $this -> fields );
	}
	


}

?>