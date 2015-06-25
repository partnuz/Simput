<?php

class Smof_Fields_Text_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'custom' => false
		) );
	}
	
	function bodyView(){
	
		$this -> viewValidationResult();
		
		?>
		<input class="<?php echo $this -> formFieldClass(); ?>" <?php $this -> viewName(); ?> <?php $this -> addAttributes( $this -> args[ 'attributes' ] ); ?> type="text" value="<?php echo htmlspecialchars($this -> data ); ?>" />
		<?php
	}
	

}

?>