<?php

namespace Simput\Subframeworks;

abstract class Subframework{
	
	protected $default_options;
	protected $options;
	protected $uri;
	protected $path;
	public $args;

	protected $data;
	protected $default_data = array();
	
	public $admin_print;

	protected $container_field;
	protected $container_options;
	
	protected $create;
	protected $nonce;
	protected static $instance_num = 0;
	
	protected $subframework_prefix_name = 'smof';
	protected $current_page = 'appearance_page_smof_options';
	
	/* create */
	protected function assignCreate(){
		
		if( !is_admin() ) return;
		
		$this -> create = new \Simput\Create( array(
			'framework' => $this -> args[ 'framework' ],
			'subframework' => $this
		));
		
	}
	
	public function getCreate(){
		
		return $this -> create;
		
	}
	
	/* args */
	public function getArgs( $key = ''){
		if( $key ){
			return $this -> args[ $key ];
		}else{
			return $this -> args;
		}
	}
	
	protected function assignArgs( array $args ){
		$this -> args = array_replace_recursive( $this -> obtainDefaultArgs() , $args );
	}
	
	abstract protected function obtainDefaultArgs();
	
	/* paths */
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
	
	abstract protected function assignPath();
	abstract protected function assignUris();
	
	/* container */
	public function getContainerField(){
		
		return $this -> container_field;
		
	}
	
	public function createContainerField(){
		
		$this -> container_field = $this -> getCreate() -> createFieldFromOptions( $this -> getData() , $this -> options[ 0 ] , array(
			'framework' => $this -> args[ 'framework' ],
			'subframework' => $this
		) );
	}
	
	
	protected function containerOptions(){
		
		return array(
			'id' => 'container',
			'type' => 'container'
			
		);
		
	}
	
	protected function assignContainerOptions(){
		
		$this -> container_options = $this -> containerOptions();
		
	}
	
	protected function wrapOptionsInsideContainer(){
		
		$this -> container_options[ 'fields'] = $this -> getOptions();
		$this -> setOptions( array( $this -> container_options ) );
		
	}
	
	/* options */
	protected function getOptions(){
		
		return $this -> options;

	} 
	
	protected function setOptions( array $options ){
		
		$this -> options = $options;
		
	}
	
	/* data */
	protected function setData( array $data ){
		$this -> data = $data;
	}
	
	public function getData(){
		return $this -> data;
	}
	
	public function getDefaultData(){
		
		return $this -> default_data;
	}
	
	public function  setDefaultData( $val ){
		
		$this -> default_data = $val;
	}
	

	protected function mergeDataWithDefaultData(){
	
		$this -> setData( array_replace_recursive(  $this -> getDefaultData() , $this -> getData() ) ) ;
		
	}

	protected function obtainDefaultDataFromOptions( $options ){

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
					$options_defaults = $options_defaults + $this -> obtainDefaultDataFromOptions( $option[ 'fields' ] );
				}elseif( $field_properties[ 'inheritance' ] === 'parent_children' ){
					$options_defaults[ $id ] = $this -> obtainDefaultDataFromOptions( $option[ 'fields' ] );
				}
			
			}
			
		}
		
		return $options_defaults;
			
	}
	
	/* enqueue */
	
	public function enqueueStyles(){
	}
	
	public function enqueueScripts(){
		
	}
	
	public function enqueueStylesWrapper(){
		add_action( 'admin_enqueue_scripts' , array( $this , 'enqueueStyles' ) );
	}

	/* controller */
	abstract public function controller();
	/* fields */
	public function getFieldName( array $name , $args = array() ){
	
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
		
		$real_name = $this -> subframework_prefix_name . $real_name;
		return $real_name;
		
	}
	
	public function getFieldId( array $id , $args = array() ){
	
		$defaults = array(
		);
		
		$args = wp_parse_args( $args , $defaults );

		return implode( '-' , $id );
		
	}
	
	public function getFieldClass( array $class , $args = array() ){
		
		// format same as id 
		return $this -> getFieldId( $class );
		
	}
	/* other */
	protected function increaseInstanceNumber(){
		
		static :: $instance_num++;
		
	}
	
	public function getInstanceNumber(){
		return static :: $instance_num;
	}
	
	protected function createNonce(){
		
		$nonce = 'smof_' . $this -> args[ 'framework' ] -> args[ 'mode' ] .'_'. $this -> getInstanceNumber();
		$this -> nonce = wp_create_nonce( $nonce );
		
	}
	
	protected function getNonce(){
		return $this -> nonce;
	}
	
	public function assignUserRole(){
	
		$this -> user_role = wp_get_current_user() -> roles;
		
	}
	
	public function allowAccess( $new_nonce ){
		
		foreach( $this -> user_role as $role ){
			
			if( in_array( $role, $this -> args[ 'access_roles' ] ) !== false && $this -> getNonce() === $new_nonce ){
				
				return true;
			
			}
			
		}
		
		return false;
		
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
	
	// must be called late
	public function isSubframeworkPage(){
		
		global $current_screen;
		
		if( $this -> current_page == $current_screen -> base ){
			
			return true;
			
		}else{
			
			return false;
			
		};
		
	}

}

?>