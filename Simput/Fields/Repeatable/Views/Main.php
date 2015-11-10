<?php

namespace Simput\Fields\Repeatable\Views;

class Main extends \Simput\Fields\ParentRepeatable\Views\Main{
	
	protected function bodyView(){

		?>
			<ul>
				<li class="smof-hidden smof-repeatable-pattern-item">
					<?php
					
					$this -> beforeListItemContentView();
					
						$this -> beforeItemContentView();
						
							echo $this -> data[ 'pattern_item' ];
						
						$this -> afterItemContentView();
					
					$this -> afterListItemContentView();
					
					?>
				</li>
			<?php
			
			foreach( $this -> data[ 'fields' ] as $field ){
				?>
				<li>
				<?php
				
				$this -> beforeListItemContentView();
				
					$this -> beforeItemContentView();
					
						echo $field;
						
					$this -> afterItemContentView();
				
				$this -> afterListItemContentView();
				
				
				?>
				</li>
				<?php
			}
			
			
			?>
			</ul>
			<input type="button" value="<?php _e( 'Add new' , 'smof' ); ?>" class="button smof-field-repeatable-add-new">
		<?php
	}

	
} 



?>