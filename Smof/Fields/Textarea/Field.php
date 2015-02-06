<?php

class Smof_Fields_Textarea_Field extends Smof_Fields_Parent_Field{

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
			'default' => ''
		);
	}
	
	function bodyView(){
	
	?>
		<textarea <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] , array() ); ?>"><?php echo htmlspecialchars( $this -> data ); ?></textarea>
	
	<?php
	}

}

?>