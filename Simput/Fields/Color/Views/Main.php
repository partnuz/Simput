<?php

namespace Simput\Fields\Color\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		?>
		<input name="<?php echo esc_attr( $this -> data[ 'name' ] ) ; ?>" class="smof-field-color cs-wp-color-picker <?php echo esc_attr( $this -> data[ 'field_class' ] ); ?>" type="text" value="<?php echo esc_attr( $this -> data[ 'data' ] ); ?>" <?php if( !empty( $this -> data[ 'default' ] ) && empty( $this -> data[ 'data' ] ) ){?>data-default-color=<?php echo esc_attr( $this -> data[ 'default' ] ); }; ?> />
		<?php
	}
	
} 



?>