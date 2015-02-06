<?php

class Smof_Subframeworks_Options_Subframework{
	
	protected $default_options;
	protected $options;
	public $uri;
	public $path;
	public $args;
	public $theme_data;
	protected $data;
	protected $default_data;
	public $admin_print;
	public $menu;
	protected $fields = array();

	function __construct( $options , $args ){
	
		$this -> defaultArgs( $args );
	
		$this -> setPaths();
		$this -> setUris();
		
		$this -> getDbData();
		$this -> setOptions( $options );
		
		$this -> setDefaultData( array() );
		
		$this -> setDefaultData( $this -> getOptionsDefaults( $this -> getOptions() ) );
		$this -> setDefaultData ( $this -> decodeHtmlSpecialCharsLoop( $this -> getDefaultData() ) );
		
		if( !is_admin() ){
			$this -> mergeDataWithDefaults();
		}

		if( is_admin() ){
			add_action( 'admin_menu', array( $this , 'addAdminPage' ) );
		}
		
	}
	
	public function getDefaultData(){
		
		return $this -> default_data;
	}
	
	public function  setDefaultData( $val ){
		
		$this -> default_data = $val;
	}
	
	protected function getOptions(){
		
		return $this -> options;

	} 
	
	protected function setOptions( $options ){
		
		$this -> options = $options;
		
	}
	
	public function getFields(){
		
		return $this -> fields;
		
	}
	
	public function setFields( $fields ){
		$this -> fields = $fields;
	}
	
	public function setPaths(){
	
		$this -> path[ 'main' ] = plugin_dir_path( __FILE__ );
		$this -> path[ 'views' ] = $this -> path[ 'main' ] . 'Views/';
	
	}
	
	public function setUris(){
		
		$this -> uri[ 'main' ] = $this -> args[ 'framework' ] -> uri[ 'subframeworks' ] . 'Options/';
		$this -> uri[ 'fields' ] = $this -> args[ 'framework' ] -> uri[ 'fields' ];
		$this -> uri[ 'assets' ][ 'main' ] = $this -> uri[ 'main' ] . 'Assets/';
		$this -> uri[ 'assets' ][ 'css' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Css/';
		$this -> uri[ 'assets' ][ 'scripts' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Scripts/';
		

	}
	
	protected function defaultArgs( $args ){
		
		$defaults = array(
			'mode' => 'options',
			'debug_mode' => true
		);
		 
		$this -> args = wp_parse_args( $args , $defaults );

	}
	

	
	protected function getDbData(){
		$this -> setData( get_theme_mods() );
		if( !$this -> getData() ){
			$this -> setData( array() );
		}
		
	}
	
	protected function setDbData( $data ){
	
		foreach ( $data as $k => $v ) {

				set_theme_mod($k, $v);

	  	}
	
	}
	
	protected function setData( $data ){
		$this -> data = $data;
	}
	
	protected function getData(){
		return $this -> data;
	}
	
	protected function mergeDataWithDefaults(){
	
		$this -> setData( array_replace_recursive(  $this -> getDefaultData() , $this -> getData() ) ) ;
		
	}
	
	protected function getOptionsDefaults( $options ){

		$options_defaults = array();
		
		foreach( $options as $option ){
			
			if( isset( $option[ 'id' ] ) ){
				$id = $option[ 'id' ] ;
			}else{
				continue;
			}
			
			$this -> args[ 'framework' ] -> setFieldProperties( $option[ 'type' ]);
			
			if( isset( $this -> args[ 'framework' ] -> fields_properties[ $option[ 'type' ] ] ) ){
				$field_properties = $this -> args[ 'framework' ] -> fields_properties[ $option[ 'type' ] ];
			}
			
			if( $field_properties === false){
				continue;
			}
			
			if( $field_properties[ 'inheritance' ] === false ){
			
				switch( $field_properties[ 'category' ] ){
					case 'repeatable':
						if( isset( $option[ 'default' ] ) ){
							$options_defaults[ $id ] = $option[ 'default' ];
						}else{
							
							continue;
						}
					break;
					default:
						if( isset( $option[ 'default' ] ) ){
							$options_defaults[ $id ] = $option[ 'default' ];
						}else{
							
							continue;
						}
					break;
				}


			
			}else{
				// We DON'T create defaults for repeatable field
				if( $option[ 'type' ] == 'repeatable' ){
					continue;
				}elseif( $field_properties[ 'inheritance' ] == 'children' ){
					$options_defaults = $options_defaults + $this -> getOptionsDefaults( $option[ 'fields' ] );
				}elseif( $field_properties[ 'inheritance' ] == 'parent_children' ){
					$options_defaults[ $id ] = $this -> getOptionsDefaults( $option[ 'fields' ] );
				}
			
			}
			
		}
		
		return $options_defaults;
		
		
		
	}
	
	protected function prepareView(){
		$this -> view = new Smof_Subframeworks_Options_Views_Main(  $this -> args[ 'framework' ] , $this );
		
	}
	
	public function view(){
		
		$this -> setAdminData();
		$this -> prepareView();
		$this -> postActions();
		
		$this -> getContent();
		$this -> getMenu();
		
		$this -> view -> view();
		
	}
	
	protected function getContent(){
		$this -> view -> content =  $this -> getFieldsContent() ;
	}
	
	protected function getMenu(){
		$this -> view -> menu = $this -> menu;
	}
	
	protected function getFieldsContent(){
		ob_start();
		
		if( !$this -> getFields() ){
		
			$this -> setFields( $this -> fieldLoopInitiate( $this -> getOptions() ) );
		
		}
		$this -> fieldLoopView( $this -> getFields() );
			
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	public function fieldLoopView( $fields ){
		if( !is_array( $fields ) ){
			return;
		}
		foreach( $fields as $field ){
			$field -> view();
		}
	}
	
	public function fieldLoopValidate( $fields ){
		$data = array();
		foreach( $fields as $field ){
			$field -> validateData();
			$data +=  $field -> getValidatedData();
		}
		return $data;
	}
	
	public function fieldLoopInitiate( $options , $data_all = false , $args = false ){
	
		$fields = array();
	
		if( $data_all === false ){
			$data_all = $this -> getData();
		}
		
		
		if( $args === false ){
			$args = array( 'view' => $this -> view , 'subframework' => $this );
		}
		
		foreach ( $options as $option ){
			
			if( !isset( $data_all[ $option[ 'id' ] ] ) ){
				$data = false;
			}else{
				$data = $data_all[ $option[ 'id' ] ];
			}
			
			$field = $this -> singleFieldWithoutView( $data , $option , $args );
			if( is_object( $field ) ){
				$fields[] = $field;
			}

		}
		
		return $fields;	
	}
	
	public function singleFieldWithoutView( $data , $options , $args ){
	
		$field_class_name = $this -> args[ 'framework' ] -> fieldNameCache( $options[ 'type' ] ); 
		
		if( $field_class_name !== false  ){
		
			$field = new $field_class_name( $options, $args );
			
			if( $field -> get( 'output' ) ){

				$field -> setData( $data );
				$field -> initiateFields();
				
				return $field;
			}
			
			
		}
		
	}
	
	public function menuItem( $item ){
		
		$this -> menu[] = $item;
	}
	
	protected function setAdminData(){
		if( isset( $_POST[ 'smof' ]) ){
			return;
		}
		
		$this -> mergeDataWithDefaults();
	}
	
	protected function postActions(){
		
		if( !isset( $_POST[ 'smof' ]) ){
			return;
		}
		
		$this -> action = $_POST[ 'smof' ][ 'action' ];
		unset( $_POST[ 'smof' ][ 'action' ] );
		$post_data = $_POST[ 'smof' ];
		
		switch( $this -> action ){
			case 'save':
				// must add twice because of validation
				if( !empty( $post_data[ 'backup' ] ) ){
					unset( $post_data[ 'backup' ] );
				}
				
				$this -> setData( $this -> decodeHtmlSpecialCharsLoop( $post_data ) );
				$this -> setFields( $this -> fieldLoopInitiate( $this -> getOptions() , $this -> getData() ) );
				// validated data
				$data = $this -> fieldLoopValidate( $this -> getFields() );
			break;
			case 'reset':
				$data = $this -> getDefaultData() ;
			break;
			case 'import':
				if( !empty( $post_data[ 'backup' ] ) ){
					$data = unserialize( $post_data[ 'backup' ] );
				}else{
					$data = $post_data;
				}
			break;
			case 'export':
				if( !empty( $post_data[ 'backup' ] ) ){
					unset( $post_data[ 'backup' ] );
				}
				$data = $post_data;
				$data[ 'backup' ] = serialize( $post_data );
			break;
			
		}
		
		// add filter to $data
		/*
		var_dump( $data );
		*/
		
		$this -> setDbData( $data );
		$this -> setData( $data );
		
	}
	
	protected function decodeHtmlSpecialChars( &$item , &$key ){
		if( is_string( $item ) ){
			$item = htmlspecialchars_decode( $item );
		}
	}
	
	protected function decodeHtmlSpecialCharsLoop( $data ){
		array_walk_recursive( $data , array( $this , 'decodeHtmlSpecialChars' ) );
		return $data;
	}
	
	public function addAdminPage(){
		
		$page = add_theme_page( $this -> theme_data[ 'name' ] , 'Theme Options', 'edit_theme_options', 'smof_options', array( $this , 'view' ) );
		
		$this -> admin_print['scripts'] = "admin_print_scripts-$page";
		$this -> admin_print['styles'] = "admin_print_styles-$page";
		
		

		// Add framework functionaily to the head individually
		add_action( $this -> admin_print['scripts'] , array( $this , 'enqueueScripts' ) );
		add_action( $this -> admin_print['styles'] , array( $this , 'enqueueStyles' ) );
	
	}
	
	
	
	public function setFieldName( $name , $args = array() ){
	
		$defaults = array(
		);
		
		$args = wp_parse_args( $args , $defaults );
		
		$real_name = '';

		foreach( $name as $key => $format ){
		
			if( is_string( $format ) ){
				$real_name .= '['. $name[ $key ] .']';
			}elseif( is_int( $format ) ){
				$real_name .= '['. $name[ $key ] .']';
			}elseif( is_null( $format ) ){
				$real_name .= '[]';
			}

		}
		
		$real_name = 'smof'. $real_name;
		return $real_name;
		
	}
	
	public function setFieldId( $id , $args = array() ){
	
		$defaults = array(
		);
		
		$args = wp_parse_args( $args , $defaults );
		
		$real_id = '';

		foreach( $id as $key => $format ){
		
			if( $format !== false ){
			
				if( is_string( $format ) ){
					$real_id .= '-'. $id[ $key ] ;
				}elseif( is_int( $format ) ){
					$real_id .= '-'. $id[ $key ] ;
				}

			
			}
		}
		
		// DON'T ADD PREFIX HERE
		return $real_id;
		
	}
	
	public function setFieldClass( $class , $args = array() ){
		// format same as id ??????????
		$this -> setFieldId( $class );
		
	}
	

	
	public function enqueueStyles(){
	
		wp_enqueue_style('smof-options-style', $this -> uri[ 'assets' ][ 'css' ] . 'style.css');

	
	}
	
	public function enqueueScripts(){
		wp_enqueue_script( 'smof-options', $this -> uri[ 'assets' ][ 'scripts' ] . 'smof.js', array( 'jquery' , 'cookie' ) );
		wp_enqueue_script( 'cookie', $this -> uri[ 'assets' ][ 'scripts' ] . 'cookie.js', array( 'jquery' ) );
	}

}

?>