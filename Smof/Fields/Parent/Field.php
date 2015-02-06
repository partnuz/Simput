<?php

abstract class Smof_Fields_Parent_Field{

	protected $output = true;
	protected $validation_results;
	protected $fields = array();
	
	public $data;
	public $options;
	public $args;
	
	public static $class_names = array();
	
	public $default_options;
	public $default_args;
	
	public $print_scripts_content = '';

	function __construct( $options , array $args ){
	
		$this -> setInstance();
		
		$this -> setDefaultOptions();
		
		$this -> setDefaultArgs();
	
		$this -> setOptions( $options  );

		$this -> setArgs( $args  );
		
		$this -> setNameSuffix();
		
		$this -> setName();
		
		$this -> setIdSuffix();
		
		$this -> setId();
		
		$this -> enqueueAll();
		
		$this -> printScriptsWrapper();
		
	}
	
	public static function getProperties(){
		return static :: $properties;
	}
	
	public function appendArgs( array $args ){
		$this -> args = array_replace_recursive( $this -> args, $args );
	}
	
	protected function setDefaultOptions(){
		$this -> default_options = $this -> getDefaultOptions();
	}
	
	protected function getDefaultOptions(){
		return array(
			'id' => '',
			'title' => '',
			'form_field_class' => array(),
			'class' => array(),
			'desc' => ''
		);
	}
	
	protected function getDefaultArgs(){
		return array(
			'show_data_name' => false,
			'show_body_id' => true,
			'show_description' => true,
			'id' => array(),
			'id_order' => false,
			'id_suffix' => array(),
			'attributes' => array(),
			'form_field_class' => array(),
			'name' => array(),
			'name_suffix' => array(),
			'mode' => 'nonrepeatable',
			'validation' => false
		);
	}
	
	protected function setDefaultArgs(){
		$this -> default_args = $this -> getDefaultArgs();
	}
	
	
	protected function setOptions( $options ){
	
		$this -> options = array_replace_recursive( $this -> default_options, $options );
		
	}
	
	protected function setArgs( array $args ){
	
		$this -> args = array_replace_recursive( $this -> default_args , $args );
	}
	
	public function setData( $data ){

		if( $data !== false && $data !== null ){ 
			
			$this -> data = $data;

		}else{
		
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	protected function setNameSuffix(){
	
		$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ][] =  null ;
			break;
		}
	
	}
	
	protected function setName(){

		$this -> args[ 'name' ] = array_merge( $this -> args[ 'name' ] , $this -> args[ 'name_suffix' ] ) ;

	}
	
	protected function setIdSuffix(){
	
		$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				
			break;
			case 'repeatable':
				
				$id_order = ( $this -> args[ 'id_order' ] !== false ? $this -> args[ 'id_order' ] : false );	
				if( $id_order !== false ){ $this -> args[ 'id_suffix' ][] = $id_order ; }
			break;
		}
	
	}
	
	protected function setId(){
		// id uses same pattern as name
		$this -> args[ 'id' ] = array_merge( $this -> args[ 'id' ] , $this -> args[ 'id_suffix' ] ) ;

	}
	
	protected function beforeBodyView(){
	
		if( $this -> args[ 'show_body_id' ] ){
			?>
			<div class="smof-field-body">
			<?php
		
		}
	}
	
	protected function afterBodyView(){
		if( $this -> args[ 'show_body_id' ] ){
			?>
			</div>
			<?php
		
		}
	}
	
	protected function beforeContainerView(){
		
		?>
		
		<div class="smof-container smof-container-<?php echo $this -> options[ 'type' ] ?> smof_clearfix"  id="smof-container<?php echo $this -> args[ 'subframework' ] -> setFieldId( $this -> args[ 'id' ] ); ?>" >
		<?php

	}
	
	protected function afterContainerView(){
	
		?>
		</div>
		<?php

	}
	
	protected function headingView(){
		?>
			<?php
			if( !empty( $this -> options[ 'title' ] ) ){
				?>
				<h3><?php echo $this -> options[ 'title' ] ?></h3>
				<?php
			}
			?>
		<?php
	}
	
	protected function descriptionView(){
		if( $this -> args[ 'show_description' ] ){
			?>
			<div class="smof-field-description">
				<?php echo $this -> options[ 'desc' ]; ?>
			</div>
			<?php
		}
	}
	
	public function view(){
	
		$this -> beforeContainerView();
		
			$this -> beforeHeaderView();
			
				$this -> headingView();
				
				$this -> descriptionView();	
				
			$this -> afterHeaderView();
		
			$this -> beforeBodyView();
			
				$this -> bodyView();
			
			$this -> afterBodyView();
		
		
		$this -> afterContainerView();
	}
	

	
	protected function beforeHeaderView(){
		if( !empty( $this -> options[ 'title' ] ) || !empty( $this -> options[ 'description' ] ) ){
			?>
			<div class="smof-field-header">
			<?php
		}
	}
	
	protected function afterHeaderView(){
		if( !empty( $this -> options[ 'title' ] ) || !empty( $this -> options[ 'description' ] ) ){
			?>
			</div>
			<?php
		}

	}
	
	protected function enqueueStyles(){
	
	}
	
	protected function enqueueScripts(){
	
	}
	
	protected function addPrintScriptsContent( $content ){
	
		$this -> print_scripts_content .= $content;
	
	}
	public function printScripts(){
		
		if( !empty( $this -> print_scripts_content ) ){
		?>
		<script>
			<?php
			echo $this -> print_scripts_content;
			?>
		</script>
		<?php
		
		}
		
	}
	
	protected function printScriptsWrapper(){

		add_action( 'admin_footer' , array( $this , 'printScripts' ) );

	}
	
	protected function setInstance(){
	
		if( isset( self :: $class_names[ get_class( $this ) ] ) ){
			self :: $class_names[ get_class( $this ) ] += 1; 
		}else{
			self :: $class_names[ get_class( $this ) ] = 1;
		}
	}
	
	protected function isInstantiated(){
		
		if(  self :: $class_names[ get_class( $this ) ] > 1 ){
			
			return true;
		}
		
		return false;
	}
	
	public function enqueueAll(){
		
		if(  !$this -> isInstantiated() && ( $this -> args[ 'subframework' ] -> args[ 'debug_mode' ] || $this -> options[ 'custom' ] ) ){

			$this -> enqueueStyles();
			$this -> enqueueScripts();

		}
		
	}
	
	protected function loadFromDataSource( $file_path ){
	
		foreach( $file_paths as $file_path ){
			if( file_exists( $this -> args[ 'framework' ] -> path[ 'data_source' ] . $file_path ) ){
				include_once( $this -> args[ 'framework' ] -> path[ 'data_source' ] . $file_path );
			}
		
		}
	}
	
	protected function addAttributes( $attributes  ){
	
		if( empty( $attributes ) ){
			return;
		}
	
		$output = '';
		foreach( $attributes as $attribute_prefix => $attribute ){
			$output .= 'data-smof-'.$attribute_prefix . '=\'';
			
			if( !is_array( $attribute ) ){
				$output .=  $attribute ;
			}else{
				$output .= json_encode( $attribute );
			}
			
			$output .= '\' ';
			
		}
		
		echo $output;
		
		
	}
	
	public function get( $property_name ){

		if( property_exists( __CLASS__ , $property_name ) ){
			return $this -> $property_name;
		}
				
	}
	
	public function set( $property_name, $property_value ){
		if( property_exists( __CLASS__ , $property_name ) ){
			$this -> $property_name = $property_value;
		}
	}
	
	public function validateData(){
		if( !empty( $this -> options[ 'validate' ] ) ){
		
			$validate = new Smof_Validation();
			$results = $validate -> validate( array( 'data' => $this -> data  , 'conditions' => $this -> options[ 'validate' ] ) );
			
			if( !empty( $results ) ){
				$this -> validation_results = $results;
				$this -> data = $this -> options[ 'default' ];
			}
			
		}
	}
	
	public function getValidatedData(){

		return array( $this -> options[ 'id' ] => $this -> data );
	}
	
	public function initiateFields(){
	
	}
	
	protected function formFieldClass(){
		if( is_array( $this -> options[ 'class' ] ) && is_array( $this -> args[ 'form_field_class' ] ) ){
			return implode( ' ' , array_merge( $this -> options[ 'class' ] , $this -> args[ 'form_field_class' ] ) );
		}
		
	}
	

}

?>