<?php
// $Id: table_manage.php,v 1.1 2007/11/26 03:34:21 ohwada Exp $

//================================================================
// Happy Search
// 2007-11-24 K.OHWADA
//================================================================

include 'admin_header.php';

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/table_manage.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/xoops_block_checker.php';

//================================================================
// class admin_table_manage
//================================================================
class admin_table_manage extends happy_linux_table_manage
{
// handler
	var $_module_store_handler;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function admin_table_manage()
{
	$this->happy_linux_table_manage( HAPPY_SEARCH_DIRNAME );

	$this->set_config_handler('config', HAPPY_SEARCH_DIRNAME, 'happy_search' );
	$this->set_config_define( happy_search_config_define::getInstance( HAPPY_SEARCH_DIRNAME ) );
	$this->set_install_class( happy_search_install::getInstance( HAPPY_SEARCH_DIRNAME ) );
	$this->set_xoops_block_checker();

	$this->_module_store_handler =& happy_search_get_handler('module_store', HAPPY_SEARCH_DIRNAME );
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new admin_table_manage();
	}
	return $instance;
}

//---------------------------------------------------------
// function
//---------------------------------------------------------
function get_post_op()
{
	return $this->_post->get_post_get('op');
}

//---------------------------------------------------------
// check
//---------------------------------------------------------
function menu()
{
	happy_search_admin_print_header();
	happy_search_admin_print_menu();

	$this->print_title();

// config table
	$this->print_table_check( 'config' );
	$this->check_config_table();

// module table
	$this->print_table_check( 'module' );
	$this->_check_module_table();

// xoops block table
	$this->check_xoops_block_table();
	$this->print_form_remove_xoops_block_table();

}

function _check_module_table()
{
	if ( !$this->check_table_scheme_by_name( 'module', HAPPY_SEARCH_DIRNAME, 'happy_search' ) );
	{	return false;	}

	if ( !$this->_module_store_handler->compare_to_system() )
	{
		$this->print_red( $this->_module_store_handler->getErrors(1), false );
		echo "<br />\n";
		$this->_print_action_reinstall();
		return false;
	}

	$this->print_blue( "check OK" );
	return true;
}

//---------------------------------------------------------
// print
//---------------------------------------------------------
function _print_action_define()
{
	$this->_print_action_reinstall();
}

function _print_action_scheme()
{
	$this->_print_action_reinstall();
}

// --- class end ---
}


//================================================================
// main
//================================================================

$manage =& admin_table_manage::getInstance();

$op = $manage->get_post_op();

xoops_cp_header();

switch ($op) 
{
case 'remove_block':
	$manage->remove_block();
	break;

case 'menu':
default:
	$manage->menu();
	break;

}

happy_search_admin_print_footer();
xoops_cp_footer();
exit();
// --- main end ---

?>