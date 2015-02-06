<?php

class Smof_Fields_Typography_Field extends Smof_Fields_ParentMulti_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => array(
				'font-family' => '',
				'font-weight' => '',
				'font-size' => '',
				'font-size-unit' => 'px',
				'line-height' => '',
				'line-height-unit' => 'px',
				'color' => '',
				'preview' => '0123456789 ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz'
			),
			'show' => array(
				'font-family' => true,
				'font-weight' => true,
				'font-size' => true,
				'line-height' => true,
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
	
	
	function bodyView(){
	
		$preview_style = '';
		var_dump( $this -> data );
		
		if( $this -> options[ 'show' ][ 'font-family' ] ){
		
			$font_family = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
					'show_body_id' => false,
					'form_field_class' => array( 'smof-field-typography-font-family' ) 
				)
			);
			
			if( isset( $this -> validation_results[ 'font-family' ] ) ){
				$font_family -> validation_results = $this -> validation_results[ 'font-family' ];
			}
			
			$this -> args[ 'subframework' ] -> fieldLoopView( array( $font_family ) );
			
		}
		
		if( $this -> options[ 'show' ][ 'font-weight' ] ){
			
			$font_weight = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
					'show_body_id' => false,
					'form_field_class' => array( 'smof-field-typography-font-weight'),
					'attributes' => array(
						'typography-font-weight-default' => $this -> data[ 'font-weight' ]
					)
				)
			);
			
			if( isset( $this -> validation_results[ 'font-weight' ] ) ){
				$font_weight -> validation_results = $this -> validation_results[ 'font-weight' ];
			}
			
			$this -> args[ 'subframework' ] -> fieldLoopView( array( $font_weight ) );
		
		}
		
		if( $this -> options[ 'show' ][ 'font-size' ] ){
			
			$font_size = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'font-size' ] ,
				array(
					'id' => 'font-size',
					'type' => 'text',
					'title' => __( 'Font-size' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'show_body_id' => false,
					'form_field_class' => array( 'smof-field-typography-font-size' ),
					'attributes' => array(
						'typography-font-size-unit' => $this -> data[ 'font-size-unit' ]
					)
				)
			);
			
			if( isset( $this -> validation_results[ 'font-size' ] ) ){
				$font_size -> validation_results = $this -> validation_results[ 'font-size' ];
			}
			
			$this -> args[ 'subframework' ] -> fieldLoopView( array( $font_size ) );
			
		}
		
		if( $this -> options[ 'show' ][ 'line-height' ] ){
			
			$line_height = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'line-height' ] ,
				array(
					'id' => 'line-height',
					'type' => 'text',
					'title' => __( 'Line-height' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'show_body_id' => false,
					'form_field_class' => array( 'smof-field-typography-line-height' ),
					'attributes' => array(
						'typography-line-height-unit' => $this -> data[ 'line-height-unit' ]
					)
				)
			);
			
			if( isset( $this -> validation_results[ 'line-height' ] ) ){
				$line_height -> validation_results = $this -> validation_results[ 'line-height' ];
			}
			
			$this -> args[ 'subframework' ] -> fieldLoopView( array( $line_height ) );
			
		}
		
		if( $this -> options[ 'show' ][ 'color' ] ){
			
			$color = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'color' ] ,
				array(
					'id' => 'color',
					'type' => 'color',
					'title' => __( 'Color' , 'smof')
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'show_body_id' => false,
					'form_field_class' => array( 'smof-field-typography-color' )
				)
			);
			
			if( isset( $this -> validation_results[ 'color' ] ) ){
				$color -> validation_results = $this -> validation_results[ 'color' ];
			}
			
			$this -> args[ 'subframework' ] -> fieldLoopView( array( $color ) );
		
		}
			
		if( $this -> options[ 'show' ][ 'preview' ] ){
			
			?><p class="smof-font-preview"><?php echo $this -> data[ 'preview' ]; ?></p>
			<?php
		
		}

	}
	
	protected function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-typography', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'typography/field.css'  );
	
	}
	
	function enqueueScripts(){	
		
		wp_register_script( 'smof-field-typography', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'typography/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-typography' );
	
	}
	

}

?>