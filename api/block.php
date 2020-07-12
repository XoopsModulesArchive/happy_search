<?php
// $Id: block.php,v 1.2 2007/11/26 03:37:19 ohwada Exp $

// 2007-11-24 K.OHWADA
// move class/nusoap.php to block_search.php

//================================================================
// Happy Search
// 2007-07-01 K.OHWADA
//================================================================

// dir name
$HAPPY_SEARCH_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );

global $xoopsConfig;
$XOOPS_LANGUAGE = $xoopsConfig['language'];

//---------------------------------------------------------
// system
//---------------------------------------------------------
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
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/multibyte.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/language.php';
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
// happy search
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/include/happy_search_constant.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/include/happy_search_functions.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_xoops_module_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_plugin.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_modules.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_google.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search.php';

// main.php
if ( file_exists(XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/main.php') ) 
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/main.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/english/main.php';
}

//---------------------------------------------------------
// suin's search module
//---------------------------------------------------------
// search_make_context
if( !function_exists( 'search_make_context' ) ) 
{
	if ( file_exists(XOOPS_ROOT_PATH.'/modules/'.HAPPY_SEARCH_SEARCH_DIRNAME.'/include/function.php') )
	{
		include_once XOOPS_ROOT_PATH.'/modules/'.HAPPY_SEARCH_SEARCH_DIRNAME.'/include/function.php';
	}
	else
	{
		include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/include/search_function.php';
	}
}

?>