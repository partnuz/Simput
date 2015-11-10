<?php

namespace Simput\Fields\Typography\Views;

class Main extends \Simput\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$i = 1;
		$maxI = count( $this -> data[ 'fields' ] );
		
		foreach( $this -> data[ 'fields' ] as $field ){
			
			if( $i % 2 == 1 ){
				?>
				<div class="grid-container">
				<?php
			}
			
			echo $field;
			
			if( $i % 2 == 0 || $i === $maxI ){
				?>
				</div>
				<?php
			}
			
			$i++;
			
		}
			
		if( $this -> data[ 'show' ][ 'preview' ] ){
			
			?><p class="smof-font-preview"><?php echo $this -> data[ 'default' ][ 'preview' ]; ?></p>
			<?php
		
		}
	}
	
} 



?>