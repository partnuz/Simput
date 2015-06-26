<?php

function smofAutoload( $className ) {

	if (0 === strpos($className, 'Smof\\')){
		
		$fileName = __DIR__ . '\\' . str_replace( 'Smof\\' , '' , $className ) . '.php';
			
		if (file_exists( $fileName )) {

			include( $fileName );
		}
	}

}
 
spl_autoload_register("smofAutoload");


?>