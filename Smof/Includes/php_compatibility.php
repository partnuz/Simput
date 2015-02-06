<?php
if( !function_exists( 'array_replace_recursive' ) ){

	/**
	* @url: http://fixthatcode.com/entry/4/show
	*/

	function array_replace_recursive($base, $replacements)
	{
		foreach (array_slice(func_get_args(), 1) as $replacements) {
			$bref_stack = array(&$base);
			$head_stack = array($replacements);

			do {
				end($bref_stack);

				$bref = &$bref_stack[key($bref_stack)];
				$head = array_pop($head_stack);

				unset($bref_stack[key($bref_stack)]);

				foreach (array_keys($head) as $key) {
					if (isset($bref[$key]) && is_array($bref[$key]) && is_array($head[$key])) {
						$bref_stack[] = &$bref[$key];
						$head_stack[] = $head[$key];
					} else {
						$bref[$key] = $head[$key];
					}
				}
			} while(count($head_stack));
		}

		return $base;
	}

}

?>