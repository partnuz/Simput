<?php

namespace Simput\Fields\Switcher\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		/*
		$fold = '';
		if (array_key_exists("folds",$value)) $fold="s_fld ";
		*/
		?>
		<p class="switch-options">

			<label class="smof-field-switch-enable <?php if(  $this -> data[ 'data' ] == 1 ){?>selected<?php }; ?>" data-id="<?php echo esc_attr( $this -> data[ 'id' ] ); ?>"><span><?php echo esc_attr( $this -> data[ 'options' ][ 'on' ] ); ?></span></label>
			<label class="smof-field-switch-disable <?php if(  $this -> data[ 'data' ] == 0 ){?>selected<?php }; ?>" data-id="<?php echo esc_attr( $this -> data[ 'id' ] ); ?>"><span><?php echo $this -> data[ 'options' ][ 'off' ]; ?></span></label>
			
			<input type="hidden" class="smof-field-checkbox" <?php $this -> viewName() ; ?> value="0"/>
			<input type="checkbox" id="smof-field-<?php echo esc_attr( $this -> data[ 'id' ] ); ?>"  class="smof-field-checkbox smof-field-switch-checkbox" name="<?php echo esc_attr( $this -> data[ 'name' ] ); ?>"  value="1" <?php checked( $this -> data[ 'data' ], 1 ); ?> />
		
		</p>
			
		<?php
	}
	
} 



?>