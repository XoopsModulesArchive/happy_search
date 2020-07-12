<?php
// $Id: oninstall.php,v 1.2 2008/02/16 15:05:00 ohwada Exp $

// 2008-02-16 K.OHWADA
// BUG: Fatal error, if not exist happy_linux

//=========================================================
// Happy Search
// 2007-11-24 K.OHWADA
//=========================================================

$HAPPY_SEARCH_DIRNAME = basename( dirname( __FILE__ ) );

global $xoopsConfig;
$XOOPS_LANGUAGE = $xoopsConfig['language'];

// === xoops_module_install_happy_search ===
// BUG: Fatal error, if not exist happy_linux
// no action here, if not exist
// same process in admin/index.php
if ( file_exists( XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php' ) ) 
{

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php';

include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_config_define.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/class/happy_search_install.php';

// main.php
if (file_exists( XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/main.php' )) 
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/main.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/english/admin.php';
}

// admin.php
if (file_exists( XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/admin.php' )) 
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/admin.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME.'/language/english/admin.php';
}

// --- eval begin ---
eval( '

function xoops_module_install_'. $HAPPY_SEARCH_DIRNAME .'( $module )
{
	return happy_search_install_base( "'. $HAPPY_SEARCH_DIRNAME .'" ,  $module );
}

function xoops_module_update_'. $HAPPY_SEARCH_DIRNAME .'( $module, $prev_version )
{
	return happy_search_update_base( "'. $HAPPY_SEARCH_DIRNAME .'" ,  $module, $prev_version );
}

' );
// --- eval end ---

}
// === xoops_module_install_happy_search ===

// === happy_search_oninstall_base ===
if( ! function_exists( 'happy_search_install_base' ) ) 
{

function happy_search_install_base( $DIRNAME, $module )
{
// prepare for message
	global $ret ; // TODO :-D

// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) 
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($DIRNAME) . '.Success' , 'happy_search_message_append_oninstall' ) ;
		$ret = array() ;
	}
	else 
	{
		if( ! is_array( $ret ) ) $ret = array() ;
	}

// main
	$happy_search =& happy_search_install::getInstance( $DIRNAME );
	$code = $happy_search->install();
	$ret[] = $happy_search->get_message();

	return $code;
}

function happy_search_update_base( $DIRNAME, $module, $prev_version )
{
// prepare for message
	global $msgs ; // TODO :-D

// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) 
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($DIRNAME) . '.Success', 'happy_search_message_append_onupdate' ) ;
		$msgs = array() ;
	}
	else 
	{
		if( ! is_array( $msgs ) ) $msgs = array() ;
	}

// main
	$happy_search =& happy_search_install::getInstance( $DIRNAME );
	$code = $happy_search->update();
	$msgs[] = $happy_search->get_message();

	return $code;
}

// for Cube 2.1
function happy_search_message_append_oninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

// for Cube 2.1
function happy_search_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

// === happy_search_oninstall_base end ===
}

?>