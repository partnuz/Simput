<?php

namespace Simput\Fields\Typography; 
class Field extends \Simput\Fields\ParentMulti\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'default' => array(
				'font-family' => '',
				'font-weight' => '',
				'font-size' => '',
				'font-size-unit' => 'px',
				'line-height' => '',
				'line-height-unit' => 'px',
				'typeface' => '',
				'color' => '',
				'preview' => '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz'
			),
			'validate' => array(
				'font-family' => false,
				'font-weight' => false,
				'font-size' => false,
				'typeface' => false,
				'line-height' => false,
				'color' => false
			),
			'show' => array(
				'font-family' => true,
				'font-weight' => true,
				'font-size' => true,
				'line-height' => true,
				'typeface' => true,
				'color' => true,
				'preview' => true
			),
			'multiple_data_sources' => array(
				'font-family' => false
			),
			'options' => array(
				'font-weight' => array()
			)
		) );
	}
	
	public function initiateFields(){
		
		if( $this -> options[ 'show' ][ 'font-family' ] ){
		
			$this -> fields[ 'font_family' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'font-family' ] ,
				array(
					'id' => 'font-family',
					'type' => 'combobox',
					'title' => __( 'Font-family' , 'smof'),
					'options' => $this -> options[ 'options' ][ 'font-family' ],
					'validate' => $this -> options[ 'validate' ][ 'font-family' ],
					'multiple_data_sources' => $this -> options[ 'multiple_data_sources' ][ 'font-family' ],
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-font-family' ) 
				)
			);
			
			
			
		}
		
		if( $this -> options[ 'show' ][ 'font-weight' ] ){
			$this -> fields[ 'font_weight' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'font-weight' ] ,
				array(
					'id' => 'font-weight',
					'type' => 'select',
					'options' => $this -> options[ 'options' ][ 'font-weight' ],
					'title' => __( 'Font-weight' , 'smof'),
					'validate' => $this -> options[ 'validate' ][ 'font-weight' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-font-weight'),
					'attributes' => array(
						'typography-weight-default' => $this -> data[ 'font-weight' ]
					)
				)
			);
			
			
		
		}
		
		if( $this -> options[ 'show' ][ 'font-size' ] ){
			
			$this -> fields[ 'font_size' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'font-size' ] ,
				array(
					'id' => 'font-size',
					'type' => 'text',
					'title' => __( 'Font-size' , 'smof'),
					'validate' => $this -> options[ 'validate' ][ 'font-size' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-font-size' ),
					'attributes' => array(
						'typography-font-size-unit' => $this -> data[ 'font-size-unit' ]
					)
				)
			);
			
			
			
		}
		
		if( $this -> options[ 'show' ][ 'line-height' ] ){
			
			$this -> fields[ 'line_height' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'line-height' ] ,
				array(
					'id' => 'line-height',
					'type' => 'text',
					'title' => __( 'Line-height' , 'smof'),
					'validate' => $this -> options[ 'validate' ][ 'line-height' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-line-height' ),
					'attributes' => array(
						'typography-line-height-unit' => $this -> data[ 'line-height-unit' ]
					)
				)
			);
			
		}
		
		if( $this -> options[ 'show' ][ 'typeface' ] ){
			
			$this -> fields[ 'typeface' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'typeface' ] ,
				array(
					'id' => 'typface',
					'type' => 'select',
					'options' => array(
						'' => __( 'Select' , 'smof' ),
						'serif' => __( 'Serif' , 'smof' ),
						'sans-serif' => __( 'Sans-serif' , 'smof' )
					),
					'title' => __( 'Typeface' , 'smof'),
					'validate' => $this -> options[ 'validate' ][ 'typeface' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-typface')
				)
			);
		
		}
		
		if( $this -> options[ 'show' ][ 'color' ] ){
			
			$this -> fields[ 'color' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'color' ] ,
				array(
					'id' => 'color',
					'type' => 'color',
					'title' => __( 'Color' , 'smof'),
					'validate' => $this -> options[ 'validate' ][ 'color' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ],
					'id' =>  $this -> args[ 'id' ],
					'field_class' => array( 'smof-field-typography-color' )
				)
			);
		
		}
				
	}
	
	
	public function controller(){
		
		$view = new Views\Main( 
			$this -> obtainDefaultViewData() 
		);
		
		$fields_views = array();
		
		foreach( $this -> fields as $field_id => $field ){
			
			$fields_views[ $field_id ] = $this -> obtainOutput( array( $field , 'controller' ) );
			
		}
		
		$view -> setData( 'fields' , $fields_views );
		
		$view -> view();

	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
	
		wp_enqueue_style( 'smof-field-typography', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'typography/field.css'  );
	
	}
	
	public function enqueueScripts(){

		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_register_script( 'smof-field-typography', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'typography/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-typography' );
	
	}
	

}

?>