<?php

namespace Smof\Fields\Repeatable; 
class Field extends \Smof\Fields\ParentRepeatable\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => 'parent',
		'default' => array(),
		'category' => 'repeatable',
		'custom' => false
	);
	
	protected $repeatable_field_options;
	protected $repeatable_field_name;
	
	function __construct( $options , array $args  ){
		
	
		parent :: __construct( $options , $args  );
		
		$this -> assignRepeatableField();
		$this -> isFieldRepeatable();	

	}
	
	public function setData( $data ){

		if( $data !== null && is_array( $data ) && isset( $data[ 0 ]) ){ 
			
			$this -> data = $data;

		}else{
		
			$this -> data = array();
		}
	}
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'field' => array(),
			'default' => static :: $properties[ 'default' ]
		) );
	}
	
	public function assignOptions( $options ){
	
		$this -> options = array_replace_recursive( $this -> default_options, $options );

	}
	
	public function assignRepeatableField(){
	
		$this -> repeatable_field_options = $this -> options[ 'options' ];
		
		$exclude_options = array(
		);
		
		foreach( $exclude_options as $option ){
			if( isset( $this -> repeatable_field_options[ $option ] ) ){
				unset( $this -> repeatable_field_options[ $option ] );
			}
		}
		
		$this -> repeatable_field_options[ 'id' ] = '';
		
		
		$this -> repeatable_field_name = $this -> args[ 'subframework' ] -> getArgs( 'framework' ) -> obtainFieldClassName( $this -> options[ 'options' ][ 'type' ] );
	}
	
	public function isFieldRepeatable(){
		
		if( $this -> repeatable_field_name !== false ){
			
			$tmp_field_name = $this -> repeatable_field_name;

			// for php 5.2 compatibility use call_user_func()
			$repeatable_field = call_user_func( array( $tmp_field_name , 'getProperties' ) );
			if( !$repeatable_field[ 'allow_in_fields' ][ 'repeatable' ] ){
				$this -> setOutput(  false );
			}
		}else{
			$this -> setOutput( false );
		}	
		
	}
	
	public function initiateFields(){
		
		foreach( $this -> data as $field_key => $field_data ){

			$field = $this -> getCreate() -> createFieldFromOptions(
				$field_data,
				$this -> repeatable_field_options,
				array( 
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'show_description' => false,
					'name_order' => $field_key,
					'id_order' => $field_key,
					'mode' => 'repeatable'
				) 
			);
			
			if( is_object( $field ) ){
				$this -> fields[] = $field;
			}
			
		}
		
	}
	
	public function validateData(){
	
		if( !empty( $this -> field[ 0 ] ) ){
	
			$this -> getCreate() -> fieldsValidate( $this -> fields );
					
		}
	
	}
	
	public function obtainData(){
				
			$this -> data = $this -> getCreate() -> obtainFieldsData( $this -> fields );
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );


	}
	
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$repeatable_field = $this -> getCreate() -> createFieldFromOptions(
			false,
			$this -> repeatable_field_options,
			array( 
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $this -> args[ 'name' ] ,
				'id' => $this -> args[ 'id' ] ,
				'show_description' => false,
				'show_data_name' => true,
				'name_order' => 9999,
				'id_order' => 9999,
				'mode' => 'repeatable'
			) 
		);
		
		
		
		$view -> setData( 'pattern_item' , $this -> obtainOutput( array( $repeatable_field , 'controller' ) ) );
		
		
		$fields_views = array();
		
		foreach( $this -> fields as $field ){
			
			$fields_views[] = $this -> obtainOutput( array( $field , 'controller' ) ) ;
				
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();
		
		// view data

	}

}

?>