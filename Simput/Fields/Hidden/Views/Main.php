<?php

namespace Simput\Fields\Hidden\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	public function view(){
		
		?>
		<input class="smof-field smof-field-hidden <?php echo $this -> data[ 'field_class' ]; ?>" id="" <?php $this -> viewName(); ?> type="hidden" value="<?php echo htmlspecialchars( $this -> data[ 'data' ] ); ?>" />
		<?php
	}
	
} 



?>