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
		$this -> argsModeNotRepeatable();
		$this -> initiateFields();
	}
	
	protected function argsModeNotRepeatable(){
		$this -> args[ 'mode' ] = 'nonrepeatable';
	}
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => array()
		);
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> args[ 'subframework' ] -> fieldLoopInitiate( $this -> options[ 'fields' ] , $this -> data , $this -> args );
		
	}
	
	public function validateData(){
		
		$this -> data = $this -> args[ 'subframework' ] -> fieldLoopValidate( $this -> fields );
	}
	
	
	function bodyView(){
	
			$this -> args[ 'subframework' ] -> fieldLoopView( $this -> fields );
			
	}

}

?>