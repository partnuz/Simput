<?php

namespace Simput\Fields\Group\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}

	}
	
} 



?>