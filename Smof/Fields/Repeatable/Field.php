<?php

class Smof_Fields_Repeatable_Field extends Smof_Fields_ParentRepeatable_Field{

	protected static $properties = array(
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
		
		$this -> assignRepeatableField();
		$this -> isFieldRepeatable();	

	}
	
	function assignData( $data ){

		if( $data !== false && $data !== null && is_array( $data ) && isset( $data[ 0 ]) ){ 
			
			$this -> data = $data;

		}else{
		
			$this -> data = array();
		}
	}
	
	function obtainDefaultOptions(){
		return parent :: obtainDefaultOptions() + array(
			'field' => array( 

			),
			'default' => static :: $properties[ 'default' ]
		);
	}
	
	function assignOptions( $options ){
	
		$this -> options = array_replace_recursive( $this -> default_options, $options );

	}
	
	function assignRepeatableField(){
	
		$this -> repeatable_field_options = $this -> options[ 'options' ];
		
		$exclude_options = array(
		);
		
		foreach( $exclude_options as $option ){
			if( isset( $this -> repeatable_field_options[ $option ] ) ){
				unset( $this -> repeatable_field_options[ $option ] );
			}
		}
		
		$this -> repeatable_field_options[ 'id' ] = '';
		
		
		$this -> repeatable_field_name = $this -> args[ 'subframework' ] -> getArgs( 'framework' ) -> fieldNameCache( $this -> options[ 'options' ][ 'type' ] );
	}
	
	function isFieldRepeatable(){
		
		if( $this -> repeatable_field_name !== false ){
			
			$tmp_field_name = $this -> repeatable_field_name;

			// for php 5.2 compatibility use call_user_func()
			$repeatable_field = call_user_func( array( $tmp_field_name , 'getProperties' ) );
			if( !$repeatable_field[ 'allow_in_fields' ][ 'repeatable' ] ){
				$this -> setOutput(  false );
			}
		}else{
			$this -> setOutput( false );
		}	
		
	}
	
	function initiateFields(){
		
		foreach( $this -> data as $field_key => $field_data ){

			$field = $this -> getCreate() -> createFieldFromOptions(
				$field_data,
				$this -> repeatable_field_options,
				array( 
					'subframework' => $this -> args[ 'subframework' ],
					'name' => $this -> args[ 'name' ] ,
					'id' => $this -> args[ 'id' ],
					'show_description' => false,
					'name_order' => $field_key,
					'id_order' => $field_key,
					'mode' => 'repeatable'
				) 
			);
			
			if( is_object( $field ) ){
				$this -> fields[] = $field;
			}
			
		}
		
	}
	
	function validateData(){
	
		if( !empty( $this -> repeatable_field_options[ 'validate' ] ) ){
	
			$this -> getCreate() -> fieldsValidate( $this -> fields );
					
		}
	
	}
	
	function obtainData(){
				
			$this -> data = $this -> getCreate() -> fieldsSave( $this -> fields );

			
			return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );


	}
	
	
	function bodyView(){

		?>
			<ul>
				<li class="smof-hidden smof-repeatable-pattern-item">
					<?php
					
					$this -> beforeListItemContentView();
					
					$this -> beforeItemContentView();
					
						$repeatable_field = $this -> getCreate() -> createFieldFromOptions(
							false,
							$this -> repeatable_field_options,
							array( 
								'subframework' => $this -> args[ 'subframework' ],
								'name' => $this -> args[ 'name' ] ,
								'id' => $this -> args[ 'id' ],
								'show_description' => false,
								'show_data_name' => true,
								'name_order' => 9999,
								'id_order' => 9999,
								'mode' => 'repeatable'
							) 
						);
						
						$repeatable_field -> view();
					
					$this -> afterItemContentView();
					
					$this -> afterListItemContentView();
					
					?>
				</li>
			<?php
			
			foreach( $this -> fields as $field ){
				?>
				<li>
				<?php
				
				$this -> beforeListItemContentView();
				
				$this -> beforeItemContentView();
				
					$this -> getCreate() -> fieldsView( array( $field ) );
					
				$this -> afterItemContentView();
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