<?php

class Smof_Framework{
	
	public $path;
	public $uri;
	public $args;
	public $subframework;
	public $subframework_name;
	public $data_sources = '';
	public $field_class_names = array();
	public $fields_properties;
	
	function __construct( $options, $args ){
	
		$this -> defaultArgs( $args );
	
		$this -> setPaths();
		$this -> setUris();

		
		if( is_admin() ){
			$this -> loadFields();
		}
		
		$this -> setSubframeworkName();
				
		$this -> mode( $options );
		
		$this -> enqueueAll();
		
		add_action( 'in_admin_footer' , array( $this , 'printDataSources' ) );
		
	}
	
	public function getSubframework(){
		return $this -> subframework;
	}
	
	function fieldNameCache( $field_slug ){
		
		$field_name = 'Smof_Fields_' . $this -> underscore2Camelcase( $field_slug ). '_Field' ;
		
		return ( class_exists( $field_name ) ? $field_name : false );
	}
	
	public function setFieldProperties( $field_type ){
	
		if( !isset( $this -> fields_properties[ $field_type ] ) ){
			$field_name = $this -> fieldNameCache( $field_type ) ;
			
			if( $field_name ){
				// for PHP 5.2 compatibility
				$this -> fields_properties[ $field_type ] = call_user_func( array( $field_name , 'getProperties' ) );
			}

		}
		
	}
	
	public function multiArrayFromArray( $keys, $data ){
		$firstKey = key( $keys );
		if( count($keys) > 1 ){
			$firstVal = $keys[ $firstKey ];
			unset( $keys[ $firstKey ] );
			$array[ $firstVal ] =  $this -> multiArrayFromArray( $keys , $data );
		}else{
			$array[ $keys[ $firstKey ] ] = $data;
		}
		
		return $array;
	}
	
	function setPaths(){
		
		$this -> path[ 'main' ] = plugin_dir_path( __FILE__ );
		$this -> path[ 'fields' ] = $this -> path[ 'main' ] . 'Fields/';
		$this -> path[ 'subframeworks' ] = $this -> path[ 'main' ] . 'Subframeworks/';
		$this -> path[ 'data_source' ] = $this -> path[ 'main' ] . 'Data_source/';
		$this -> path[ 'includes' ] = $this -> path[ 'main' ] . 'Includes/';
		
	}
	
	function setUris(){
	
		$file_dir = plugin_dir_path( __FILE__ );
		$file_dir = str_replace( '\\' , '/',  $file_dir );
		
		if( !empty( $this -> theme_data[ 'parent' ] ) && strpos( $file_dir , $this -> theme_data[ 'parent' ] ) ){
			$uri = get_template_directory_uri();
		}elseif( strpos( $file_dir , 'plugins' ) ){
			// for future reference
		}else{
			$uri = get_stylesheet_directory_uri();
		}
		
		$this -> uri[ 'main' ] = $uri ."/". $this -> args[ 'dir' ];
		$this -> uri[ 'assets' ][ 'main' ] = $this -> uri[ 'main' ] . 'Assets/';
		$this -> uri[ 'assets' ][ 'css' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Css/';
		$this -> uri[ 'assets' ][ 'scripts' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Scripts/';
		$this -> uri[ 'subframeworks' ] = $this -> uri[ 'main' ] . 'Subframeworks/';
		$this -> uri[ 'fields' ] = $this -> uri[ 'main' ] . 'Fields/';
		$this -> uri[ 'data_source' ] = $this -> uri[ 'main' ] . 'DataSource/';
	
	}
	
	function loadFields(){

		// php compatibility
		
		include_once( $this -> path[ 'includes' ] . 'php_compatibility.php' );
		
		
		/* advanced
		
		include_once( $this -> path[ 'fields' ] . 'typography/field.php' );
		
		*/
	}
	
	function defaultArgs( $args ){
		
		$defaults = array(
			'mode' => 'Options',
			'prefix' => 'Smof_',
			'subframework_args' => array(),
			'dir' => 'smof/',
		);
		 
		$this -> args = wp_parse_args( $args , $defaults );
		$this -> args[ 'subframework_args' ][ 'framework' ] = $this;
	}
	
	function setSubframeworkName(){
		$this -> subframework_name =  $this -> args[ 'prefix' ] . 'Subframeworks_' . ucfirst( $this -> args[ 'mode' ] ) . '_Subframework';
	}
	
	function mode( $options ){

		if( class_exists( $this -> subframework_name ) ){
		
			$this -> subframework = new $this -> subframework_name( $options , $this -> args[ 'subframework_args' ]  );
		}
	}
	
	function enqueueAll(){
	
		add_action( 'admin_enqueue_scripts', array( $this , 'enqueueStyles') );
		add_action( 'admin_enqueue_scripts', array( $this , 'enqueueScripts') );
		
	}
	
	function enqueueStyles(){
	
		wp_enqueue_style('smof-style', $this -> uri[ 'assets' ][ 'css' ] . 'style.css');
		wp_enqueue_style('jquery-ui-custom-admin', $this -> uri[ 'assets' ][ 'css' ] .'jquery-ui-custom.css');
	
	}
	
	function enqueueScripts(){
	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-slider');
	
		wp_enqueue_media();
		
		wp_enqueue_script( 'smof', $this -> uri[ 'assets' ][ 'scripts' ] . 'smof.js', array( 'jquery' ) );
	
	}
	
	function addToPrintDataSources( $name, $data , $container = array( 'before' => '', 'after' => '' ) ){
		static $names = array();
		if( !array_search( $name , $names ) ){
			$this -> data_sources .= $container[ 'before' ] . $data . $container[ 'after' ] ;
		}
	}
	
	function printDataSources(){
		
		echo $this -> data_sources;
	}
	
	function underscore2Camelcase( $str ) {
	  // Split string in words.
	  $words = explode('_', strtolower($str));

	  $return = '';
	  foreach ($words as $word) {
		$return .= ucfirst(trim($word));
	  }

	  return $return;
	}
	
}

?>