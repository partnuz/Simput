<?php

class Smof_Fields_GroupSave_Field extends Smof_Fields_ParentMulti_Field{
	
	protected $files_from_dir = array();

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => false
		),
		'inheritance' => 'parent_children',
		'category' => 'multiple'
	);
	
	function __construct( $options , array $args ){
		parent :: __construct( $options, $args );
		$this -> childFieldsModeNotRepeatable();
	}
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
				'default' => array( 
					'__new_file_name' => '',
					'__file_name' => ''
				),
				'options' => array(
					'__file_name' => array()
				)
			);
			
	}
	
	// args passed to field cannot be repeatable
	protected function childFieldsModeNotRepeatable(){
		$this -> args[ 'mode' ] = 'nonrepeatable';
	}
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => array()
		) );
	}
	
	public function initiateFields(){
		
		
		$this -> createOrDeleteDataFromDirectory();
		$this -> loadFileToDirectory();
		
		$this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data , $this -> args );

		$this -> listFilesFromDirectory();
		
		
	}
	
	protected function loadFileFromDirectory(){

		if( false === $file_content = file_get_contents( $url ) ){
			
			// add bad to msg
			
		}else{
			
			$this -> data = array_merge_recursive( $this -> data , unserialize( $file_content ) );
			
			// add good to msg
			
		}
			
	}
	
	protected function createOrDeleteFileFromDirectory(){
		if( $this -> subframework -> action === 'save' ){
			
			// remove unwanted __action vals
			
			switch( $this -> data[ '__action' ] ){
				case 'delete':
				
					// remove file
					//
				
				break;
				case 'create':
				
					$data = $this -> dataFromTmpFields();
					if( $data ){
						
						$data = serialize( $data );
						// validate url
						
						if( file_put_contents($url, $data) === FALSE ){
							
							// cannot create new file
							
						}else{
							
							// created new file
							
						}
						
					}
				
				break;
				case 'save':
				
					$data = $this -> dataFromTmpFields();
				
					if( $data ){
						
						$data = serialize( $data );
						// validate url
						
						if( file_put_contents($url, $data) === FALSE ){
							
							// add bad to msg
							
						}else{
							
							// add good to msg
							
						}
						
					}
				
				break;

				
			}
			

			
		}

	}
	
	protected function dataFromTmpFields(){
		
		$tmp_fields = $this -> fields = $this -> getCreate() -> createFieldsFromOptions( $this -> options[ 'fields' ] , $this -> data , $this -> args );
		$this -> getCreate() -> fieldValidate( $tmp_fields );
		return $this -> getCreate() -> fieldSave( $tmp_fields );	
		
	}
	
	protected function listFilesFromDirectory(){
		if( !$this -> options[ 'options'][ '__file_name' ] ){
			
			// read files from dir
			// merge keys with values
			// assign file from dir
			
		}
	}
	
	public function validateData(){
		
		$this -> getCreate() -> fieldsValidate( $this -> fields );
	}
	
	
	function bodyView(){
		
		$file_name = createFieldFromOptions(
			$this -> data[ '__file_name' ],
			array(
				'id' => '__file_name',
				'type' => 'combobox',
				'options' => $this -> files_from_directory
			),
			array(
				'framework' => $this -> framework,
				'subframework' => $this -> subframework
				'name' => $this -> args[ 'name' ] ,
				'id' => $this -> args[ 'id' ],
				'show_description' => false
			)
		);
		
		$file_name -> view();
		
		if( $this -> options[ 'options' ][ '__file_name' ] ){
			$new_file_name = createFieldFromOptions(
				'',
				array(
					'id' => '__new_file_name',
					'type' => 'combobox',
					'options' => $this -> files_from_directory
				),
				array(
					'framework' => $this -> framework,
					'subframework' => $this -> subframework
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'show_description' => false
				)
			);
			
			$new_file_name -> view();
		}
		
		$file_name = createFieldFromOptions(
			'save',
			array(
				'id' => 'action',
				'type' => 'select',
				'options' => array(
					'save' => __( 'Save' , 'smof' ),
					'delete' => __( 'Delete' , 'smof' ),
					'create' => __( 'Create' , 'smof' )
				)
			),
			array(
				'framework' => $this -> framework,
				'subframework' => $this -> subframework
				'name' => $this -> args[ 'name' ] ,
				'id' => $this -> args[ 'id' ],
				'show_description' => false
			)
		);
		
		
		?>
		<button id ="of_save" type="submit" name="smof[action]" value="save" class="button-primary"><?php _e('Apply');?></button>
		<?php
		
		$this -> getCreate() -> fieldsView( $this -> fields );
			
	}

}

?>