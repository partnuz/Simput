<?php

namespace Smof\Fields\Editor\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		echo $this -> data[ 'editor_field' ];
	}
	
} 



?>