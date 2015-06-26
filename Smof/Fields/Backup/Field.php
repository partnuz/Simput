<?php

namespace Smof\Fields\Backup;
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'id' => 'backup',
			'default' => ''
		) );
	}
	
	public function obtainData(){
		return array();
	}
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$view -> setData( 'button_name' , $this -> subframework -> getFieldName( array( 'action' ) ) );
		
		$view -> view();

	}
	
	public function enqueueStyles(){
	
		if( !$this -> subframework -> args[ 'debug_mode' ] ){ return; }
		wp_enqueue_style( 'smof-field-backup', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'Backup/field.css' ) ;
	
	}

}

?>