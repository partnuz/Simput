<?php

class Smof_Fields_Backup_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'id' => 'backup',
			'default' => ''
		) );
	}
	
	public function obtainData(){
		return array();
	}
	
	function bodyView(){
	
	?>
		<textarea <?php $this -> viewName(); ?>><?php echo  $this -> data ; ?></textarea>
		<br>
		<button class="button-primary" value="import" name="smof[action]" type="submit">Import</button>
		<button class="button-primary" value="export" name="smof[action]" type="submit">Export</button>
	
	<?php
	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-backup', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'Backup/field.css' ) ;
	
	}

}

?>