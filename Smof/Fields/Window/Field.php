<?php

class Smof_Fields_Window_Field extends Smof_Fields_ParentContainer_Field{

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
	
	function view(){

		$this -> getCreate() -> fieldsView( $this -> fields );

	}

}

?>