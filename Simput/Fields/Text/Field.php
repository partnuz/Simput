<?php

namespace Simput\Fields\Text; 
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'custom' => false
		) );
	}
	
	public function controller(){
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'field_class' => $this -> obtainFieldClass(),
					'attributes' => $this -> convertAttributesToJson( $this -> args[ 'attributes' ] )
				) 
			) 
		);
		
		$view -> view();
	
	}
	

}

?>