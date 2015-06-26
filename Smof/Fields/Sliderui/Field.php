<?php

class Smof_Fields_Sliderui_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'default' => 1,
			'range' => array( 
				'min' => 0,
				'max' => 1,
				'step' => 0
			),
			'edit' => 'readonly="readonly"'
		);
	}
	
	
	function bodyView(){
	
		?>
		
		<input type="text" <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" id="smof-field<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>-input" value="<?php echo $this -> data; ?>" class="smof-field-sliderui-input <?php echo implode( ' ' , $this -> options[ 'class' ] ); ?> smof-small" <?php echo $this -> options[ 'edit' ] ?> />
		<div id="smof<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>-slider" class="smof-sliderui" style="margin-left: 7px;" data-id="smof-field<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>-input" data-val="<?php echo $this -> data; ?>" data-min="<?php echo $this -> options[ 'range' ][ 'min' ]; ?>" data-max="<?php echo $this -> options[ 'range' ][ 'max' ]; ?>" data-step="<?php echo $this -> options[ 'range' ][ 'step' ]; ?>"></div>
					
		<?php
	}
	
	function enqueueStyles(){
		wp_enqueue_style( 'smof-field-sliderui', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'sliderui/field.css'  );
	}
	
	function enqueueScripts(){
	
		wp_register_script( 'smof-field-sliderui', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'sliderui/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-sliderui' );
	
	}

}

?>