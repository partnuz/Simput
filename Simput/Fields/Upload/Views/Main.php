<?php

namespace Simput\Fields\Upload\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
			
		}
		
		?>
			<input type="button" class="button smof-field-upload-upload-button" value="<?php _e( "Upload" , 'smof'); ?>">
			<input type="button" class="button smof-field-upload-remove-url" value="<?php _e( "Remove" , 'smof'); ?>">
			<div class="smof-field-upload-screenshot"><?php if( !empty( $this -> data[ 'data' ][ 'id' ] ) ){ ?><img src="<?php echo esc_url( $this -> data[ 'screenshot_filename' ] ); ?>"><?php } ?></div>
		<?php
	}
	
} 



?>