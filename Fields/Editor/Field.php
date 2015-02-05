<?php

class Smof_Fields_Editor_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);

	public $editor_options;
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => 0,
			'rows' => 10,
			'teeny' => true
		);
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options , $args );
		
		$this -> editor_options = array(
			'textarea_name' => $this -> options[ 'id' ],
			'editor_class' => $this -> options[ 'class' ],
			'textarea_rows' => $this -> options[ 'rows' ],
			'textarea_name' => $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ),
			'teeny' => $this -> options[ 'teeny' ]
		);
		

	
	}
	
	
	function bodyView(){
	
		?>
					
			<?php
			
			wp_editor( $this -> data, 'smof' . $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ), $this -> editor_options );
			
			?>
				
		<?php
	}
	
	function enqueueStyles(){
		wp_enqueue_style( 'smof-field-editor', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'editor/field.css'  );
	}
	


}

?>