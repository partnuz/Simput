<?php

abstract class Smof_Fields_ParentRepeatable_Field extends Smof_Fields_Parent_Field{

	function assignData( $data ){
	
		if( $data !== false && $data !== null && ( is_array( $data ) && !empty( $data ) && isset( $data[ 0 ] ) ) ){
			
			$default_pattern = ( isset( $this -> options[ 'default' ] ) ) ? $this -> options[ 'default' ] : false ;
			
			foreach( $data as $data_key => $data_val ){

				if( is_array( $data_val ) && is_array( $default_pattern ) && $default_pattern !== false ){
					$this -> data[ $data_key ] = array_replace_recursive(  $default_pattern , $data_val );

				}else{
					$this -> data[ $data_key ] = $data_val;
				}
				
			}
			
		}else{

			$this -> data = array();
		}

	}
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'toggle' => false
		);
	}
	
	public function validateData(){
		foreach( $this -> data as $data_key => $data_val ){
		
			if( is_array( $this -> options[ 'validate' ] ) && $this -> options[ 'validate' ] ){
		
				$validate = new Smof_Validation();
				
				if( $this -> fields ){
					
					$this -> getCreate() -> fieldsValidate( $this -> fields[ $data_key ] );
					
				}else{
					
						foreach( $this -> options[ 'validate' ] as $validation_item => $validate_option ){
						
							$results = $validate -> validate( array( 'data' => $this -> data[ $data_key ][ $validation_item ]  , 'conditions' => $this -> options[ 'validate' ][ $validation_item ] ) );
							
							if( !empty( $results ) ){
								$this -> validationResults[ $data_key ][ $validation_item ] = $results;
								$this -> data[ $data_key ][ $validation_item ] = $this -> options[ 'default' ][ $validation_item ] ;
							}
							
						}
					
				}
			
			}
		}
	}
	
	function obtainData(){
		
		if( $this -> fields ){
			
			foreach( $this -> fields as $field_key => $fields ){
				
				$this -> data[ $field_key ] = $this -> getCreate() -> fieldsSave( $fields );
			}
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $data );
			
		}else{
			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
			
		}
		
	}
	
	
	// suffix is NOT FULL for this type of fields
	function assignNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
	
	}
	
	// suffix is NOT FULL for this type of fields
	function assignIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
	
	}

	
	function beforeListItemContentView(){
		?>
		<div class="smof-before-item">
			<span class="smof-icons smof-i-move"></span>
		</div>
		<?php
	}
	
	function afterListItemContentView(){
		?>
		<div class="smof-after-item">
			<span class="smof-repeatable-delete smof-icons smof-i-delete"></span>
		</div>
		<?php
	}
	
	function beforeItemContentView(){
		?>
		<div class="<?php if( $this -> options[ 'toggle' ] ){ ?>smof-toggle<?php }else{ ?>smof-item<?php } ?>">
			
			<?php
			if( $this -> options[ 'toggle' ]){
				
				?>
				<div class="header">
					<div class="toggle smof-icons"></div>
				</div>
				<div class="body">
				<?php
			}
		
	}
	
	function afterItemContentView(){
			if( $this -> options[ 'toggle' ]){
				?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}
	
	
	function addNewButtonView(){
		?>
		<span class="smof-repeatable-add-new button">Add New</span>
		<?php
	}
	
	function beforeContainerView(){
	
		?>
		
		<div class="smof-container smof-repeatable smof-container-<?php echo $this -> options[ 'type' ] ?> smof_clearfix"  id="smof-container<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>" >
		<?php

	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ParentRepeatable/style.css' )  ;
	
	}
	
	function enqueueScripts(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_register_script( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ParentRepeatable/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-parent_repeatable' );
	
	}
	
}

?>