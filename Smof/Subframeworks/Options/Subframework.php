<?php

class Smof_Subframeworks_Options_Subframework{
	
	protected $default_options;
	protected $options;
	protected $uri;
	protected $path;
	public $args;
	protected $theme_data;
	protected $data;
	protected $default_data;
	public $admin_print;
	public $menu;
	protected $container_field;
	protected $container_options;
	private $create;
	protected $nonce;
	protected static $instance_num = 0;
	protected $user_role;

	function __construct( $options , $args ){
		
		$this -> increaseInstanceNumber();
		
		$this -> setUserRole();
	
		$this -> defaultArgs( $args );
	
		$this -> assignPath();
		$this -> assignUris();
		
		$this -> obtainDbData();
		$this -> assignOptions( $options );
		
		$this -> setDefaultData( array() );
		
		$this -> setDefaultData( $this -> obtainOptionsDefaults( $this -> getOptions() ) );
		$this -> setDefaultData ( $this -> decodeHtmlSpecialCharsLoop( $this -> getDefaultData() ) );
		
		$this -> assignContainerOptions();
		$this -> wrapOptionsInsideContainer();
		
		
		if( !is_admin() ){
			$this -> mergeDataWithDefaults();
		}

		if( is_admin() ){
			add_action( 'admin_menu', array( $this , 'addAdminPage' ) );
		}
		
		if( is_admin() ){
			
			$this -> assignCreate();
		}
		
		
	}
	
	protected function assignCreate(){
		
		$this -> create = new Smof_Create( array(
			'framework' => $this -> args[ 'framework' ],
			'subframework' => $this
		));
		
	}
	
	public function getCreate(){
		
		return $this -> create;
		
	}
	
	protected function containerOptions(){
		
		return array(
			'id' => 'window',
			'type' => 'window'
			
		);
		
	}
	
	protected function assignContainerOptions(){
		
		$this -> container_options = $this -> containerOptions();
		
	}
	
	protected function wrapOptionsInsideContainer(){
		
		$this -> container_options[ 'fields'] = $this -> getOptions();
		$this -> assignOptions( array( $this -> container_options ) );
		
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
	
	protected function assignOptions( $options ){
		
		$this -> options = $options;
		
	}
	
	public function getContainerField(){
		
		return $this -> container_field;
		
	}
	
	public function createContainerField(){
		
		$this -> container_field = $this -> getCreate() -> createFieldFromOptions( $this -> getData() , $this -> options[ 0 ] , array(
			'framework' => $this -> args[ 'framework' ],
			'subframework' => $this
		) );
	}
	
	public function assignPath(){
	
		$this -> path[ 'main' ] = plugin_dir_path( __FILE__ );
		$this -> path[ 'views' ] = $this -> path[ 'main' ] . 'Views/';
	
	}
	
	public function assignUris(){
		
		$this -> uri[ 'main' ] = $this -> args[ 'framework' ] -> uri[ 'subframeworks' ] . 'Options/';
		$this -> uri[ 'fields' ] = $this -> args[ 'framework' ] -> uri[ 'fields' ];
		$this -> uri[ 'assets' ][ 'main' ] = $this -> uri[ 'main' ] . 'Assets/';
		$this -> uri[ 'assets' ][ 'css' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Css/';
		$this -> uri[ 'assets' ][ 'scripts' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Scripts/';
		

	}
	
	public function getUri(){
		
		$args = func_get_args() ;
		
		if( count( $args ) === 0 ){ return $this -> uri; } 
		
		$uri = $this -> uri;
		
		foreach  ( $args as $arg ){
			
		$uri = $uri[$arg]; 

		}		
		
		return $uri;  
		
	}
	
	public function setUri( array $uri ){
		
		if( isset( $this -> uri ) ){
			$this -> uri +=  $uri;
		}else{
			$this -> uri = $uri;
		}
		
	}
	
	public function getArgs( $key = ''){
		if( $key ){
			return $this -> args[ $key ];
		}else{
			return $this -> args;
		}
	}
	
	public function assignArgs( $args ){
		$this -> args = $args;
	}
	
	protected function defaultArgs( $args ){
		
		$defaults = array(
			'mode' => 'options',
			'debug_mode' => true,
			'container_field' => true,
			'access_lvl' => array( 'administrator')
		);
		 
		$this -> args = wp_parse_args( $args , $defaults );

	}
	

	
	protected function obtainDbData(){
		$this -> assignData( get_theme_mods() );
		if( !$this -> getData() ){
			$this -> assignData( array() );
		}
		
	}
	
	protected function setDbData( $data ){
		
		var_dump( $data );
	
		foreach ( $data as $k => $v ) {

				set_theme_mod($k, $v);

	  	}
	
	}
	
	protected function assignData( $data ){
		$this -> data = $data;
	}
	
	public function getData(){
		return $this -> data;
	}
	
	protected function mergeDataWithDefaults(){
	
		$this -> assignData( array_replace_recursive(  $this -> getDefaultData() , $this -> getData() ) ) ;
		
	}
	
	protected function obtainOptionsDefaults( $options ){

		$options_defaults = array();
		
		foreach( $options as $option ){
			
			if( isset( $option[ 'id' ] ) ){
				$id = $option[ 'id' ] ;
			}else{
				continue;
			}
			
			$field_properties = $this -> args[ 'framework' ] -> setFieldProperties( $option[ 'type' ]);
			
			if( $field_properties === false){
				continue;
			}
			
			if( $field_properties[ 'inheritance' ] === false ){
			
				switch( $field_properties[ 'category' ] ){
					case 'repeatable':
						if( isset( $option[ 'default' ] ) ){
							$options_defaults[ $id ] = array();
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
				if( $field_properties[ 'inheritance' ] === 'parent' ){
					$options_defaults[ $id ] = array();
				}elseif( $field_properties[ 'inheritance' ] === 'children' ){
					$options_defaults = $options_defaults + $this -> obtainOptionsDefaults( $option[ 'fields' ] );
				}elseif( $field_properties[ 'inheritance' ] === 'parent_children' ){
					$options_defaults[ $id ] = $this -> obtainOptionsDefaults( $option[ 'fields' ] );
				}
			
			}
			
		}
		
		return $options_defaults;
		
		
		
	}
	
	protected function prepareView(){
		$this -> view = new Smof_Subframeworks_Options_Views_Main(  $this -> args[ 'framework' ] , $this );
		
	}
	
	public function displayPage(){
		
		$this -> createNonce();
		
		$this -> setAdminData();
		$this -> prepareView();
		$this -> postActions();
		
		$this -> setContentViewValue();
		$this -> setMenuViewValue();
		$this -> setViewNonceValue();
		
		$this -> view -> view();
		
	}
	
	protected function setViewNonceValue(){
		
		$this -> view -> options[ 'nonce' ] = $this -> getNonce() ;
		
	}
	
	protected function setContentViewValue(){
		$this -> view -> content =  $this -> getFieldsContent() ;
	}
	
	protected function setMenuViewValue(){
		$this -> view -> menu = $this -> menu;
	}
	
	protected function getFieldsContent(){
		ob_start();
		
		if( !$this -> getContainerField() ){
		
			$this -> createContainerField();
		
		}
		$this -> getCreate() -> fieldsView( array( $this -> getContainerField() ) );
			
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
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
		
		if( !isset( $_POST[ 'smof' ]) || !$_POST[ 'smof' ][ 'nonce' ] ||  !$this -> allowAccess( $_POST[ 'smof' ][ 'nonce' ] ) ){
			$this -> view -> options[ 'error' ] = true;
			return;
		}
		
		$this -> action = $_POST[ 'smof' ][ 'action' ];
		unset( $_POST[ 'smof' ][ 'action' ] );

		$this -> post_data = $_POST[ 'smof' ];
		
		
		
		switch( $this -> action ){
			case 'save':
				
				$this -> assignData( $this -> decodeHtmlSpecialCharsLoop( $this -> post_data ) );
				$this -> createContainerField();
				
				$this -> getCreate() -> fieldsValidate( array( $this -> getContainerField() ) );
				$data = $this -> getCreate() -> fieldsSave( array( $this -> getContainerField() ) );
				
				$this -> view -> options[ 'save' ] = true;
				
			break;
			case 'reset':
				$data = $this -> getDefaultData() ;
			break;
			case 'no_save':
			
				$this -> assignData( $this -> decodeHtmlSpecialCharsLoop( $post_data ) );
				$this -> createContainerField();
			
			break;
			case 'import':
				if( !empty( $this -> post_data[ 'backup' ] ) ){
					$data = unserialize( $this -> post_data[ 'backup' ] );
				}else{
					$data = $this -> post_data;
				}
			break;
			case 'export':
				if( !empty( $this -> post_data[ 'backup' ] ) ){
					unset( $this -> post_data[ 'backup' ] );
				}
				$data = $this -> post_data;
				$data[ 'backup' ] = serialize( $this -> post_data );
			break;
			
		}
		
		// add filter to $data
		
		$data = add_filter( 'smof_'.$this -> args[ 'framework' ] -> args[ 'mode' ] .'_'. $this -> getInstanceNumber() , $data );
		
		$this -> setDbData( $data );
		$this -> assignData( $data );
		
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
		
		$page = add_theme_page( $this -> theme_data[ 'name' ] , 'Theme Options', 'edit_theme_options', 'smof_options', array( $this , 'displayPage' ) );
		
		$this -> admin_print['scripts'] = "admin_print_scripts-$page";
		$this -> admin_print['styles'] = "admin_print_styles-$page";
		
		

		// Add framework functionaily to the head individually
		add_action( $this -> admin_print['scripts'] , array( $this , 'enqueueScripts' ) );
		add_action( $this -> admin_print['styles'] , array( $this , 'enqueueStyles' ) );
	
	}
	
	
	
	public function getFieldName( $name , $args = array() ){
	
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
	
	public function getFieldId( array $id , $args = array() ){
	
		$defaults = array(
		);
		
		$args = wp_parse_args( $args , $defaults );

		return implode( '-' , $id );
		
	}
	
	public function getFieldClass( $class , $args = array() ){
		// format same as id ??????????
		return $this -> getFieldId( $class );
		
	}
	

	
	public function enqueueStyles(){
	
		wp_enqueue_style('smof-options-style', $this -> uri[ 'assets' ][ 'css' ] . 'style.css');

	
	}
	
	public function enqueueScripts(){
		wp_enqueue_script( 'smof-options', $this -> uri[ 'assets' ][ 'scripts' ] . 'smof.js', array( 'jquery' , 'cookie' ) );
		wp_enqueue_script( 'cookie', $this -> uri[ 'assets' ][ 'scripts' ] . 'cookie.js', array( 'jquery' ) );
	}
	
	protected function increaseInstanceNumber(){
		
		static :: $instance_num++;
		
	}
	
	public function getInstanceNumber(){
		return static :: $instance_num;
	}
	
	protected  function createNonceName(){
		
		return wp_create_nonce( 'smof_' . $this -> args[ 'framework' ] -> args[ 'mode' ] .'_'. $this -> getInstanceNumber() );
	}
	
	protected function createNonce(){
		
		$this -> nonce = wp_create_nonce( $this -> createNonceName() );
		
	}
	
	public function getNonce(){
		return $this -> nonce;
	}
	
	public function setUserRole(){
		$this -> user_role = wp_get_current_user() -> roles[ 0 ];
		
	}
	
	public function allowAccess( $new_nonce ){
		
		if( array_search( $this -> user_role, $this -> args[ 'access_lvl' ] ) !== false && $this -> getNonce() === $new_nonce ){
			
			return true;
			
		}else{
			
			return false;
		}
		
		
	}


	


}

?>