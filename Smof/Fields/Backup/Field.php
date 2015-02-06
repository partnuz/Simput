<?php

class Smof_Fields_Backup_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
		),
		'inheritance' => false,
		'category' => 'single'
	);

	public $default_options = array(

			
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'id' => 'backup',
			'default' => ''
		);
	}
	
	function bodyView(){
	
	?>
		<textarea <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] , array() ); ?>"><?php echo $this -> data; ?></textarea>
		<br>
		<button class="button-primary" value="import" name="smof[action]" type="submit">Import</button>
		<button class="button-primary" value="export" name="smof[action]" type="submit">Export</button>
	
	<?php
	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-backup', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'Backup/field.css'  );
	
	}

}

?>