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
	
	protected $create;

	function __construct( $options , array $args ){
	
		$this -> assignInstance();
		
		$this -> assignDefaultOptions();
		
		$this -> assignDefaultArgs();
	
		$this -> assignOptions( $options  );

		$this -> assignArgs( $args  );
		
		$this -> assignNameSuffix();
		
		$this -> assignName();
		
		$this -> assignIdSuffix();
		
		$this -> assignId();
		
		$this -> assignCreate();
		
		$this -> enqueueAll();
		
		$this -> printScriptsWrapper();
		
	}
	
	protected function assignCreate(){
		$this -> create = $this -> args[ 'subframework' ] -> getCreate();
	}
	
	public function getCreate(){
		
		return $this -> create;	
	}
	
	static function getProperties(){
		return static :: $properties;
	}
	
	function appendArgs( array $args ){
		$this -> args = array_replace_recursive( $this -> args, $args );
	}
	
	protected function assignDefaultOptions(){
		$this -> default_options = $this -> obtainDefaultOptions();
	}
	
	protected function obtainDefaultOptions(){
		return array(
			'id' => '',
			'title' => '',
			'form_field_class' => array(),
			'class' => array(),
			'desc' => '',
			'validate' => false
		);
	}
	
	protected function obtainDefaultArgs(){
		return array(
			'show_data_name' => false,
			'show_description' => true,
			'id' => array(),
			'id_order' => false,
			'id_suffix' => array(),
			'attributes' => array(),
			'form_field_class' => array(),
			'name' => array(),
			'name_suffix' => array(),
			'mode' => 'nonrepeatable'
		);
	}
	
	protected function assignDefaultArgs(){
		$this -> default_args = $this -> obtainDefaultArgs();
	}
	
	
	protected function assignOptions( $options ){

		$this -> options = array_replace_recursive( $this -> default_options, $options );
		
	}
	
	protected function assignArgs( array $args ){
	
		$this -> args = array_replace_recursive( $this -> default_args , $args );
	}
	
	function assignData( $data ){

		if( $data !== false && $data !== null ){ 
			
			$this -> data = $data;

		}else{
		
			$this -> data = $this -> options[ 'default' ];
		}
	}
	
	protected function assignNameSuffix(){
		
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'name_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':	
				$this -> args[ 'name_suffix' ] = array( null );
			break;
		}
	
	}
	
	protected function assignName(){

		$this -> args[ 'name' ] = array_merge( $this -> args[ 'name' ] , $this -> args[ 'name_suffix' ] ) ;

	}
	
	protected function assignIdSuffix(){
	
		switch( $this -> args[ 'mode' ] ){
			case 'nonrepeatable':
				$this -> args[ 'id_suffix' ] = array( $this -> options[ 'id' ] );
			break;
			case 'repeatable':
			
				if( $this -> args[ 'id_order' ] !== false  ){
					
					$this -> args[ 'id_suffix' ] = array( $this -> args[ 'id_order' ] );
					
				}
				
			break;
		}
	
	}
	
	protected function assignId(){
		// id uses same pattern as name
		$this -> args[ 'id' ] = array_merge( $this -> args[ 'id' ] , $this -> args[ 'id_suffix' ] ) ;

	}
	
	protected function beforeBodyView(){
	
		?>
		<div class="smof-field-body">
		<?php
	}
	
	protected function afterBodyView(){

		?>
		</div>
		<?php
		
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
	
	function view(){
	
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
	
	function addPrintScriptsContent( $content ){
	
		$this -> print_scripts_content .= $content;
	
	}
	function printScripts(){
		
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
	
	protected function assignInstance(){
	
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
	
	function enqueueAll(){
		
		if( !$this -> isInstantiated() && ( $this -> args[ 'subframework' ] -> getArgs( 'debug_mode' ) || $this -> options[ 'custom' ] ) ){

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
	
	protected function addAttributes( $attributes, $prefix = array() ){
	
		if( empty( $attributes ) ){
			return;
		}
	
		$output = '';
		foreach( $attributes as $attribute_name => $attribute ){
			$prefix_joined = ( $prefix ) ? implode( '-', $prefix ) . '-' : '';

			$output .= 'data-smof-'. $prefix_joined .$attribute_name . '=\'';
			
			if( !is_array( $attribute ) ){
				$output .=  $attribute ;
			}else{
				$output .= json_encode( $attribute );
			}
			
			$output .= '\' ';
			
		}
		
		echo $output;
		
		
	}
	
	function getOutput(){
		
		return $this -> output;
	}
	
	function setOutput( $output ){
		$this -> output = $output;
	}
	
	function validateData(){
		if( $this -> options[ 'validate' ] ){
		
			$validate = new Smof_Validation();
			$results = $validate -> validate( array( 'data' => $this -> data  , 'conditions' => $this -> options[ 'validate' ] ) );
			
			if( !empty( $results ) ){
				$this -> validation_results = $results;
				$this -> data = $this -> options[ 'default' ];
			}
			
		}
	}
	
	function initiateFields(){
	
	}
	
	protected function formFieldClass(){
		if( is_array( $this -> options[ 'class' ] ) && is_array( $this -> args[ 'form_field_class' ] ) ){
			return implode( ' ' , array_merge( $this -> options[ 'class' ] , $this -> args[ 'form_field_class' ] ) );
		}
		
	}
	
	function obtainData(){
		
		return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
	}
	

}

?>