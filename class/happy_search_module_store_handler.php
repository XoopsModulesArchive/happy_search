<?php
// $Id: happy_search_module_store_handler.php,v 1.2 2007/11/26 03:33:02 ohwada Exp $

// 2007-11-24 K.OHWADA
// compare_to_system()
// get_by_mid()

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_module_store_handler') ) 
{

//================================================================
// class happy_search_module_store_handler
//================================================================
class happy_search_module_store_handler extends happy_linux_error
{
// constant
	var $_DIRNAME;

// class
	var $_handler;
	var $_post;
	var $_xoops_module_handler;

	var $_FIRST_NOTSHOW_ARRAY = array('rssc', 'rssc0', 'xoogle');
	var $_SECOND_SHOW_ARRAY   = array('rssc', 'rssc0');
	var $_FLAG_NOT_EXISTS     = false;
	var $_FLAG_NOT_SEARCH     = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_module_store_handler( $dirname )
{
	$this->_DIRNAME =  $dirname;
	$this->_handler =& happy_search_get_handler( 'module',  $dirname );
	$this->_post    =& happy_linux_post::getInstance();

	$this->_xoops_module_handler =& happy_search_xoops_module_handler::getInstance();
}

//---------------------------------------------------------
// compare to system
//---------------------------------------------------------
function compare_to_system()
{
	$this->_clear_errors();

	$xoops_objs =& $this->_xoops_module_handler->get_objects_isactive();

	foreach ( $xoops_objs as $xoops_obj )
	{
		$mid        = $xoops_obj->getVar('mid',       'n');
		$dirname    = $xoops_obj->getVar('dirname',   'n');
		$has_search = $xoops_obj->getVar('hassearch', 'n');

		$count = $this->_handler->get_count_by_key_value( 'mid', intval($mid) );

		if ( ( $has_search == 1 )||( $dirname == 'system' )||( $dirname == 'legacy' ))
		{
			if ( $count > 1 ) 
			{
				$this->_set_errors( "$mid : $dirname : too many record" );
			}
			elseif ( $this->_FLAG_NOT_EXISTS ) 
			{
				if ( $count == 0 ) 
				{
					$this->_set_errors( "$mid : $dirname : no record" );
				}
			}
		}
		elseif ( $this->_FLAG_NOT_SEARCH )
		{
			if ( $count > 0 ) {
				$this->_set_errors( "$mid : $dirname : record exists" );
			}
		}
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// save module
//---------------------------------------------------------
function module_save()
{
	$mid_ids           = $this->_post->get_post('mod_ids');
	$first_notshow_arr = $this->_post->get_post('first_notshows');
	$second_show_arr   = $this->_post->get_post('second_shows');

	$count = count($mid_ids);
	if (!is_array($mid_ids) || ($count <= 0))  return; 

// list from POST
	for ( $i=0; $i<$count; $i++ ) 
	{
		$mid =  $mid_ids[$i];
		$obj =& $this->_handler->get_by_mid( $mid );

// create, when not in MySQL
		$flag_insert        = false;
		$first_notshow_save = 0;
		$second_show_save   = 0;

		if ( is_object($obj) )
		{
			$first_notshow_save = $obj->get('first_notshow');
			$second_show_save   = $obj->get('second_show');
		}
		else
		{
			$flag_insert = true;
			$obj =& $this->_handler->create();
			$obj->setVar('mid', $mid );
		}

		$first_notshow = $this->make_int($first_notshow_arr, $mid);
		$second_show   = $this->make_int($second_show_arr,   $mid);

		$obj->setVar('first_notshow',  $first_notshow );
		$obj->setVar('second_show',    $second_show );

// insert, when not in MySQL
		if ( $flag_insert )
		{
			$this->_handler->insert($obj);
		}
// update
		else
		{
			if (($first_notshow != $first_notshow_save)||($second_show   != $second_show_save))
			{
				$this->_handler->update($obj);
			}
		}

		unset($obj);
	}

}

function plugin_save()
{
	$mid_ids           = $this->_post->get_post('mod_ids');
	$plugin_num_arr    = $this->_post->get_post('plugin_nums');
	$plugin_file_arr   = $this->_post->get_post('plugin_file_nums');
	$plugin_func_arr   = $this->_post->get_post('plugin_func_nums');

	$count = count($mid_ids);
	if (!is_array($mid_ids) || ($count <= 0))  return; 

// list from POST
	for ( $i=0; $i<$count; $i++ ) 
	{
		$mid =  $mid_ids[$i];
		$obj =& $this->_handler->get_by_mid( $mid );

// create, when not in MySQL
		$flag_insert        = false;
		$plugin_file_save   = '';
		$plugin_func_save   = '';

		if ( is_object($obj) )
		{
			$plugin_file_save   = $obj->get('plugin_file');
			$plugin_func_save   = $obj->get('plugin_func');
		}
		else
		{
			$flag_insert = true;
			$obj =& $this->_handler->create();
			$obj->setVar('mid', $mid );
		}

		$plugin_num   = $this->make_int($plugin_num_arr, $mid);
		$plugin_file  = $this->make_plugin_text($plugin_file_arr,  $mid, $plugin_num);
		$plugin_func  = $this->make_plugin_text($plugin_func_arr,  $mid, $plugin_num);

		$obj->setVar('plugin_file',    $plugin_file );
		$obj->setVar('plugin_func',    $plugin_func );

// insert, when not in MySQL
		if ( $flag_insert )
		{
			$this->_handler->insert($obj);
		}
// update
		else
		{
			if (($plugin_file != $plugin_file_save)||($plugin_func != $plugin_func_save))
			{
				$this->_handler->update($obj);
			}
		}

		unset($obj);
	}

}

//---------------------------------------------------------
// init
//---------------------------------------------------------
function init()
{
	$xoops_objs =& $this->_xoops_module_handler->get_objects_isactive();

	foreach ( $xoops_objs as $xoops_obj )
	{
		$mid       = $xoops_obj->getVar('mid');
		$dirname   = $xoops_obj->getVar('dirname','s');

		$first_notshow = 0;
		$second_show   = 0;

		if ( in_array($dirname, $this->_FIRST_NOTSHOW_ARRAY) )
		{
			$first_notshow = 1;
		}
		if ( in_array($dirname, $this->_SECOND_SHOW_ARRAY) )
		{
			$second_show = 1;
		}

		$obj =& $this->_handler->create();
		$obj->setVar('mid',           $mid );
		$obj->setVar('first_notshow', $first_notshow );
		$obj->setVar('second_show',   $second_show );

		$this->_handler->insert($obj);
		unset($obj);
	}

}

function check_init()
{
	if ( $this->_handler->getCount() )
	{	return true;	}
	return false;
}

//---------------------------------------------------------
// upgrade
//---------------------------------------------------------
function upgrade()
{
// dummy
	return true;
}

//---------------------------------------------------------
// drop and create table
//---------------------------------------------------------
function drop_create_table()
{
	$this->_clear_errors();

	$ret = $this->_handler->drop_table( $this->_handler->get_magic_word() );
	if ( !$ret )
	{
		$this->_set_errors( $this->_handler->getErrors() );
	}

	$ret = $this->_handler->create_table();
	if ( !$ret )
	{
		$this->_set_errors( $this->_handler->getErrors() );
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// get value for input
//---------------------------------------------------------
function make_int($arr, $key, $default=0)
{
	if ( isset($arr[$key]) )
	{
		return intval($arr[$key]);
	}
	return intval($default);
}

function make_text($arr, $key, $default='')
{
	if ( isset($arr[$key]) )
	{
		return trim($arr[$key]);
	}
	return trim($default);
}

function make_plugin_text($arr, $key1, $key2, $default='')
{
	if ( isset($arr[$key1][$key2]) )
	{
		return trim($arr[$key1][$key2]);
	}
	return trim($default);
}

// --- class end ---
}

// === class end ===
}

?>