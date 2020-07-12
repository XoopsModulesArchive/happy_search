<?php
// $Id: admin_header.php,v 1.5 2008/02/16 15:05:00 ohwada Exp $ 

// 2008-02-16 K.OHWADA
// check happy_linux version in the beginning

// 2007-11-24 K.OHWADA
// memory.php

// 2007-07-01 K.OHWADA
// config_basic_handler

// 2007-05-20 K.OHWADA
// use happy_linux/include/gtickets.php

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// system
//---------------------------------------------------------
require '../../../include/cp_header.php';

include_once XOOPS_ROOT_PATH.'/class/template.php';

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
	xoops_cp_header();
	xoops_error( 'require happy_linux module' );
	xoops_cp_footer();
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php';

// check happy_linux version
if ( HAPPY_LINUX_VERSION < HAPPY_SEARCH_HAPPY_LINUX_VERSION ) 
{
	$msg = 'require happy_linux module v'.HAPPY_SEARCH_HAPPY_LINUX_VERSION.' or later';
	xoops_cp_header();
	xoops_error( $msg );
	xoops_cp_footer();
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/gtickets.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/language.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/strings.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/error.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/post.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/system.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/html.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/form.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/form_lib.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/convert_encoding.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/highlight.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_base_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_define_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_store_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/dir.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/admin_menu.php';

//---------------------------------------------------------
// happy_search
//---------------------------------------------------------
$XOOPS_LANGUAGE = $xoopsConfig['language'];

// include files
include_once HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_constant.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_functions.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_install.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_config_define.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_config_handler.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_module_handler.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_xoops_module_handler.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_plugin.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_google.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/class/happy_search_module_store_handler.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/admin/admin_functions.php';
include_once HAPPY_SEARCH_ROOT_PATH.'/admin/admin_config_class.php';

// for main.php
if (file_exists( HAPPY_SEARCH_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/main.php' )) 
{
	include_once HAPPY_SEARCH_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/main.php';
}
else
{
	include_once HAPPY_SEARCH_ROOT_PATH.'/language/english/main.php';
}

// for modinfo.php
if (file_exists( HAPPY_SEARCH_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php' )) 
{
	include_once HAPPY_SEARCH_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php';
}
else
{
	include_once HAPPY_SEARCH_ROOT_PATH.'/language/english/modinfo.php';
}

// compatible to old version
include_once HAPPY_SEARCH_ROOT_PATH.'/language/compatible.php';

?>