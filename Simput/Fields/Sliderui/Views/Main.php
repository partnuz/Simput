<?php

namespace Simput\Fields\Sliderui\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
	
		?>
		
		<input type="text" <?php $this -> viewName(); ?> id="smof-field-<?php echo esc_attr( $this -> data[ 'id' ] ) ; ?>-input" value="<?php echo esc_attr( $this -> data[ 'data' ] ); ?>" class="smof-field-sliderui-input <?php echo esc_attr( $this -> data[ 'field_class' ] ) ; ?> smof-small" readonly="<?php echo esc_attr( $this -> data[ 'edit' ] ); ?>" />
		<div id="smof-<?php echo esc_attr( $this -> data[ 'id' ] ); ?>-slider" class="smof-sliderui" style="margin-left: 7px;" data-id="smof-field-<?php echo esc_attr( $this -> data[ 'id' ] ); ?>-input" data-val="<?php echo esc_attr( $this -> data[ 'data' ] ); ?>" data-min="<?php echo esc_attr( $this -> data[ 'range' ][ 'min' ] ); ?>" data-max="<?php echo esc_attr( $this -> data[ 'range' ][ 'max' ] ); ?>" data-step="<?php echo esc_attr( $this -> data[ 'range' ][ 'step' ] ); ?>"></div>
					
		<?php
	}
	
} 



?>