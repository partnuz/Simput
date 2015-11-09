<?php

namespace Simput\Fields\Upload; 
class Field extends \Smof\Fields\ParentMulti\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => array( 
				'url' => '', 
				'id' => '',
				'height' => '',
				'width' => '' , 
				'size_thumbnail' => '',
				'size_medium' => ''
			),
			'validate' => array(
				'url' => false,
				'id' => false,
				'width' => false,
				'height' => false,
				'size_thumbnail' => false,
				'size_medium' => false
				)
			) );
			
	}
	
	public function initiateFields(){
		
		$this -> fields[ 'url' ] = $this -> getCreate() -> createFieldFromOptions( 
			$this -> data[ 'url' ] ,
			array(
				'id' => 'url',
				'type' => 'text',
				'validate' => $this -> options[ 'validate' ][ 'url' ]
			),
			array(
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $this -> args[ 'name' ],
				'id' =>  $this -> args[ 'id' ],
				'show_data_name' => $this -> args[ 'show_data_name' ],
				'field_class' => array( 'smof-field-upload-url' )
			)
		);
		
		$this -> fields[ 'width' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'width' ] ,
				array(
					'id' => 'width',
					'type' => 'hidden',
					'validate' => $this -> options[ 'validate' ][ 'width' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'show_data_name' => $this -> args[ 'show_data_name' ],
					'field_class' => array( 'smof-field-upload-width' )
				)
		);
		
		$this -> fields[ 'height' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'height' ] ,
				array(
					'id' => 'height',
					'type' => 'hidden',
					'validate' => $this -> options[ 'validate' ][ 'height' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'show_data_name' => $this -> args[ 'show_data_name' ],
					'field_class' =>  array( 'smof-field-upload-height' ) 
				)
			);
			
		$this -> fields[ 'id' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'id' ] ,
				array(
					'id' => 'id',
					'type' => 'hidden',
					'validate' => $this -> options[ 'validate' ][ 'id' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'show_data_name' => $this -> args[ 'show_data_name' ],
					'field_class' => array( 'smof-field-upload-id' )
				)
			);

			
			
			$this -> fields[ 'thumbnail ' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'size_thumbnail' ] ,
				array(
					'id' => 'thumbnail',
					'type' => 'hidden',
					'validate' => $this -> options[ 'validate' ][ 'size_thumbnail' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'show_data_name' => $this -> args[ 'show_data_name' ],
					'field_class' => array( 'smof-field-upload-size-thumbnail' )
				)
			);
			
				
			$this -> fields[ 'medium' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'size_medium' ] ,
				array(
					'id' => 'medium',
					'type' => 'hidden',
					'class' => array( 'smof-field-upload-size-medium' ),
					'validate' => $this -> options[ 'validate' ][ 'size_medium' ]
				),
				array(
						
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' => $this -> args[ 'id' ],
					'show_data_name' => $this -> args[ 'show_data_name' ]
				)
			);
			
	}
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
			
			$fields_views = array();
			
			
			foreach( $this -> fields as $field_id => $field ){
				
				$fields_views[ $field_id ] = $this -> obtainOutput( array( $field , 'controller' ) );
				
			}
			
			$view -> setData( 'fields' , $fields_views );
			
			$screenshot_file = wp_get_attachment_image_src( $this -> data[ 'id' ], 'thumbnail', true );
			$view -> setData( 'screenshot_filename' , $screenshot_file[ 0 ] );
			
			$view -> view();

	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }

		wp_enqueue_style( 'smof-field-upload', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'upload/field.css'  );
	
	}
	
	public function enqueueScripts(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }

		wp_register_script( 'smof-field-upload', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'upload/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-upload' );
	
	}

}

?>