<?php
// $Id: header.php,v 1.5 2008/02/16 15:05:00 ohwada Exp $ 

// 2008-02-16 K.OHWADA
// check happy_linux version in the beginning

// 2007-11-24 K.OHWADA
// memory.php
// move class/nusoap.php to index.php

// 2007-07-01 K.OHWADA
// config_basic_handler

// 2007-02-18 K.OHWADA
// happy_search_xoops_module_handler.php

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// system files
//---------------------------------------------------------
require '../../mainfile.php'; 

$XOOPS_LANGUAGE = $xoopsConfig['language'];
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

// search.php
if ( file_exists(XOOPS_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/search.php') ) 
{
	include_once XOOPS_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/search.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/language/english/search.php';
}

//---------------------------------------------------------
// happy_search
//---------------------------------------------------------
if( !defined('HAPPY_SEARCH_DIRNAME') )
{
	define('HAPPY_SEARCH_DIRNAME', $xoopsModule->dirname() );
}

if( !defined('HAPPY_SEARCH_ROOT_PATH') )
{
	define('HAPPY_SEARCH_ROOT_PATH', XOOPS_ROOT_PATH.'/modules/'.HAPPY_SEARCH_DIRNAME );
}

if( !defined('HAPPY_SEARCH_URL') )
{
	define('HAPPY_SEARCH_URL', XOOPS_URL.'/modules/'.HAPPY_SEARCH_DIRNAME );
}

include_once HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_version.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
if ( !file_exists(XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php') ) 
{
	include XOOPS_ROOT_PATH.'/header.php';
	xoops_error( 'require happy_linux module' );
	include XOOPS_ROOT_PATH.'/footer.php';
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php';

// check happy_linux version
if ( HAPPY_LINUX_VERSION < HAPPY_SEARCH_HAPPY_LINUX_VERSION ) 
{
	$msg = 'require happy_linux module v'.HAPPY_SEARCH_HAPPY_LINUX_VERSION.' or later';
	include XOOPS_ROOT_PATH.'/header.php';
	xoops_error( $msg );
	include XOOPS_ROOT_PATH.'/footer.php';
	exit();
}

// start execution time
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/time.php';
$happy_linux_time =& happy_linux_time::getInstance( true );

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/multibyte.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/language.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/locate.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/strings.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/error.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/post.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/system.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/convert_encoding.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/search.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/highlight.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/html.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object_handler.php';

//---------------------------------------------------------
// happy_search
//---------------------------------------------------------
include_once HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_constant.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_functions.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/include/search_function.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_xoops_module_handler.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_plugin.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_modules.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_google.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search.php';

// compatible to old version
include_once HAPPY_SEARCH_ROOT_PATH.'/language/compatible.php';

//---------------------------------------------------------
// suin's search module
//---------------------------------------------------------
if( !function_exists( 'search_make_context' ) ) 
{
	if ( file_exists(XOOPS_ROOT_PATH.'/modules/'.HAPPY_SEARCH_SEARCH_DIRNAME.'/include/function.php') )
	{
		include_once XOOPS_ROOT_PATH.'/modules/'.HAPPY_SEARCH_SEARCH_DIRNAME.'/include/function.php';
	}
	else
	{
		include_once HAPPY_SEARCH_ROOT_PATH.'/include/search_function.php';
	}
}

?>