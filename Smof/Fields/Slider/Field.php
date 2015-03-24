<?php

class Smof_Fields_Slider_Field extends Smof_Fields_ParentRepeatable_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'repeatable'
	);
	
	function obtainDefaultOptions(){
		return  array(
			'default' => array(
				'title' => '',
				'upload' => array(), // if we base on multifield we don't need to specify details all over
				'description' => 'saSAsa'
			),
			'toggle' => true
		) + parent :: obtainDefaultOptions();
	}
	
	function initiateFields(){
		
		foreach( $this -> data as $field_key_num => $field_data ){
			
			$name = $this -> args[ 'name' ];
			$name[] = $field_key_num;
			
			$id = $this -> args[ 'id' ];
			$id[] = $field_key_num;
			
			$this -> fields[ $field_key_num ][ 'title' ] = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
			
			
			$this -> fields[ $field_key_num ][ 'upload' ] = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
			
			$this -> fields[ $field_key_num ][ 'description' ] = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
	
	
	function bodyView(){
	
		?>
			<ul>
				<li class="smof-hidden smof-repeatable-pattern-item">
				<?php
				$this -> beforeListItemContentView();
				$this -> beforeItemContentView();
				?>


						<?php
						
						$name = $this -> args[ 'name' ];
						$name[] = 9999;
						
						$id = $this -> args[ 'id' ];
						$id[] = 9999;
						
						$title = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$title -> view();
						
						$upload = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$upload -> view();
						
						$description = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$description -> view();
					
						?>

					<?php
					$this -> afterItemContentView();
					$this -> afterListItemContentView();
					?>
				</li>
			<?php
			
			foreach( $this -> data as $field_key_num => $field_data ){
			
				?>
				<li>
					<?php
					$this -> beforeListItemContentView();
					$this -> beforeItemContentView();
					?>
						<?php
						
						$this -> fields[ $field_key_num ][ 'title' ] -> view();
						
						$this -> fields[ $field_key_num ][ 'upload' ] -> view();
						
						$this -> fields[ $field_key_num ][ 'description' ] -> view();

						?>

					<?php
					$this -> afterItemContentView();
					$this -> afterListItemContentView();
					?>
				</li>
				<?php
			}
			?>
			</ul>
			<input type="button" value="<?php _e( 'Add new' , 'smof' ); ?>" class="button smof-field-repeatable-add-new">
		<?php
	}
	
	
	function enqueueScripts(){
	
		wp_enqueue_script( 'smof-field-upload', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'upload/script.js', array( 'jquery' ) );
	
	}

}

?>