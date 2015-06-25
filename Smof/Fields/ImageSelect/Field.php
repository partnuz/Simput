<?php

class Smof_Fields_ImageSelect_Field extends Smof_Fields_Parent_Field{

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
			'default' => ''
		) );
	}
	
	function assignNameSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ] =  array( $this -> args[ 'name_order' ] ) ;
			break;
		}
	
	}
	
	function assignIdSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':
				
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] ) ;
			break;
		}
	
	}
	
	
	function bodyView(){
		
		$this -> viewValidationResult();
		
		?>
		<ul class="smof-field-image_select-list">
		<?php
		
		$i = 0;
		
		foreach ( $this -> options[ 'options' ] as $field_key => $field_data ){ 
		$i++;

			$checked = '';
			$selected = '';
			if( null != checked( $this -> data, $field_key, false ) ) {
				$checked = checked( $this -> data , $field_key, false);
				$selected = 'smof-field-image_select-selected';  
			}
			
			$id = $this -> args[ 'id' ];
			$id[] = $i;
			
			?>
			
			<li>
				<input type="radio" class="smof-field-image_select-order-<?php echo $i; ?> smof-field-image_select-radio" value="<?php echo $field_key; ?>" <?php $this -> viewName(); ?> <?php echo $checked; ?> />
				
				<div>
					<img src="<?php echo esc_attr( $field_data ); ?>" alt="" data-smof-order='<?php echo $i; ?>' class="smof-field-image_select-image <?php echo $selected; ?>" />
					<div class="smof-field-image_select-label"><?php echo htmlspecialchars( $field_key ); ?></div>
				</div>
			</li>
			<?php
		}
		
		?>
		</ul>
		<?php			

	}
	
	protected function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-image-select', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'imageSelect/field.css'  );
	
	
	}	
	protected function enqueueScripts(){

		wp_register_script( 'smof-field-image_select', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'ImageSelect/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-image_select' );
	}

}

?>