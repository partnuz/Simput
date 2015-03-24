<?php

class Smof_Fields_Checkboxes_Field extends Smof_Fields_ParentMulti_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => array(),
			'type' => 'checkboxes',
			'options_as_names' => true
		);
	}
	
	function validateData(){
		
		if( $this -> options[ 'validate' ] ){
			
			$validate = new Smof_Validation();
		
			foreach( $this -> data as $field_key => $field ){
					
				$results[ $field_key ] = $validate -> validate( array( 'data' => $this -> data[ $field_key ]  , 'conditions' => $this -> options[ 'validate' ] ) );
						
			}
			
			if( !empty( $results ) ){
				$this -> validation_results = $results;
				$this -> data = $this -> options[ 'default' ];
			}
	
		}
	}
	
	function obtainData(){
		
		if( !$this -> data ){
			$this -> data = array();
		}
		
		return array( $this -> options[ 'id' ] => $this -> data );
	}

	function bodyView(){
		
		?>
		
		<input class="smof-field smof-field-hidden" id="" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="hidden" value="" />
		
		<?php
		
		foreach( $this -> options[ 'options' ] as $field_key => $field_data ){
		
			$name = $this -> args[ 'name' ];
			$name[] = $field_key;
			
			?>
		
			<input class="smof-field smof-field-checkboxes" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $name ); ?>" type="checkbox" value="1" <?php if( isset( $this -> data[ $field_key ] ) ){ checked( '1', $this -> data[ $field_key ] ); } ?> /><?php echo $field_data; ?>
			</br>
			<?php

		}

	}

}

?>