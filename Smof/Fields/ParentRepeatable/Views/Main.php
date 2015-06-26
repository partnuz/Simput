<?php

namespace Smof\Fields\ParentRepeatable\Views;

abstract class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function beforeContainerView(){
	
		?>
		
		<div class="smof-container smof-repeatable smof-container-<?php echo $this -> data[ 'type' ]; ?> smof_clearfix"  id="smof-container-<?php echo $this -> data[ 'id' ]; ?>" >
		<?php

	}
	
		protected function beforeListItemContentView(){
		?>
		<div class="smof-before-item">
			<span class="smof-icons smof-i-move"></span>
		</div>
		<?php
	}
	
		
		protected function beforeItemContentView(){
			?>
			<div class="<?php if( $this -> data[ 'toggle' ] ){ ?>smof-toggle<?php }else{ ?>smof-item<?php } ?>">
				
				<?php
				if( $this -> data[ 'toggle' ]){
					
					?>
					<div class="header">
						<div class="toggle smof-icons"></div>
					</div>
					<div class="body">
					<?php
				}
			
		}
		
		protected function afterItemContentView(){
				if( $this -> data[ 'toggle' ]){
					?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	
	protected function afterListItemContentView(){
		?>
		<div class="smof-after-item">
			<span class="smof-repeatable-delete smof-icons smof-i-delete"></span>
		</div>
		<?php
	}
		
		protected function addNewButtonView(){
			?>
			<span class="smof-repeatable-add-new button">Add New</span>
			<?php
		}
	
} 



?>