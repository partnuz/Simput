<?php

namespace Simput\Fields\Hidden; 

class Field extends \Simput\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => false
		),
		'category' => 'single',
		'custom' => false
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => ''
		) );
	}
	protected function obtainDefaultArgs(){
		return array_merge_recursive( parent :: obtainDefaultArgs() ,array(
			'args_name_only' => false
		) );
	}
	protected function assignNameSuffix(){
		
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'name_suffix' ] = array();
		}else{
			$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		}
	
	}
	
	protected function assignIdSuffix(){
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'id_suffix' ] = array();
		}else{
			$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		}
	}

	
	public function controller(){
		
		$view = new Views\Main( 
			array_replace( $this -> obtainDefaultViewData() , 
				array(
					'field_class' => $this -> obtainFieldClass()
				) 
			) 
		);
		
		$view -> view();
	

	}
	
}

?>