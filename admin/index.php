<?php
// $Id: index.php,v 1.4 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// check to conflict with xoogle

// 2007-07-01 K.OHWADA
// renewal

// 2007-02-18 K.OHWADA
// happy_search_xoops_module_handler.php

//=========================================================
// Happy Search
// porting from suin's search index.php
// 2006-11-11 K.OHWADA
//=========================================================

include 'admin_header.php';

// class
$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();

$op = $config_form->get_post_get_op();

switch($op)
{
case 'save':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->save();
		redirect_header("index.php", 2, _HAPPY_LINUX_SAVED);
	}
	break;

case 'module_save':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		xoops_error("Token Error");
		echo "<br />\n";
		echo $form->get_token_error(1);
		echo "<br />\n";
	}
	else
	{
		$config_store->module_save();
		redirect_header('index.php', 1, _HAPPY_LINUX_SAVED);
	}
	break;

case 'plugin_save':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		xoops_error("Token Error");
		echo "<br />\n";
		echo $form->get_token_error(1);
		echo "<br />\n";
	}
	else
	{
		$config_store->plugin_save();
		redirect_header('index.php', 1, _HAPPY_LINUX_SAVED);
	}
	break;

case 'init':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->init();
		redirect_header("index.php", 2, _HAPPY_LINUX_SAVED);
	}
	break;

case 'upgrade':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->upgrade();
		redirect_header("index.php", 2, _HAPPY_LINUX_SAVED);
	}
	break;

default:
	xoops_cp_header();
	break;
}

happy_search_admin_print_header();

if ( !$config_store->check_init() )
{
	$config_form->print_lib_box_init_config();
}
elseif ( !$config_store->check_upgrade() )
{
	$config_form->print_lib_box_upgrade_config( HAPPY_SEARCH_VERSION );
}
else
{

	if ( file_exists(XOOPS_ROOT_PATH.'/modules/xoogle/class/nusoap.php') ) 
	{
		xoops_error('conflict xoogle');
		echo "<br />\n";
	}

	happy_search_admin_print_menu();

	echo "<h4>" ._MI_HAPPY_SEARCH_ADMIN_CONFIG. "</h4>\n";


	if ( $config_form->exists_plugin_plural() )
	{
		echo "<h4><font color='red'>"._AM_HAPPY_SEARCH_NOTICE."</font></h4>\n";
		echo _AM_HAPPY_SEARCH_NOTICE_PLURAL."<br /><br />\n";
		$config_form->print_form_plugins();
	}

	echo "<h4>" ._MI_HAPPY_SEARCH_ADMIN_CONFIG. "</h4>\n";
	echo _AM_HAPPY_SEARCH_FIRST. ": <br /> \n";
	echo _AM_HAPPY_SEARCH_CHECK_MODULE_NOT_TO_SEARCH. "<br /><br />\n";
	echo _AM_HAPPY_SEARCH_SECOND. ": <br /> \n";
	echo _AM_HAPPY_SEARCH_CHECK_MODULE_TO_SEARCH. "<br /><br />\n";

	$config_form->print_form_modules( _MI_HAPPY_SEARCH_ADMIN_CONFIG );

	echo "<br /><br />\n";
}

happy_search_admin_print_footer();
happy_search_admin_print_powerdby();
xoops_cp_footer();
exit();
// --- main end ---

?>