<?php

namespace Smof\Subframeworks\Options;

class Subframework extends \Smof\Subframeworks\Subframework{
	
	protected $theme_data;
	public $menu;
	protected $user_role;
	protected $page_name;

	function __construct( $options , $args ){
		
		$this -> increaseInstanceNumber();
		
		$this -> assignUserRole();
	
		$this -> assignArgs( $args );
	
		$this -> assignPath();
		$this -> assignUris();
		
		$this -> obtainDbData();
		$this -> setOptions( $options );
		
		$this -> setDefaultData ( $this -> decodeHtmlSpecialCharsLoop( $this -> obtainDefaultDataFromOptions( $this -> getOptions() ) ) );
		
		$this -> assignContainerOptions();
		$this -> wrapOptionsInsideContainer();
		
		
		if( !is_admin() ){
			$this -> mergeDataWithDefaultData();
		}

		$this -> attachAdminPage();
	
		$this -> assignCreate();
		
		$this -> enqueueStylesWrapper();

	}
	
	/* create */
	
	/* args */
	protected function obtainDefaultArgs(){
		
		return array(
			'mode' => 'options',
			'debug_mode' => false,
			'container_field' => true,
			'access_roles' => array( 'administrator' )
		);

	}
	
	/* paths */
	public function assignPath(){
	
		$this -> path[ 'main' ] = \plugin_dir_path( __FILE__ );
		$this -> path[ 'views' ] = $this -> path[ 'main' ] . 'Views/';
	
	}
	
	public function assignUris(){
		
		$this -> uri[ 'main' ] = $this -> args[ 'framework' ] -> uri[ 'subframeworks' ] . 'Options/';
		$this -> uri[ 'fields' ] = $this -> args[ 'framework' ] -> uri[ 'fields' ];
		$this -> uri[ 'assets' ][ 'main' ] = $this -> uri[ 'main' ] . 'Assets/';
		$this -> uri[ 'assets' ][ 'css' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Css/';
		$this -> uri[ 'assets' ][ 'scripts' ] = $this -> uri[ 'assets' ][ 'main' ] . 'Scripts/';
		

	}
	
	/* data */
	
	protected function obtainDbData(){
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
	
	/* custom */
	
	protected function attachAdminPage(){
		if( is_admin() ){
			add_action( 'admin_menu', array( $this , 'addAdminPage' ) );
		}
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
	
	protected function assignAdminData(){
		if( isset( $_POST[ $this -> subframework_prefix_name ] ) ){
			return;
		}
		
		$this -> mergeDataWithDefaultData();
	}
	
	protected function postActions(){
		
		if( !isset( $_POST[ $this -> subframework_prefix_name ]) || !$_POST[ $this -> subframework_prefix_name ][ 'nonce' ] ||  !$this -> allowAccess( $_POST[ $this -> subframework_prefix_name ][ 'nonce' ] ) ){
			$this -> view -> data[ 'error' ] = true;
			return;
		}
		
		var_dump( 'postActions' );
		
		$this -> post_data = $_POST[ $this -> subframework_prefix_name ];
		
		$this -> action = $this -> post_data[ 'action' ];
		unset( $this -> post_data[ 'action' ] );
		
		switch( $this -> action ){
			case 'save':
			
				// here is a problem
				
				$this -> setData( $this -> decodeHtmlSpecialCharsLoop( $this -> post_data ) );
				$this -> createContainerField();
				
				$this -> getCreate() -> fieldsValidate( array( $this -> getContainerField() ) );
				$data = $this -> getCreate() -> obtainFieldsData( array( $this -> getContainerField() ) );
				
				$this -> view -> data[ 'save' ] = true;
				
			break;
			case 'reset':
				$data = $this -> getDefaultData() ;
			break;
			case 'import':
				if( !empty( $this -> post_data[ 'backup' ] ) ){
					
					$data = ( $unserialize_result =  unserialize( base64_decode( $this -> decodeHtmlSpecialCharsLoop( $this -> post_data ) ) ) ) ? $unserialize_result : $this -> post_data;
					if( !empty( $data[ 'backup' ] ) ){ unset( $data[ 'backup' ] ); };
					
				}else{
					$data = $this -> post_data;
				}
			break;
			case 'export':
				$data = $this -> post_data;
				if( isset( $this -> post_data[ 'backup' ] ) ){ unset( $this -> post_data[ 'backup' ] ); };
				$data[ 'backup' ] =  base64_encode( serialize( $this -> decodeHtmlSpecialCharsLoop( $this -> post_data ) ) ) ;
			break;
			
		}
		
		// add filter to $data

		$data = apply_filters( 'smof_'.$this -> args[ 'framework' ] -> args[ 'mode' ] .'_'. $this -> getInstanceNumber() , $data );
		
		$this -> setData( $data );
		
		if( !empty( $data[ 'backup' ] ) ){ unset( $data[ 'backup' ] ); var_dump( 'backup removed '); }
		$this -> setDbData( $data );
		
	}
	
	public function addAdminPage(){
		
		$page = $this -> page_name = add_theme_page( $this -> theme_data[ 'name' ] , 'Theme Options', 'edit_theme_options', 'smof_options', array( $this , 'controller' ) );
		
		$this -> admin_print['scripts'] = "admin_enqueue_scripts";
		$this -> admin_print['styles'] = "admin_enqueue_scripts";
	
	}
	
	/* fields */
	

	/* enqueue */
	public function enqueueStyles(){
		
		if( !$this -> isSubframeworkPage() ){ return; }
	
		wp_enqueue_style('smof-options-style', $this -> uri[ 'assets' ][ 'css' ] . 'style.css');
		$this -> args[ 'framework' ] -> enqueueStyles();

	
	}
	
	public function enqueueScripts(){
		wp_enqueue_script( 'smof-options', $this -> uri[ 'assets' ][ 'scripts' ] . 'smof.js', array( 'jquery' , 'cookie' ) );
		wp_enqueue_script( 'cookie', $this -> uri[ 'assets' ][ 'scripts' ] . 'cookie.js', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui-tabs' );
	}
	
	/* controller */
	public function controller(){
		
		$this -> args[ 'framework' ] -> enqueueScripts();
		$this -> enqueueScripts();
		
		add_action( 'in_admin_footer' , array( $this -> args[ 'framework' ] , 'printScripts' ) );
		
		$this -> createNonce();
		
		$this -> view = new Views\Main( );
		
		$this -> assignAdminData();
		
		$this -> postActions();
		
		$this -> view -> setData( 'name' , $this -> args[ 'framework' ] -> getThemeData( 'name' ) );
		$this -> view -> setData( 'version' , $this -> args[ 'framework' ] -> getThemeData( 'version' ) );
		$this -> view -> setData( 'content' , $this -> getFieldsContent() );
		$this -> view -> setData( 'menu' , $this -> getContainerField() -> getMetaData() );
		$this -> view -> setData( 'nonce' , $this -> getNonce() );
		
		$this -> view -> view();
		
	}


}

?>