<?php

class Smof_Fields_Text_Field extends Smof_Fields_Parent_Field{

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
			'default' => '',
			'custom' => false
		);
	}
	
	function bodyView(){
	
		
		if( !empty( $this -> validation_results ) ){
			var_dump( $this -> validation_results );
		}

		?>
		<input class="<?php echo $this -> formFieldClass(); ?>" id="smof-field<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] , array() ); ?>" <?php $this -> addAttributes( $this -> args[ 'attributes' ] ); ?> type="text" value="<?php echo htmlspecialchars($this -> data ); ?>" />
		<?php
	}
	

}

?>