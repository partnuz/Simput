<?php

class Smof_Fields_Repeatable_Field extends Smof_Fields_ParentRepeatable_Field{

	public static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => false,
			'group' => true
		),
		'inheritance' => 'parent',
		'default' => array(),
		'category' => 'repeatable'
	);
	
	protected $repeatable_field_options;
	protected $repeatable_field_name;
	
	function __construct( $options , array $args  ){
		
	
		parent :: __construct( $options , $args  );
		
		$this -> setRepeatableField();
		$this -> isFieldRepeatable();	

	}
	
	protected function setPatternData( $option , $parent_properties ){
	
		$data = false;
		
		if( isset( $this -> args[ 'subframework' ] -> args[ 'framework' ] -> fields_properties[ $option[ 'type' ] ] ) ){
			$field_properties = $this -> args[ 'subframework' ] -> args[ 'framework' ] -> fields_properties[ $option[ 'type' ] ];
			
		}
		
		if( isset( $field_properties ) ){
			if( $field_properties[ 'inheritance' ] !== false ){
				
				if( $field_properties[ 'inheritance' ] === 'parent_children' && $field_properties[ 'category' ] === 'multiple' && !empty( $parent_properties[ 'allow_in_fields' ][ 'group' ]) ){
					foreach( $option[ 'fields' ] as $option_key => $option_val ){
						$data[ $option[ 'id' ] ][ $option_key ] = $this -> setPatternData( $option_val , $field_properties );
					}
				}elseif( $field_properties[ 'inheritance' ] === 'children' && $field_properties[ 'category' ] === 'repeatable' && !empty( $parent_properties[ 'allow_in_fields' ][ 'repeatable' ] )  ){
					$data = $this -> setPatternData( $option[ 'options' ] , $field_properties );
				}
			

			}else{
				if( isset( $option[ 'default' ] ) ){
					$data = $option[ 'default' ];
				}
			}
				
		}
		
		return $data;
	}
	
	public function setData( $data ){
	
		if( $data !== false && $data !== null && ( is_array( $data ) && !empty( $data ) ) ){
			
			$default_pattern = $this -> setPatternData( $this -> repeatable_field_options , static :: $properties );
			
			foreach( $data as $data_key => $data_val ){
			

				if( is_array( $data_val ) && is_array( $default_pattern ) && $default_pattern !== false ){
					$this -> data[ $data_key ] = array_replace_recursive(  $default_pattern , $data_val );
				}else{
					$this -> data[ $data_key ] = $data_val;
				}
				
			}
			
			
		}else{

			$this -> data = $this -> options[ 'default' ] ;
		}
		
	}
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'field' => array( 

			),
			'default' => static :: $properties[ 'default' ]
		);
	}
	
	function setNameSuffix(){
		$this -> args[ 'name_suffix' ] = array();
	}
	
	function setNameId(){
		$this -> args[ 'id_suffix' ] = array();
	}
	
	function setOptions( $options ){
	
		$this -> options = array_replace_recursive( $this -> default_options, $options );

	}
	
	function setRepeatableField(){
	
		$this -> repeatable_field_options = $this -> options[ 'options' ];
		
		$exclude_options = array(
		);
		
		foreach( $exclude_options as $option ){
			if( isset( $this -> repeatable_field_options[ $option ] ) ){
				unset( $this -> repeatable_field_options[ $option ] );
			}
		}
		
		$this -> repeatable_field_options[ 'id' ] = $this -> options[ 'id' ];
		
		
		$this -> repeatable_field_name = $this -> args[ 'subframework' ] -> args[ 'framework' ] -> fieldNameCache( $this -> options[ 'options' ][ 'type' ] );
	}
	
	function isFieldRepeatable(){
		
		if( $this -> repeatable_field_name !== false ){
			
			$tmp_field_name = $this -> repeatable_field_name;

			// for php 5.2 compatibility use call_user_func()
			$repeatable_field = call_user_func( array( $tmp_field_name , 'getProperties' ) );
			if( !$repeatable_field[ 'allow_in_fields' ][ 'repeatable' ] ){
				$this -> set( 'output' , false );
			}
		}else{
			$this -> set( 'output' , false );
		}	
		
	}
	
	public function initiateFields(){
		$i = 0;
		foreach( $this -> data as $field_data ){
			$field = $this -> args[ 'subframework' ] -> singleFieldWithoutView(
				$field_data,
				$this -> repeatable_field_options,
				array( 
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'show_body_id' => false ,
					'show_description' => false,
					'name_order' => $i,
					'id_order' => $i,
					'mode' => 'repeatable'
				) 
			);
			
			if( is_object( $field ) ){
				$this -> fields[] = $field;
			}
			
			$i++;
		}
	}
	
	public function validateData(){
	
		if( !empty( $this -> repeatable_field_options[ 'validate' ] ) ){
	
			$this -> data = $this -> args[ 'subframework' ] -> fieldLoopValidate( $this -> fields );
					
		}
	
	}
	
	public function getValidatedData(){
		return array( $this -> options[ 'id' ] => $this -> data );
	}
	
	
	function bodyView(){
		?>
			<ul>
				<li class="smof-hidden_">
					<?php
					
					$this -> beforeListItemContentView();
					
						$repeatable_field = $this -> args[ 'subframework' ] -> singleFieldWithoutView(
							false,
							$this -> repeatable_field_options,
							array( 
								'subframework' => $this -> args[ 'subframework' ],
								'name' => $this -> args[ 'name' ] ,
								'show_body_id' => false ,
								'show_description' => false,
								'show_data_name' => true,
								'name_order' => 9999,
								'id_order' => 9999,
								'mode' => 'repeatable'
							) 
						);
						
						$repeatable_field -> view();
						
					$this -> afterListItemContentView();
					
					?>
				</li>
			<?php
			
			foreach( $this -> fields as $field ){
				?>
				<li>
				<?php
				$this -> beforeListItemContentView();
				
					$this -> args[ 'subframework' ] -> fieldLoopView( array( $field ) );
				
				$this -> afterListItemContentView();
				?>
				</li>
				<?php
			}
			
			
			?>
			</ul>
			<input type="button" value="<?php _e( 'Add new' , 'smof' ); ?>" class="button smof-field-repeatable-add-new">
		<?php
	}

}

?>