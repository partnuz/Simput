<?php

abstract class Smof_Fields_ParentRepeatable_Field extends Smof_Fields_Parent_Field{

	function setData( $data ){
	
		if( $data !== false && $data !== null && ( is_array( $data ) && !empty( $data ) ) ){
			
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
	
	public function validateData(){
		foreach( $this -> data as $data_key => $data_val ){
		
			if( !empty( $this -> options[ 'validate' ] ) ){
		
				$validate = new Smof_Validation();
				if( is_array( $this -> options[ 'validate' ] ) ){
				
					foreach( $this -> options[ 'validate' ] as $validation_item => $validate_option ){
					
						$results = $validate -> validate( array( 'data' => $this -> data[ $validation_item ]  , 'conditions' => $this -> options[ 'validate' ][ $validation_item ] ) );
						
						if( !empty( $results ) ){
							$this -> validationResults[ $data_key ][ $validation_item ] = $results;
							$this -> data[ $data_key ][ $validation_item ] = $this -> options[ 'default' ][ $validation_item ] ;
						}
						
					}
				
				}else{
				
				}
			
			}
		}
	}
	
	
	// suffix is NOT FULL for this type of fields
	function setNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
	
	}
	
	// suffix is NOT FULL for this type of fields
	function setIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
	
	}

	
	function beforeListItemContentView(){
		?>
		<span class="smof-icons smof-i-move"></span>
		<div class="smof-item">
		<?php
	}
	
	function afterListItemContentView(){
		?>
		</div>
		<span class="smof-repeatable-delete smof-icons smof-i-delete"></span>
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
	
		wp_enqueue_style( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'ParentRepeatable/style.css'  );
	
	}
	
	function enqueueScripts(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_register_script( 'smof-field-parent_repeatable', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'ParentRepeatable/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-parent_repeatable' );
	
	}
	
}

?>