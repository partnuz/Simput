<?php

namespace Smof\Fields\Window\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	public function view(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}
	}
	
} 



?>