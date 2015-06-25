<?php

abstract class Smof_Fields_ParentContainer_Field extends Smof_Fields_Parent_Field{
	
	protected function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() , array(
			'validate' => array()
		) );
	}
	
	function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data );
	
	}
	
	function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	function obtainData(){
		return $this -> getCreate() -> fieldsSave( $this -> fields );
	}
	


}

?>