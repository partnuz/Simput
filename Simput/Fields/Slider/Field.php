<?php

namespace Simput\Fields\Slider;
class Field extends \Simput\Fields\ParentRepeatable\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'repeatable',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return  array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => array(
				'title' => '',
				'upload' => array(), // if we base on multifield we don't need to specify details all over
				'description' => 'saSAsa'
			),
			'toggle' => true
		) );
	}
	
	public function initiateFields(){
		
		foreach( $this -> data as $field_key_num => $field_data ){
			
			$name = $this -> args[ 'name' ];
			$name[] = $field_key_num;
			
			$id = $this -> args[ 'id' ];
			$id[] = $field_key_num;
			
			$this -> fields[ $field_key_num ][ 'title' ] = $this -> getCreate() -> createFieldFromOptions( 
				$field_data[ 'title' ] ,
				array(
					'id' => 'title',
					'type' => 'text',
					'title' => __( 'Title' , 'smof' )
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $name,
					'id' => $id
				)
			);
			
			
			$this -> fields[ $field_key_num ][ 'upload' ] = $this -> getCreate() -> createFieldFromOptions( 
				$field_data[ 'upload' ] ,
				array(
					'id' => 'upload',
					'type' => 'upload',
					'title' => __( 'Upload' , 'smof' ) 
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $name,
					'id' => $id
				)
			);
			
			$this -> fields[ $field_key_num ][ 'description' ] = $this -> getCreate() -> createFieldFromOptions( 
				$field_data[ 'description' ] ,
				array(
					'id' => 'description',
					'type' => 'textarea',
					'title' => __( 'Description' , 'smof' )
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $name,
					'id' => $id
				)
			);
			
		}
		
	}
		
	public function controller(){
		

		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$name = $this -> args[ 'name' ];
		$name[] = 9999;
		
		$id = $this -> args[ 'id' ];
		$id[] = 9999;
		
		$title = $this -> getCreate() -> createFieldFromOptions( 
			$this -> options[ 'default' ][ 'title' ] ,
			array(
				'id' => 'title',
				'type' => 'text',
				'title' => __( 'Title' , 'smof' )
			),
			array(
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $name,
				'id' => $id,
				'show_data_name' => true
			)
		);
		
		$view -> setData( 'pattern_item_title' , $this -> obtainOutput( array( $title , 'controller' ) ) );
		
		$upload = $this -> getCreate() -> createFieldFromOptions( 
			$this -> options[ 'default' ][ 'upload' ] ,
			array(
				'id' => 'upload',
				'type' => 'upload',
				'title' => __( 'Upload' , 'smof' )
			),
			array(
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $name,
				'id' => $id,
				'show_data_name' => true
			)
		);
		
		$view -> setData( 'pattern_item_upload' , $this -> obtainOutput( array( $upload , 'controller' ) ) );
		
		$description = $this -> getCreate() -> createFieldFromOptions( 
			$this -> options[ 'default' ][ 'description' ] ,
			array(
				'id' => 'description',
				'type' => 'textarea',
				'title' => __( 'Description' , 'smof' )
			),
			array(
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $name,
				'id' => $id,
				'show_data_name' => true
			)
		);
		
		$view -> setData( 'pattern_item_description' , $this -> obtainOutput( array( $description , 'controller' ) ) );
		
		
		
		
		
		
		
		// view pattern item
		$fields_views = array();
		
		foreach( $this -> data as $field_id => $fields ){
			
			$fields_views[ $field_id ][ 'title' ] = $this -> obtainOutput( array( $fields[ 'title' ] , 'controller' ) ) ;
			$fields_views[ $field_id ][ 'upload' ] = $this -> obtainOutput( array( $fields[ 'upload' ] , 'controller' ) ) ;
			$fields_views[ $field_id ][ 'description' ] = $this -> obtainOutput( array( $fields[ 'description' ] , 'controller' ) ) ;
				
			
		}
		
		$view -> setData( 'items' , $fields_views );
		
		// view data

	}
	
	public function enqueueScripts(){
	
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		wp_enqueue_script( 'smof-field-upload', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'upload/script.js', array( 'jquery' ) );
	
	}

}

?>