<?php

namespace Simput\Fields\Backup\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		?>
		
		<textarea <?php $this -> viewName(); ?>><?php echo  $this -> data[ 'data' ] ; ?></textarea>
		<br>
		<button class="button-primary" value="import" name="<?php echo esc_attr( $this -> data[ 'button_name' ] ); ?>" type="submit"><?php _e( 'Import' , 'smof-lang' ); ?></button>
		<button class="button-primary" value="export" name="<?php echo esc_attr( $this -> data[ 'button_name' ] ); ?>" type="submit"><?php _e( 'Export' , 'smof-lang' ); ?></button>
		<?php
		
	}
} 



?>