<?php

namespace Simput\Fields\Section;
class Field extends \Smof\Fields\ParentContainer\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'children',
		'category' => '',
		'custom' => false
	);

	public $view;
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'depth' => false,
			'icon' => ''
		) );
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options, $args );
	
	}
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$this -> parent_field -> appendMetaData( array( 
			'id' => $this -> options[ 'id' ] ,
			'title' => $this -> options[ 'title' ],
			'icon' => $this -> options[ 'icon' ]
		) );
		
		$fields_views = array();
		
		foreach( $this -> fields as $field ){
			
			$fields_views[] = $this -> obtainOutput( array( $field , 'controller' ) ) ;
				
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();
		

	}
	

}

?>