<?php

namespace Simput\Fields\Text\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		?>
		<input class="<?php echo esc_attr( $this -> data[ 'field_class' ]); ?>" <?php $this -> viewName(); ?> <?php $this -> viewDataAttributes( $this -> data[ 'attributes' ] ); ?> type="text" value="<?php echo htmlspecialchars($this -> data[ 'data' ] ); ?>" />
		<?php
	}
	
} 



?>