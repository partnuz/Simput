<?php

namespace Simput\Fields\Container; 
class Field extends \Simput\Fields\ParentContainer\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'children',
		'category' => '',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => '',
			'depth' => false,
			'icon' => ''
		);
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options, $args );
	
	}
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$fields_views = array();
	
		foreach( $this -> fields as $field_id => $field ){
			
			$fields_views[ $field_id ] = $this -> obtainOutput( array( $field , 'controller' ) );
			
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();

	}

}

?>