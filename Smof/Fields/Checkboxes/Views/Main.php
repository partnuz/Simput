<?php

namespace Smof\Fields\Checkboxes\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		?>
		
		<input class="smof-field smof-field-hidden" id="" <?php $this -> viewName(); ?> type="hidden" value="" />
		
		<?php
		
		foreach( $this -> data[ 'options' ] as $field_key => $field_data ){
			
			$this -> viewValidationResults( $field_key );
			
			?>
		
			<input class="smof-field smof-field-checkboxes" <?php $this -> viewName( $field_key ); ?> type="checkbox" value="1" <?php if( isset( $this -> data[ 'data' ][ $field_key ] ) ){ checked( '1', $this -> data[ 'data' ][ $field_key ] ); } ?> /><?php echo htmlspecialchars( $field_data ); ?>
			</br>
			<?php

		}
	}
	
} 



?>