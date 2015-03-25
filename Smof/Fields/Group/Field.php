<?php

class Smof_Fields_Group_Field extends Smof_Fields_ParentMulti_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => false
		),
		'inheritance' => 'parent_children',
		'category' => 'multiple'
	);
	
	function __construct( $options , array $args ){
		parent :: __construct( $options, $args );
		$this -> childFieldsModeNotRepeatable();
	}
	
	// args passed to field cannot be repeatable
	protected function childFieldsModeNotRepeatable(){
		$this -> args[ 'mode' ] = 'nonrepeatable';
	}
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => array()
		);
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data , $this -> args );
		
	}
	
	public function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	
	function bodyView(){
		
		$this -> getCreate() -> fieldsView( $this -> fields );
			
	}

}

?>