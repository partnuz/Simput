<?php

class Smof_Fields_Select_Field extends Smof_Fields_Parent_Field{

	static $properties = array(
		'allow_in_fields' => array(
			'repeatable' => true,
			'group' => true
		),
		'inheritance' => false,
		'category' => 'single_multiple'
	);
	
	function getDefaultOptions(){
		return parent :: getDefaultOptions() + array(
			'default' => '',
			'type' => 'select',
			'multiple' => false,
			'options' => array(),
		);
	}

	function __construct( $options , array $args ){
	
		$this -> setInstance();
		
		$this -> setDefaultOptions();
		
		if( isset( $options[ 'multiple' ] ) ){
			$this -> default_options[ 'default' ] = array();
		}
		
		$this -> setDefaultArgs();
	
		$this -> setOptions( $options  );

		$this -> setArgs( $args  );
		
		$this -> setNameSuffix();
		
		$this -> setName();
		
		$this -> setIdSuffix();
		
		$this -> setId();
		
		$this -> enqueueAll();

	}
	
	function setNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ][] = null;
				}
			break;
			case 'repeatable':	
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'name_suffix' ][] =  $this -> args[ 'name_order' ] ;
					$this -> args[ 'name_suffix' ][] = null;
					
				}else{
					$this -> args[ 'name_suffix' ][] = null;
				}
				
			break;
		}
	
	}
	
	function setIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'id_suffix' ][] = null;
				}
			break;
			case 'repeatable':
				if( $this -> options[ 'multiple' ] !== false ){
					$this -> args[ 'id_suffix' ][] = $this -> args[ 'id_order' ];
				}else{
					$this -> args[ 'id_suffix' ][] =  $this -> args[ 'name_order' ] ;
					$this -> args[ 'id_suffix' ][] = $this -> args[ 'id_order' ];
				}
				
			break;
		}
		
		
	
	}
	
	
	function bodyView(){

		?>
		<select <?php if( $this -> args[ 'show_data_name' ] ){ ?>data-smof-<?php } ?>name="<?php echo $this -> args[ 'subframework' ] -> setFieldName( $this -> args[ 'name' ] ); ?>" <?php if( $this -> options[ 'multiple' ] ){ echo 'multiple="multiple"'; } ?> class="<?php echo $this -> formFieldClass(); ?>" <?php $this -> addAttributes( $this -> args[ 'attributes' ] ); ?> >
			<?php
			foreach( $this -> options[ 'options' ] as $field_key => $field_data ){
				?>
				<option class="" type="text" <?php if( $this -> options[ 'multiple' ] ){ selected( in_array( $field_key, $this -> data )  , true ); }else{ selected( $this -> data  , $field_key ); } ?> value="<?php echo $field_key; ?>">
				<?php echo $field_data; ?>
				</option>
			<?php } ?>
		</select>
		<?php

	}

}

?>