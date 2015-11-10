<?php

function smofAutoload( $className ) {
	
	$namespace = 'Simput';

	if (0 === strpos($className, $namespace . '\\')){
		
		$fileName = __DIR__ . '\\' . str_replace( $namespace . '\\' , '' , $className ) . '.php';
			
		if (file_exists( $fileName )) {

			include( $fileName );
		}
	}

}
 
spl_autoload_register("smofAutoload");


?>