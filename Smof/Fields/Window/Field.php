<?php

class Smof_Fields_Window_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'children',
		'category' => ''
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => '',
			'depth' => false,
			'icon' => ''
		);
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options, $args );
	
	}
	
	function assignData( $data ){
	
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> args[ 'subframework' ] -> fieldLoopInitiate( $this -> options[ 'fields' ] );
	
	}
	
	public function validateData(){
		
		$this -> data = $this -> args[ 'subframework' ] -> fieldLoopValidate( $this -> fields );
	}
	
	public function obtainData(){
		return $this -> args[ 'subframework' ] -> fieldLoopSave( $this -> fields );
	}
	
	function view(){

		$this -> args[ 'subframework' ] -> fieldLoopView( $this -> fields );

	}

}

?>