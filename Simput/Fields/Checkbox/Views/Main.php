<?php

namespace Simput\Fields\Checkbox\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		?>
		
		<input class="smof-field smof-field-hidden" id="" <?php $this -> viewName(); ?> type="hidden" value="0" />
		
		<?php

			?>
			<input class="smof-field smof-field-checkbox" <?php $this -> viewName(); ?> type="checkbox" value="1" <?php checked( '1', $this -> data[ 'data' ] ); ?> /><?php echo htmlspecialchars( $this -> data[ 'options' ] ); ?>
		<?php
	}
	
} 



?>