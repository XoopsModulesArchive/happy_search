<?php
// $Id: version.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $

//================================================================
// Happy Search
// 2007-07-01 K.OHWADA
//================================================================

function happy_search_version_bluesbb() 
{
	$ver = array();

	$ver[1]['version']      = '0.23';
	$ver[1]['file']         = 'bluesbb_023.php';
	$ver[1]['func']         = 'b_search_bluesbb_023';
	$ver[1]['description']  = 'bluesbb v0.23';

	$ver[2]['version']      = '1.04';
	$ver[2]['file']         = 'bluesbb_104.php';
	$ver[2]['func']         = 'b_search_bluesbb_104';
	$ver[2]['description']  = 'bluesbb v1.04';

	return $ver;
}

?>