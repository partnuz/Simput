<?php

class Smof_Fields_Upload_Field extends Smof_Fields_ParentMulti_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => array( 
				'url' => '', 
				'id' => '',
				'height' => '',
				'width' => '' , 
				'sizes' => array(
					'thumbnail' =>'',
					'medium' => ''
				) 
			)
			
		);
	}
	
	function bodyView(){
				
			$url = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'url' ] ,
				array(
					'id' => 'url',
					'type' => 'text'
				),
				array(
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'show_body_id' => false,
					'show_data_name' => $this -> args[ 'show_data_name' ],
					'form_field_class' => array( 'smof-field-upload-url' )
				)
			);
			
			$url -> view();
			
			$width = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'width' ] ,
				array(
					'id' => 'width',
					'type' => 'hidden'
				),
				array(
						'subframework' => $this -> args[ 'subframework' ],
						'name' => $this -> args[ 'name' ],
						'show_body_id' => false,
						'show_data_name' => $this -> args[ 'show_data_name' ],
						'form_field_class' => array( 'smof-field-upload-width' )
				)
			);
			$width -> view();
			
			$height = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'height' ] ,
				array(
					'id' => 'height',
					'type' => 'hidden'
				),
				array(
						'subframework' => $this -> args[ 'subframework' ],
						'name' => $this -> args[ 'name' ] ,
						'show_body_id' => false,
						'show_data_name' => $this -> args[ 'show_data_name' ],
						'form_field_class' =>  array( 'smof-field-upload-height' ) 
				)
			);
			$height -> view();
				
				
			$id = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'id' ] ,
				array(
					'id' => 'id',
					'type' => 'hidden'
				),
				array(
						'subframework' => $this -> args[ 'subframework' ],
						'name' => $this -> args[ 'name' ] ,
						'show_body_id' => false,
						'show_data_name' => $this -> args[ 'show_data_name' ],
						'form_field_class' => array( 'smof-field-upload-id' )
				)
			);
			$id -> view();
			
			
			$thumbnail = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'sizes' ][ 'thumbnail' ] ,
				array(
					'id' => 'thumbnail',
					'type' => 'hidden'
				),
				array(
						'subframework' => $this -> args[ 'subframework' ],
						'name' => array_merge( $this -> args[ 'name' ] , array( 'sizes' ) ) ,
						'show_body_id' => false,
						'show_data_name' => $this -> args[ 'show_data_name' ],
						'form_field_class' => array( 'smof-field-upload-sizes-thumbnail' )
				)
			);
			
			$thumbnail -> view();
				
			$medium = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				$this -> data[ 'sizes' ][ 'medium' ] ,
				array(
					'id' => 'medium',
					'type' => 'hidden',
					'class' => array( 'smof-field-upload-sizes-medium' )
				),
				array(
						
						'subframework' => $this -> args[ 'subframework' ],
						'name' => array_merge( $this -> args[ 'name' ] , array( 'sizes' ) ) ,
						'show_body_id' => false,
						'show_data_name' => $this -> args[ 'show_data_name' ]
				)
			);
			
			$medium -> view();

			?>
			<input type="button" class="button smof-field-upload-upload-button" value="<?php _e( "Upload" , 'smof'); ?>">
			<input type="button" class="button smof-field-upload-remove-url" value="<?php _e( "Remove" , 'smof'); ?>">
			<div class="smof-field-upload-screenshot"><?php if( !empty( $this -> data[ 'id' ] ) ){ ?><img src="<?php $screenshot_file = wp_get_attachment_image_src( $this -> data[ 'id' ], 'thumbnail', true ); echo $screenshot_file[ 0 ]; ?>"><?php } ?></div>
		<?php
	}
	
	function enqueueStyles(){

		wp_enqueue_style( 'smof-field-upload', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'upload/field.css'  );
	
	}
	
	function enqueueScripts(){

		wp_register_script( 'smof-field-upload', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'upload/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-upload' );
	
	}

}

?>