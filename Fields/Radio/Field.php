<?php

class Smof_Fields_Radio_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => 0,
			'type' => 'radio'
		);
	}
	
	function setNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ][] =  $this -> args[ 'name_order' ] ;
			break;
		}
	
	}
	
	function setIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				
			break;
			case 'repeatable':
				
				$this -> args[ 'id_suffix' ][] = $this -> args[ 'name_order' ] ;
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