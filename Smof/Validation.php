<?php
namespace Smof;

class Validation{

	protected $data;
	
	public function validate( array $args ){
		
		if( isset( $args[ 'data' ] ) ){
			$this -> data = $args[ 'data' ];
			$this -> data_ref = $args[ 'data' ];
		}else{
			return;
		}
		
		if( isset( $args[ 'conditions' ] ) ){
			$this -> conditions = $args[ 'conditions' ];
		}else{
			return;
		}
		
		$all_results = array();
		
		foreach( $this -> conditions as $condition ){
			$this -> condition = $condition;
			$result = $this -> chooseValidator();
			if( $result !== true ){
				$all_results[] = $result;
			}
		}
		
		return $all_results;
	}
	
	protected function chooseValidator( ){
		if( isset( $this -> condition[ 'method' ] ) && method_exists( get_class() , $this -> condition[ 'method' ] ) ){
			$method = $this -> condition[ 'method' ];
			return $this -> $method();
		}
	}
	
	protected function isEmpty(){
		$result = true;
	
		if( empty( $this -> data ) ){
			$result = __( 'Is empty' , 'smof' );
		}
		
		return $result;
	}
	
	protected function isNumber( ){
		$result = true;
	
		if( !is_numeric( $this -> data )  ){
			$result = __( 'Is not a number' , 'smof' );
		}
		
		return $result;
	}
	
	protected function isBigger( ){
		$this -> data = ( float ) $this -> data;

		if( is_numeric( $this -> data ) &&  $this -> data > $this -> condition[ 'param' ]  ){
			$result = true;
		}else{
			$result = __( $this -> data_ref . 'Is not bigger' , 'smof' );
		}
		
		return $result;
	}
	
	protected function isSmaller(){
	
	}
}

?>