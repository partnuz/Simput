<?php

function smofAutoload( $className ) {
	
	if (0 === strpos($className, 'Smof_')){
		$names = explode( '_' , $className );
		$count = count( $names );
		$count -= 1;
		$realClassName = $names[ $count ];
		
		unset( $names[ $count ] );
		unset( $names[ 0 ] );
		
		$path = implode( '/', $names );
		$filename = __DIR__ .'/'. $path . '/' . $realClassName . ".php";
		if (is_readable($filename)) {
			include( $filename );
		}
	}

}
 
spl_autoload_register("smofAutoload");


?>