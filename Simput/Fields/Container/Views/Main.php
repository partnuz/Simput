<?php

namespace Simput\Fields\Container\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	public function view(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}
	}
	
} 



?>