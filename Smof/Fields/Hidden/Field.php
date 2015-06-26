<?php

class Smof_Fields_Hidden_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => false
		),
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => ''
		);
	}
	function obtainDefaultArgs(){
		return parent :: obtainDefaultArgs() + array(
			'args_name_only' => false
		);
	}
	function assignNameSuffix(){
		
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'name_suffix' ] = array();
		}else{
			$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		}
	
	}
	
	function assignIdSuffix(){
		if( $this -> args[ 'args_name_only' ] == true ){
			$this -> args[ 'id_suffix' ] = array();
		}else{
			$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		}
	}

	
	function view(){
	
		?>
			<input class="smof-field smof-field-hidden <?php echo $this -> formFieldClass(); ?>" id="" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" type="hidden" value="<?php echo $this -> data; ?>" />
		<?php
	}
	
}

?>