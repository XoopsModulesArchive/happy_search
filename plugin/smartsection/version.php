<?php
// $Id: version.php,v 1.1 2007/11/25 00:05:05 ohwada Exp $

//================================================================
// Happy Search
// 2007-11-25 K.OHWADA
//================================================================

function happy_search_version_smartsection() 
{
	$ver = array();

	$ver[1]['version']      = '2.10';
	$ver[1]['file']         = 'smartsection_210.php';
	$ver[1]['func']         = 'b_search_smartsection_210';
	$ver[1]['description']  = 'smartsection v2.10';

	$ver[2]['version']      = '2.13';
	$ver[2]['file']         = 'smartsection_213.php';
	$ver[2]['func']         = 'b_search_smartsection_213';
	$ver[2]['description']  = 'smartsection v2.13';

	return $ver;
}

?>