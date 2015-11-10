<?php

namespace Simput\Fields\Slider\Views;

class Main extends \Simput\Fields\ParentRepeatable\Views\Main{
	
	protected function bodyView(){
		
		?>
			<ul>
				<li class="smof-hidden smof-repeatable-pattern-item">
				<?php
				$this -> beforeListItemContentView();
				$this -> beforeItemContentView();
				?>


						<?php
						
						echo $this -> data[ 'pattern_item_title' ];
						
						echo $this -> data[ 'pattern_item_upload' ];
						
						echo $this -> data[ 'pattern_item_description' ];
					
						?>

					<?php
					$this -> afterItemContentView();
					$this -> afterListItemContentView();
					?>
				</li>
			<?php
			
			foreach( $this -> data[ 'items' ] as $fields ){
			
				?>
				<li>
					<?php
					$this -> beforeListItemContentView();
					$this -> beforeItemContentView();
					?>
						<?php
						
						echo $fields[ 'title' ];
						echo $fields[ 'upload' ];
						echo $fields[ 'description' ];

						?>

					<?php
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