<?php
// $Id: happy_search_functions.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

// --- happy_search_functions begin ---
if( !function_exists( 'happy_search_get_handler' ) ) 
{

function &happy_search_get_handler($name=null, $module_dir=null)
{
	$ret =& happy_linux_get_handler($name, $module_dir, 'happy_search');
	return $ret;
}

}
// --- happy_search_functions end ---

?>