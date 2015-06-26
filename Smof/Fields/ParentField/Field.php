<?php

namespace Smof\Fields\ParentField; 
abstract class Field{

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
	
	protected $framework;
	protected $subframework;
	
	protected $create;
	
	protected $options_converted = array();
	protected $data_source_names = array();

	function __construct( $options , array $args ){
	
		$this -> assignInstance();
		
		$this -> assignDefaultOptions();
		
		$this -> assignDefaultArgs();
	
		$this -> assignOptions( $options  );

		$this -> assignArgs( $args  );
		
		$this -> assignFrameworks();
		
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
	
	static function getProperties( $key = false ){
		return ( ( $key ) ? static :: $properties[ $key ] : static :: $properties );
	}
	
	protected function appendArgs( array $args ){
		$this -> args = array_replace_recursive( $this -> args, $args );
	}
	
	protected function assignDefaultOptions(){
		$this -> default_options = $this -> obtainDefaultOptions();
	}
	
	protected function obtainDefaultOptions(){
		return array(
			'id' => '',
			'title' => '',
			'field_class' => array(),
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
			'field_class' => array(),
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
	
	protected function assignFrameworks(){
		
		$this -> framework = $this -> args[ 'subframework' ] -> args[ 'framework' ];
		$this -> subframework = $this -> args[ 'subframework' ];
		
	}
	
	public function setData( $data ){

		if( $data !== null ){ 
			
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
	
	public function enqueueStyles(){
	
	}
	
	public function enqueueScripts(){
	
	}
	
	protected function addPrintScriptsContent( $content ){
	
		$this -> print_scripts_content .= $content;
	
	}
	
	protected function printScriptsBody(){
		
	}
	
	public function printScripts(){
		
		ob_start();
			$this -> printScriptsBody();
			$body = ob_get_contents();
		ob_end_clean();
		$this -> addPrintScriptsContent( $body );
		
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
	
	public function enqueueAll(){
		
		if( !$this -> isInstantiated() ){

			$this -> enqueueStyles();
			$this -> enqueueScripts();

		}
		
	}
	
	protected function convertAttributesToJson( array $attributes ){
	
		if( empty( $attributes ) ){
			return array();
		}
		
		foreach( $attributes as $attribute => $attribute_value ){
			
			if( !is_array( $attribute_value ) ){
				$output[ $attribute ] =  esc_attr( $attribute_value ) ;
			}else{
				$output[ $attribute ] = json_encode( $attribute_value );
			}
						
		}
		
		return $output;
		
		
	}
	
	public function getOutput(){
		
		return $this -> output;
	}
	
	public function setOutput( $output ){
		$this -> output = $output;
	}
	
	public function validateData(){
		if( $this -> options[ 'validate' ] ){
		
			$validate = new \Smof\Validation();
			$this -> validation_results = $validate -> validate( array( 'data' => $this -> data  , 'conditions' => $this -> options[ 'validate' ] ) );
			
			if( !empty( $this -> validation_results ) ){
				
				$this -> data = $this -> options[ 'default' ];
			}
			
		}
	}
	
	public function initiateFields(){
	
	}
	
	protected function obtainFieldClass(){
		if( is_array( $this -> options[ 'class' ] ) && is_array( $this -> args[ 'field_class' ] ) ){
			return implode( ' ' , array_merge( $this -> options[ 'class' ] , $this -> args[ 'field_class' ] ) );
		}
		
	}
	
	public function obtainData(){
		
		return array( $this -> args[ 'id_suffix' ][ 0 ] => $this -> data );
	}
	
	public function obtainOutput( $caller ){
		
		ob_start();
		
			if( is_callable( $caller ) ){
				
				call_user_func( $caller );
				
			}
			
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
		
	}
	
	protected function obtainDefaultViewData(){
		
		$data = $this -> options;
		
		if( isset( $data[ 'fields' ] ) ){
			
			unset( $data[ 'fields' ]);
			
		}
		
		if( isset( $data[ 'validate' ] ) ){
			
			unset( $data[ 'validate' ]);
			
		}
		
		$data[ 'data' ] = $this -> data;
		$data[ 'validation_results' ] = $this -> validation_results;
		// parsed into string
		$data[ 'id' ] = $this -> subframework -> getFieldId( $this -> args[ 'id' ] );
		$data[ 'name' ] = $this -> subframework -> getFieldName( $this -> args[ 'name' ] );
		
		$data[ 'show_description' ] = $this -> args[ 'show_description' ];
		$data[ 'show_data_name' ] = $this -> args[ 'show_data_name' ];
		
		return $data;	
		
	}
	

}

?>