<?php

namespace Smof\Fields\Container\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	public function view(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}
	}
	
} 



?>