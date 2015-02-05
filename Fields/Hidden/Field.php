<?php

class Smof_Fields_Hidden_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => false
		),
		'category' => 'single'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => ''
		);
	}
	function getDefaultArgs(){
		return parent :: getDefaultArgs() + array(
			'args_name_only' => false
		);
	}
	function setNameSuffix(){
		
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'name_suffix' ] = array();
		}else{
			$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		}
	
	}
	
	function setIdSuffix(){
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'id_suffix' ] = array();
		}else{
			$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		}
	}

	
	function view(){
	
		?>
			<input id="smof-field" class="smof-field smof-field-hidden <?php echo $this -> formFieldClass(); ?>" id="" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="hidden" value="<?php echo $this -> data; ?>" />
		<?php
	}
	
}

?>