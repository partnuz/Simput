<?php

class Smof_Fields_Select_Field extends Smof_Fields_Parent_Field{

	protected static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single_multiple'
	);
	
	function obtainDefaultOptions(){
		return array_merge_recursive( parent :: obtainDefaultOptions() ,array(
			'default' => '',
			'type' => 'select',
			'multiple' => false,
			'options' => array(),
		) ) ;
	}

	function __construct( $options , array $args ){
	
		$this -> assignInstance();
		
		$this -> assignDefaultOptions();
		
		if( isset( $options[ 'multiple' ] ) ){
			$this -> default_options[ 'default' ] = array();
		}
		
		$this -> assignDefaultArgs();
	
		$this -> assignOptions( $options  );

		$this -> assignArgs( $args  );
		
		$this -> assignNameSuffix();
		
		$this -> assignName();
		
		$this -> assignIdSuffix();
		
		$this -> assignId();
		
		$this -> enqueueAll();

	}
	
	function assignNameSuffix(){
	
		
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
				
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] , null );
				}
				
			break;
			case 'repeatable':	
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ][] =  $this -> args[ 'id_order' ] ;
					$this -> args[ 'name_suffix' ][] = null;
					
				}else{
					$this -> args[ 'name_suffix' ] = array( $this -> args[ 'id_order' ] );
				}
				
			break;
		}
	
	}
	
	function assignIdSuffix(){
	
		
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			
			break;
			case 'repeatable':
			
				$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] );
				
			break;
		}
	
	}
	
	function validateData(){
		
		if( $this -> options[ 'validate' ] ){
		
			if( $this -> options[ 'multiple' ] !== false ){
				
				$validate = new Smof_Validation();
				
				foreach( $this -> data as $field_key => $field ){
						
					$results[ $field_key ] = $validate -> validate( array( 'data' => $this -> data[ $field_key ]  , 'conditions' => $this -> options[ 'validate' ] ) );
							
				}
				
				if( !empty( $results ) ){
					$this -> validation_results = $results;
					$this -> data = $this -> options[ 'default' ];
				}
			}else{
				
				parent :: validateData();
			}
		
		}
		
	}
	
	public function viewValidationResult( ){
		if( $this -> options[ 'multiple' ] ){
					
			if( !empty( $this -> validation_results ) ) {

				foreach( $this -> validation_results as $key => $result ){
					
					var_dump( $result );
					
				}
				
			}
			
		}else{
			
			parent :: viewValidationResult();
		}
	}
	
	
	function bodyView(){

		?>
		<select <?php $this -> viewName(); ?> <?php if( $this -> options[ 'multiple' ] ){ echo 'multiple="multiple"'; } ?> class="<?php echo $this -> formFieldClass(); ?>" <?php $this -> addAttributes( $this -> args[ 'attributes' ] ); ?> >
			<?php
			foreach( $this -> options[ 'options' ] as $field_key => $field_data ){
				?>
				<option class="" type="text" <?php if( $this -> options[ 'multiple' ] ){ selected( in_array( $field_key, $this -> data )  , true ); }else{ selected( $this -> data  , $field_key ); } ?> value="<?php echo esc_attr( $field_key ); ?>">
				<?php echo htmlspecialchars( $field_data ); ?>
				</option>
			<?php } ?>
		</select>
		<?php

	}

}

?>