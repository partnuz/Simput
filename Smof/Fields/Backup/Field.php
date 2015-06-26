<?php

namespace Smof\Fields\Backup;
class Field extends \Smof\Fields\ParentField\Field{

	protected static $properties = array(
		'allow_in_fields' => array(
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	protected function obtainDefaultOptions(){
		return array_replace_recursive( parent :: obtainDefaultOptions() ,array(
			'id' => 'backup',
			'default' => ''
		) );
	}
	
	public function obtainData(){
		return array();
	}
	
	public function controller(){
	
	?>
		<textarea <?php $this -> viewName(); ?>><?php echo  $this -> data ; ?></textarea>
		<br>
		<button class="button-primary" value="import" name="smof[action]" type="submit">Import</button>
		<button class="button-primary" value="export" name="smof[action]" type="submit">Export</button>
	
	<?php
	}
	
	public function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-backup', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'Backup/field.css' ) ;
	
	}

}

?>