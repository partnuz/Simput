<?php

class Smof_Fields_Checkbox_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => 0,
			'type' => 'checkbox'
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
	

		
		?>
		
			<?php
			
			$hidden = $this -> args[ 'subframework' ] -> singleFieldWithoutView( 
				0 ,
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

			?>
			<input class="smof-field smof-field-checkbox" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="checkbox" value="1" <?php checked( '1', $this -> data ); ?> /><?php echo $this -> options[ 'options' ]; ?>
		<?php
	}

}

?>