<?php

namespace Smof\Fields\Select;
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single_multiple',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'type' => 'select',
			'multiple' => false,
			'options' => array(),
		) ) ;
	}

	function __construct( $options , array $args ){
	
		$this -> assignInstance();
		
		$this -> assignDefaultOptions();
		
		if( isset( $options[ 'multiple' ] ) ){
			$this -> default_options[ 'default' ] = array();
		}
		
		$this -> assignDefaultArgs();
	
		$this -> assignOptions( $options  );

		$this -> assignArgs( $args  );
		
		$this -> assignFrameworks();
		
		$this -> assignNameSuffix();
		
		$this -> assignName();
		
		$this -> assignIdSuffix();
		
		$this -> assignId();
		
		$this -> enqueueAll();

	}
	
	protected function assignNameSuffix(){
	
		
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
				
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] , null );
				}
				
			break;
			case 'repeatable':	
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ][] =  $this -> args[ 'id_order' ] ;
					$this -> args[ 'name_suffix' ][] = null;
					
				}else{
					$this -> args[ 'name_suffix' ] = array( $this -> args[ 'id_order' ] );
				}
				
			break;
		}
	
	}
	
	protected function assignIdSuffix(){
	
		
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			
			break;
			case 'repeatable':
			
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] );
				
			break;
		}
	
	}
	
	public function validateData(){
		
		if( $this -> options[ 'validate' ] ){
		
			if( $this -> options[ 'multiple' ] !== false ){
				
				$validate = new \Smof\Validation();
				
				foreach( $this -> data as $field_key => $field ){
						
					$results[ $field_key ] = $validate -> validate( array( 'data' => $this -> data[ $field_key ]  , 'conditions' => $this -> options[ 'validate' ] ) );
							
				}
				
				if( !empty( $results ) ){
					$this -> validation_results = $results;
					$this -> data = $this -> options[ 'default' ];
				}
			}else{
				
				parent :: validateData();
			}
		
		}
		
	}
	
	public function controller(){
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'attributes' => $this -> convertAttributesToJson( $this -> args[ 'attributes' ] ),
					'field_class' => $this -> obtainFieldClass()
				) 
			) 
		);
		
		$view -> view();

	}

}

?>