<?php

namespace Simput\Fields\ParentField\Views;

abstract class Main{
	
	protected $data;
	protected $args;
	
	function __construct( $data = array() , $args = array() ){
		
		$this -> assignArgs( $args );
		$this -> setData( $data );

		
	}
	
	// args not related to displaying
	protected function obtainDefaultArgs(){
		
		return array( 
		);
		
	}
	
	protected function assignArgs( $args ){
		
		$this -> args = array_merge_recursive( $this -> obtainDefaultArgs() , $args );
		
	}
	
	public function setData( $key_data , $value = null ){
		
		if( $value === null ){
			$this -> data = $key_data;
		}else{
			$this -> data[ $key_data ] = $value;
		}
	}
	
	public function view(){
		
		$this -> beforeContainerView();
		
			$this -> beforeHeaderView();
			
				$this -> headingView();
				
				$this -> descriptionView();	
				
			$this -> afterHeaderView();
		
			$this -> beforeBodyView();
			
				$this -> bodyView();
			
			$this -> afterBodyView();
			
		$this -> afterContainerView();
		
	}
	
	protected function beforeContainerView(){
		
		?>
		
		<div class="smof-container smof-container-<?php echo $this -> data[ 'type' ]; ?> smof_clearfix"  id="smof-container-<?php echo $this -> data[ 'id' ]; ?>" >
		<?php

	}
	
		protected function beforeBodyView(){
		
			?>
			<div class="smof-field-body">
			<?php
		}
		
		protected function afterBodyView(){

			?>
			</div>
			<?php
			
		}
		
		protected function beforeHeaderView(){

			if( !empty( $this -> data[ 'title' ] ) || !empty( $this -> data[ 'description' ] ) ){
				?>
				<div class="smof-field-header">
				<?php
			}
		}
		
			protected function headingView(){
				?>
					<?php
					if( !empty( $this -> data[ 'title' ] ) ){
						?>
						<h3><?php echo $this -> data[ 'title' ] ?></h3>
						<?php
					}
					?>
				<?php
			}
			
			protected function descriptionView(){
				if( !empty( $this -> data[ 'description' ] ) ){
					?>
					<div class="smof-field-description">
						<?php echo $this -> data[ 'description' ]; ?>
					</div>
					<?php
				}
			}
		
		protected function afterHeaderView(){
			if( !empty( $this -> data[ 'title' ] ) || !empty( $this -> data[ 'description' ] ) ){
				?>
				</div>
				<?php
			}

		}
	
	protected function afterContainerView(){
	
		?>
		</div>
		<?php

	}
	
	protected function viewName( $name_suffix = '' ){
		
		$name = ( isset( $this -> data[ 'name_suffixes' ] ) && $name_suffix ) ? $this -> data[ 'name_suffixes' ][ $name_suffix ] :  $this -> data[ 'name' ] ;
		

			if( $this -> data[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo esc_attr( $name ) ;?>"
			<?php

		
	}
	
	public function viewValidationResults(){
		
		if( !empty( $this -> data[ 'validation_results' ] ) ){

			var_dump( $this -> data[ 'validation_results' ] );

			
		}
	}
	
	protected function viewDataAttributes( array $attributes ){
		foreach( $attributes as $attribute => $attribute_value ){
			?>data-smof-<?php echo $attribute;?>='<?php echo $attribute_value;?>' <?php
		}
	}
	
} 



?>