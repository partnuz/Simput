<?php

class Smof_Fields_Checkboxes_Field extends Smof_Fields_ParentMulti_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'multiple'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => array(),
			'type' => 'checkboxes',
			'options_as_names' => true
		);
	}

	function bodyView(){
		
		$hidden = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
			'' ,
			array(
				'id' => $this -> options [ 'id' ],
				'type' => 'hidden'
			),
			array(
				'subframework' => $this -> args[ 'subframework' ],
				'name' => $this -> args[ 'name' ],
				'show_data_name' => $this -> args[ 'show_data_name' ],
				'args_name_only' => true
			)
		);
		
		$hidden -> view();

		
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