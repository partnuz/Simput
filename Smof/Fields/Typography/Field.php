<?php

class Smof_Fields_Typography_Field extends Smof_Fields_ParentMulti_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
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
			'show' => array(
				'font-family' => true,
				'font-weight' => true,
				'font-size' => true,
				'line-height' => true,
				'typeface' => true,
				'color' => true,
				'preview' => true
			),
			'data_source_format' => array(
				'font-family' => false
			),
			'options' => array(
				'font-weight' => array()
			),
			'cache_data_source' => array(
				'font-family' => false
			)
		);
	}
	
	function initiateFields(){
		
		if( $this -> options[ 'show' ][ 'font-family' ] ){
		
			$this -> fields[ 'font_family' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'font-family' ] ,
				array(
					'id' => 'font-family',
					'type' => 'combobox',
					'title' => __( 'Font-family' , 'smof'),
					'options' => $this -> options[ 'options' ][ 'font-family' ],
					'data_source_format' => $this -> options[ 'data_source_format' ][ 'font-family'],
					'cache_data_source' => $this -> options[ 'cache_data_source' ][ 'font-family' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-font-family' ) 
				)
			);
			
		}
		
		if( $this -> options[ 'show' ][ 'font-family' ] ){
		
			$this -> fields[ 'font_family' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'font-family' ] ,
				array(
					'id' => 'font-family',
					'type' => 'combobox',
					'title' => __( 'Font-family' , 'smof'),
					'options' => $this -> options[ 'options' ][ 'font-family' ],
					'data_source_format' => $this -> options[ 'data_source_format' ][ 'font-family'],
					'cache_data_source' => $this -> options[ 'cache_data_source' ][ 'font-family' ]
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-font-family' ) 
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
					'title' => __( 'Font-weight' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-font-weight'),
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
					'title' => __( 'Font-size' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-font-size' ),
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
					'title' => __( 'Line-height' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-line-height' ),
					'attributes' => array(
						'typography-line-height-unit' => $this -> data[ 'line-height-unit' ]
					)
				)
			);
			
		}
		
		if( $this -> options[ 'show' ][ 'typeface' ] ){
			
			$this -> fields[ 'font_weight' ] = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'typeface' ] ,
				array(
					'id' => 'typface',
					'type' => 'select',
					'options' => array(
						'' => __( 'Select' , 'smof' ),
						'serif' => __( 'Serif' , 'smof' ),
						'sans-serif' => __( 'Sans-serif' , 'smof' )
					),
					'title' => __( 'Typeface' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-typface')
				)
			);
		
		}
		
		if( $this -> options[ 'show' ][ 'color' ] ){
			
			$color = $this -> getCreate() -> createFieldFromOptions( 
				$this -> data[ 'color' ] ,
				array(
					'id' => 'color',
					'type' => 'color',
					'title' => __( 'Color' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'form_field_class' => array( 'smof-field-typography-color' )
				)
			);
		
		}
		
	}
	
	
	function bodyView(){
	
		$preview_style = '';

		$this -> getCreate() -> fieldsView( $this -> fields );
			
		if( $this -> options[ 'show' ][ 'preview' ] ){
			
			?><p class="smof-font-preview"><?php echo $this -> data[ 'preview' ]; ?></p>
			<?php
		
		}

	}
	
	protected function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-typography', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'typography/field.css'  );
	
	}
	
	function enqueueScripts(){	
		
		wp_register_script( 'smof-field-typography', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'typography/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-typography' );
	
	}
	

}

?>