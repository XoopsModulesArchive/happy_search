<?php
// $Id: version.php,v 1.2 2007/07/04 11:43:52 ohwada Exp $

//================================================================
// Happy Search
// 2007-06-23 K.OHWADA
//================================================================

function happy_search_version_newbb() 
{
	$ver = array();

	$ver[1]['version']      = '1.00';
	$ver[1]['file']         = 'newbb_100.php';
	$ver[1]['func']         = 'b_search_newbb_100';
	$ver[1]['description']  = 'newbb v1.00';

	$ver[2]['version']      = '2.02';
	$ver[2]['file']         = 'newbb_202.php';
	$ver[2]['func']         = 'b_search_newbb_202';
	$ver[2]['description']  = 'newbb v2.02';

	$ver[3]['version']      = '3.08';
	$ver[3]['file']         = 'newbb_308.php';
	$ver[3]['func']         = 'b_search_newbb_308';
	$ver[3]['description']  = 'newbb v3.08';

	return $ver;
}

?>