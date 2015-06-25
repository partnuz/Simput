<?php

class Smof_Fields_Editor_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);

	public $editor_options;
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => 0,
			'rows' => 10,
			'teeny' => true
		) );
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options , $args );
		
		$this -> assignEditorOptions();
		
	}
	
	function assignEditorOptions(){
		$this -> editor_options = array(
			'textarea_name' => $this -> options[ 'id' ],
			'editor_class' => $this -> formFieldClass(),
			'textarea_rows' => $this -> options[ 'rows' ],
			'textarea_name' => $this -> args[ 'subframework' ] -> getFieldName( $this -> args[ 'name' ] ),
			'teeny' => $this -> options[ 'teeny' ]
		);	
	}
	
	
	function bodyView(){
		
		$this -> viewValidationResult();
	
		?>
					
			<?php
			
			wp_editor( $this -> data, 'smof-' . $this -> args[ 'subframework' ] -> getFieldId( $this -> args[ 'id' ] ), $this -> editor_options );
			
			?>
				
		<?php
	}
	
	function enqueueStyles(){
		wp_enqueue_style( 'smof-field-editor', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'editor/field.css'  );
	}
	


}

?>