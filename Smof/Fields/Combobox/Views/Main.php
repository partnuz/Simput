<?php

namespace Smof\Fields\Combobox\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		?>
			<input <?php $this -> viewName(); ?> data-smof-source-name='<?php echo $this -> data[ 'data_source_names' ]; ?>' class="smof-field-combobox <?php echo esc_attr( $this -> data[ 'field_class' ] ); ?>" value="<?php echo esc_attr( $this -> data[ 'data' ] ); ?>" >
		
		<?php
	}
	
} 



?>