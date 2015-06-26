<?php

namespace Smof\Fields\Textarea\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
	
		?>
		<textarea <?php $this -> viewName(); ?>><?php echo htmlspecialchars( $this -> data['data'] ); ?></textarea>
		
		<?php
	}
	
} 



?>