<?php

namespace Simput\Fields\Editor\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		echo $this -> data[ 'editor_field' ];
	}
	
} 



?>