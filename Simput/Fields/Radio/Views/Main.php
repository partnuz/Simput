<?php

namespace Simput\Fields\Radio\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();

		foreach( $this -> data[ 'options' ] as $field_key => $field_data ){
		?>
			<input class="smof-field-radio" <?php $this -> viewName(); ?> type="radio" value="<?php echo esc_attr( $field_key ); ?>" <?php checked( $this -> data[ 'data' ], $field_key ); ?> />
			<?php echo htmlspecialchars( $field_data ); ?>
			<br>
		<?php
		}
	}
	
} 



?>