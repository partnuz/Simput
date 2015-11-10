<?php

namespace Simput\Fields\Editor;
class Field extends \Simput\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);

	public $editor_options;
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => 0,
			'rows' => 10,
			'teeny' => true
		) );
	}

	function __construct( $options , array $args ){
	
		parent :: __construct( $options , $args );
		
		$this -> assignEditorOptions();
		
	}
	
	protected function assignEditorOptions(){
		$this -> editor_options = array(
			'textarea_name' => $this -> options[ 'id' ],
			'editor_class' => $this -> obtainFieldClass(),
			'textarea_rows' => $this -> options[ 'rows' ],
			'textarea_name' => $this -> args[ 'subframework' ] -> getFieldName( $this -> args[ 'name' ] ),
			'teeny' => $this -> options[ 'teeny' ]
		);	
	}
	
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		?>
					
			<?php
			ob_start();
				wp_editor( $this -> data, 'smof-' . $this -> args[ 'subframework' ] -> getFieldId( $this -> args[ 'id' ] ), $this -> editor_options );
			$editor_field = ob_get_contents();
			ob_end_clean();
			
			?>
				
		<?php
		
		$view -> setData( 'editor_field' , $editor_field );
		
		$view -> view();
	}
	
	public function enqueueStyles(){
		
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		
		wp_enqueue_style( 'smof-field-editor', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'editor/field.css'  );
	}
	


}

?>