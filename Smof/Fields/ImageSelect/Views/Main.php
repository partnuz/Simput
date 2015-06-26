<?php

namespace Smof\Fields\ImageSelect\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		?>
		<ul class="smof-field-image_select-list">
		<?php
		
		$i = 0;
		
		foreach ( $this -> data[ 'options' ] as $field_key => $field_data ){ 
		$i++;

			$checked = '';
			$selected = '';
			if( null != checked( $this -> data[ 'data' ], $field_key, false ) ) {
				$checked = checked( $this -> data[ 'data' ] , $field_key, false);
				$selected = 'smof-field-image_select-selected';  
			}
			
			/*
			$id = $this -> data[ 'id' ];
			$id[] = $i;
			*/
			
			?>
			
			<li>
				<input type="radio" class="smof-field-image_select-order-<?php echo $i; ?> smof-field-image_select-radio" value="<?php echo $field_key; ?>" <?php $this -> viewName(); ?> <?php echo $checked; ?> />
				
				<div>
					<img src="<?php echo esc_attr( $field_data ); ?>" alt="" data-smof-order='<?php echo $i; ?>' class="smof-field-image_select-image <?php echo $selected; ?>" />
					<div class="smof-field-image_select-label"><?php echo htmlspecialchars( $field_key ); ?></div>
				</div>
			</li>
			<?php
		}
		
		?>
		</ul>
		<?php
	}
	
} 



?>