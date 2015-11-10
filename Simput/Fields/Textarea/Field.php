<?php

namespace Simput\Fields\Textarea; 
class Field extends \Simput\Fields\ParentField\Field{

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
		return array_replace_recursive( parent :: obtainDefaultOptions() , array(
			'default' => ''
		) );
	}
	
	public function controller(){
		
		$view = new Views\Main( $this -> obtainDefaultViewData() );
		
		$view -> view();
	}

}

?>