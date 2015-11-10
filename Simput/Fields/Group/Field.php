<?php

namespace Simput\Fields\Group;
class Field extends \Simput\Fields\ParentMulti\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => false
		),
		'inheritance' => 'parent_children',
		'category' => 'multiple',
		'custom' => false
	);
	
	function __construct( $options , array $args ){
		parent :: __construct( $options, $args );
		$this -> childFieldsModeNotRepeatable();
	}
	
	// args passed to field cannot be repeatable
	protected function childFieldsModeNotRepeatable(){
		$this -> args[ 'mode' ] = 'nonrepeatable';
	}
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => array()
		) );
	}
	
	public function initiateFields(){
	
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data , $this -> args );
		
	}
	
	public function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	public function controller(){
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'data_source_names' => $this -> data_source_names
				) 
			) 
		);
		
		$fields_views = array();
		
		foreach( $this -> fields as $field ){
			
			$fields_views[] = $this -> obtainOutput( array( $field , 'controller' ) ) ;
				
			
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();
			
	}

}

?>