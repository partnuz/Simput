<?php

namespace Simput\Fields\Select\Views;

class Main extends \Smof\Fields\ParentField\Views\Main{
	
	protected function bodyView(){
		
		$this -> viewValidationResults();
		
		?>
		<select <?php $this -> viewName(); ?> <?php if( $this -> data[ 'multiple' ] ){ echo 'multiple="multiple"'; } ?> class="<?php echo esc_attr( $this -> data[ 'field_class' ] ); ?>" <?php 
		$this -> viewDataAttributes( $this -> data[ 'attributes' ]); ?> >
			<?php
			foreach( $this -> data[ 'options' ] as $field_key => $field_data ){
				?>
				<option class="" type="text" <?php if( $this -> data[ 'multiple' ] ){ selected( in_array( $field_key, $this -> data[ 'data'] )  , true ); }else{ selected( $this -> data[ 'data']  , $field_key ); } ?> value="<?php echo esc_attr( $field_key ); ?>">
				<?php echo htmlspecialchars( $field_data ); ?>
				</option>
			<?php } ?>
		</select>
		<?php
		
	}
	
	public function viewValidationResults( ){
		if( $this -> data[ 'multiple' ] ){
					
			if( !empty( $this -> validation_results ) ) {

				foreach( $this -> validation_results as $key => $result ){
					
					var_dump( $result );
					
				}
				
			}
			
		}else{
			
			parent :: viewValidationResults();
		}
	}
	
} 



?>