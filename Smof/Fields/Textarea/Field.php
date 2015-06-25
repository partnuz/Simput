<?php

class Smof_Fields_Textarea_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() , array(
			'default' => ''
		) );
	}
	
	function bodyView(){
		
		$this -> viewValidationResult();
	
	?>
		<textarea <?php $this -> viewName(); ?>><?php echo htmlspecialchars( $this -> data ); ?></textarea>
	
	<?php
	}

}

?>