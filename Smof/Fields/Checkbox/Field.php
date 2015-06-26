<?php

class Smof_Fields_Checkbox_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => 0,
			'type' => 'checkbox'
		);
	}
	
	function assignNameSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ] =  array( $this -> args[ 'name_order' ] ) ;
			break;
		}
	
	}
	
	function assignIdSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':
				
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] ) ;
			break;
		}
	
	}
	
	function bodyView(){
	
		?>
		
		<input class="smof-field smof-field-hidden" id="" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="hidden" value="0" />
		
		<?php

			?>
			<input class="smof-field smof-field-checkbox" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="checkbox" value="1" <?php checked( '1', $this -> data ); ?> /><?php echo $this -> options[ 'options' ]; ?>
		<?php
	}

}

?>