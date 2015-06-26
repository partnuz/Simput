<?php

class Smof_Fields_Radio_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => 0,
			'type' => 'radio'
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

			foreach( $this -> options[ 'options' ] as $field_key => $field_data ){
			?>
				<input class="smof-field-radio" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="radio" value="<?php echo $field_key; ?>" <?php checked( $this -> data, $field_key ); ?> />
				<?php echo $field_data; ?>
				<br>
			<?php
			}

	}
	
}

?>