<?php

class Smof_Fields_Combobox_Field extends Smof_Fields_Parent_Field{

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
			'options' => array(),
			'data_source_format' => false,
			'cache_data_source' => false,
			
		);
	}
	
	
	function bodyView(){

		?>

			<select <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] , array() ); ?>" <?php if( $this -> options[ 'data_source_format' ] !== false ){?>data-smof-data-source-format="<?php echo $this -> options[ 'data_source_format' ] ;?>"<?php } ?> class="smof-field-combobox <?php echo $this -> formFieldClass(); ?>" >
			
				<?php
				
				switch( $this -> options[ 'data_source_format' ]){
					case false:
						foreach( $this -> options[ 'options' ] as $field_key => $field_data ){
						
							if( !is_array( $field_data ) ){
								?>
								<option type="text" <?php selected( $this -> data  , $field_key ); ?> value="<?php echo $field_key; ?>" ><?php echo $field_data; ?></option>
								<?php
								
							}else{
								$attributes = $field_data;
								unset( $attributes[ 'value' ] );
								?>
								<option type="text" <?php selected( $this -> data  , $field_key ); ?> value="<?php echo $field_key; ?>" <?php $this -> addAttributes( $attributes ); ?> ><?php echo $field_data[ 'value' ]; ?></option>
								<?php
							}

						}
					break;
					case 'html':

							
						
						// output
						if( $this -> options[ 'cache_data_source' ] ){
							// print only once than build using js
							// printScripts with id
							foreach( $this -> options[ 'options' ] as $data_source_name => $data_source_data ){

								$this -> args[ 'subframework' ] -> args[ 'framework' ] -> addToPrintDataSources( $data_source_name , $data_source_data , array( 'before' => '<select id="smof-data-source-'.$data_source_name.'">' , 'after' => '</select>' ) );
								
								// append current combobox NOT FINISHED
								$this -> addPrintScriptsContent( 'jQuery(function(){
									jQuery("#smof-container'. $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ).' .smof-field-helper-combobox").append(jQuery("#smof-data-source-'.$data_source_name.' option"));
								});' );
								
							}
							
							// select it
							$this -> addPrintScriptsContent( 'jQuery(function(){
								jQuery("#smof-container'. $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ).' .smof-field-combobox option[value=\''.$this -> data.'\']").attr("selected", "selected");
							});' );
						}else{
							foreach( $this -> options[ 'options' ] as $data_source_key => $data_source_data ){
								echo $data_source_data;
							}
							
							$this -> addPrintScriptsContent( 'jQuery(function(){
								jQuery("#smof-container'. $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ).' .smof-field-combobox option[value=\''.$this -> data.'\']").attr("selected", "selected");
								
	
							});' );
						}

					break;
					case 'json':
						// output once in a footer, then append using js
					break;
				}
				?>
			</select>
		
		<?php

	}
	
	function enqueueStyles(){
	
		wp_enqueue_style( 'smof-field-combobox', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'combobox/field.css'  );
	
	}
	
	function enqueueScripts(){
		 
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-widget' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_script( 'jquery-ui-dialog' );	
		wp_enqueue_script( 'jquery-ui-tooltip' );		
		
		wp_register_script( 'smof-field-combobox', $this -> args[ 'subframework' ] -> uri[ 'fields' ] . 'combobox/script.js', array( 'jquery' ) );
		wp_enqueue_script( 'smof-field-combobox' );
	
	}

}

?>