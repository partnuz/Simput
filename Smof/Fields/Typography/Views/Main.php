<?php

namespace Smof\Fields\Typography\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}
			
		if( $this -> data[ 'show' ][ 'preview' ] ){
			
			?><p class="smof-font-preview"><?php echo $this -> data[ 'default' ][ 'preview' ]; ?></p>
			<?php
		
		}
	}
	
} 



?>