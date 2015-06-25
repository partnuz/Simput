<?php

class Smof_Fields_Combobox_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single'
	);
	
	protected $options_converted;
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'options' => array(),
			'data_source_format' => false,
			'cache_data_source' => false,
			
		) );
	}
	
	public function encodeOptionsToJson(){
		
		var_dump( current( $this -> options[ 'options' ] ) );
		
		if( is_array( $this -> options[ 'options' ] ) ){
			
			if( is_array( current( $this -> options[ 'options' ] ) ) ) {
				foreach( $this -> options[ 'options' ] as $name => $options ){ 
					
					if( !$this -> framework -> dataSourceExists( $name ) ){
						
						$this -> options_converted[ $name ] = json_encode( $options , JSON_FORCE_OBJECT );
					}
				
				}
			}else{
				
				$this -> options_converted = json_encode( $this -> options[ 'options' ] , JSON_FORCE_OBJECT );
				
			}

		}
	}
	
	public function addOptionsToExternalSource(){
		
		var_dump( reset( $this -> options[ 'options' ] ) );
		
		if( is_array( reset( $this -> options[ 'options' ] ) ) ) {
			foreach( $this -> options_converted as $name => $options ){
				
				if( !$this -> framework -> dataSourceExists( $name ) ){
					$this -> addPrintScriptsContent( $name . '=' .$options . ';' );
				}
			
			}
		}else{
			
			$name = $this -> subframework -> getFieldId( $this -> args[ 'id' ] );
			$this -> addPrintScriptsContent( 'var ' . $name . '=' . $this -> options_converted . ';' );
			
		}

	}
	
	function bodyView(){
		
		$this -> viewValidationResult();
		
		$this -> encodeOptionsToJson();
		
		$this -> addOptionsToExternalSource();

		?>
			<input <?php $this -> viewName(); ?> data-smof-source-name="" class="smof-field-combobox <?php echo $this -> formFieldClass(); ?>" value="<?php echo $this -> data; ?>" >
		
		<?php

	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-combobox', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'combobox/field.css' )  ;
	
	}
	
	function enqueueScripts(){
		 
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-dialog' );	
		wp_enqueue_script( 'jquery-ui-tooltip' );		
		
		wp_register_script( 'smof-field-combobox', $this -> args[ 'subframework' ] -> getUri( 'fields' ) . 'combobox/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-combobox' );
	
	}

}

?>