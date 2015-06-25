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
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => 1,
			'range' => array( 
				'min' => 0,
				'max' => 1,
				'step' => 0
			),
			'edit' => 'readonly="readonly"'
		) );
	}
	
	
	function bodyView(){
		
		$this -> viewValidationResult();
	
		?>
		
		<input type="text" <?php $this -> viewName(); ?> id="smof-field-<?php echo $this -> args[ 'subframework' ] -> getFieldId( $this -> args[ 'id' ] ); ?>-input" value="<?php echo esc_attr( $this -> data ); ?>" class="smof-field-sliderui-input <?php echo implode( ' ' , $this -> options[ 'class' ] ); ?> smof-small" <?php echo $this -> options[ 'edit' ] ?> />
		<div id="smof-<?php echo $this -> args[ 'subframework' ] -> getFieldId( $this -> args[ 'id' ] ); ?>-slider" class="smof-sliderui" style="margin-left: 7px;" data-id="smof-field-<?php echo $this -> args[ 'subframework' ] -> getFieldId( $this -> args[ 'id' ] ); ?>-input" data-val="<?php echo htmlspecialchars( $this -> data ); ?>" data-min="<?php echo esc_attr( $this -> options[ 'range' ][ 'min' ] ); ?>" data-max="<?php echo esc_attr( $this -> options[ 'range' ][ 'max' ] ); ?>" data-step="<?php echo esc_attr( $this -> options[ 'range' ][ 'step' ] ); ?>"></div>
					
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