<?php

class Smof_Fields_Slider_Field extends Smof_Fields_ParentRepeatable_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'repeatable'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => array(
				'title' => '',
				'upload' => array(), // if we base on multifield we don't need to specify details all over
				'description' => ''
			)
		);
	}
	
	
	function bodyView(){
	
		?>
			<ul>
				<li class="smof-hidden">
				<?php
				$this -> beforeListItemContentView();
				?>

					<div class="smof-toggle">
						<div class="header">bla<div class="toggle">toggle</div></div>
						<div class="body">
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
						</div>
					</div>
					<?php
					$this -> afterListItemContentView();
					?>
				</li>
			<?php
			
			foreach( $this -> data as $field_key_num => $field_data ){
			
				$name = $this -> args[ 'name' ];
				$name[] = $field_key_num;
				
				$id = $this -> args[ 'id' ];
				$id[] = $field_key_num;
			
			
				?>
				<li>
					<?php
					$this -> beforeListItemContentView();
					?>
					<div class="smof-toggle">
						<div class="header"><div class="toggle smof-icons"></div></div>
						<div class="body">
						<?php
						
						$title = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$title -> view();
						
						$upload = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$upload -> view();
						
						$description = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
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
						
						$description -> view();

						?>
						</div>
					</div>
					<?php
					$this -> afterListItemContentView();
					?>
				</li>
				<?php
			}
			?>
			</ul>
		<?php
	}
	
	
	function enqueueScripts(){
	
		wp_enqueue_script( 'smof-field-upload', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'upload/script.js', array( 'jquery' ) );
	
	}

}

?>