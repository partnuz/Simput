<?php

namespace Simput\Fields\Group\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}

	}
	
} 



?>