<?php

namespace Smof\Fields\Section\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	public function view(){
		
		?>
		<div class="smof-container-<?php echo $this -> data[ 'type' ] ?>" id="smof-container-<?php echo $this -> data[ 'id' ] ; ?>">
		<?php
		$this -> headingView();
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			echo $field;
		}
		
		?>
		</div>
		<?php
	}
	
		protected function headingView(){
			?>
				<?php
				if( !empty( $this -> data[ 'title' ] ) ){
					?>
					<h2><?php echo $this -> data[ 'title' ] ?></h2>
					<?php
				}
				?>
			<?php
		}
	
} 



?>