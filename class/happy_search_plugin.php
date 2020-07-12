<?php
// $Id: happy_search_plugin.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $ 

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_plugin') ) 
{

//=========================================================
// class happy_search_plugin
//=========================================================
class happy_search_plugin
{

// constant
	var $_DIRNAME;

// class
	var $_happy_search_module_handler;
	var $_xoops_module_handler;

	var $_DIR_PLUGIN_REL;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_plugin( $dirname )
{
	$this->_happy_search_module_handler =& happy_search_get_handler('module', $dirname );
	$this->_xoops_module_handler        =& happy_search_xoops_module_handler::getInstance();

	$this->_DIR_PLUGIN_REL = 'modules/'. $dirname .'/plugin';

}

function &getInstance( $mod_dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search_plugin( $mod_dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// function
//---------------------------------------------------------
// happy_search_modules.php
function get_search_func_by_xoops_module_obj( &$xoops_module_obj )
{
	$mid          = $xoops_module_obj->getVar('mid');
	$mod_dirname  = $xoops_module_obj->getVar('dirname');

	$file_search  = $this->_get_file_search( $mod_dirname );
	$func_search  = $this->_get_func_search( $mod_dirname );

	$search_obj =& $this->_happy_search_module_handler->get( $mid );
	if ( is_object($search_obj) )
	{
		$plugin_file = $search_obj->getVar('plugin_file');
		$plugin_func = $search_obj->getVar('plugin_func');

		if( $plugin_file && file_exists( XOOPS_ROOT_PATH.'/'.$plugin_file ) )
		{
			include_once XOOPS_ROOT_PATH.'/'.$plugin_file;
			if ( function_exists($plugin_func) )
			{
				return $plugin_func;
			}
		}
	}

	if( file_exists( XOOPS_ROOT_PATH.'/'.$file_search ) )
	{
		include_once XOOPS_ROOT_PATH.'/'.$file_search;
		if ( function_exists($func_search) )
		{
			return $func_search;
		}
	}

	$arr =& $this->_xoops_module_handler->get_search_file_func( $xoops_module_obj );
	if ( isset($arr['file']) && isset($arr['func']) )
	{
		$file_mod = $arr['file'];
		$func_mod = $arr['func'];

		if( file_exists( XOOPS_ROOT_PATH.'/'.$file_mod ) )
		{
			include_once XOOPS_ROOT_PATH.'/'.$file_mod;
			if ( function_exists($func_mod) )
			{
				return $func_mod;
			}
		}
	}

	return false;
}

// admin_config_form
function &get_plugins_by_xoops_module_obj( &$xoops_module_obj )
{
	$mod_dirname  = $xoops_module_obj->getVar('dirname');

	$file_version = $this->_get_file_version( $mod_dirname );
	$file_search  = $this->_get_file_search(  $mod_dirname );
	$func_version = $this->_get_func_version( $mod_dirname );
	$func_search  = $this->_get_func_search(  $mod_dirname );

	$num = 0;
	$plugins = array();

	$arr =& $this->_xoops_module_handler->get_search_file_func( $xoops_module_obj );
	if ( isset($arr['file']) && isset($arr['func']) )
	{
		$plugins[$num] = array(
			'num'   => $num, 
			'file'  => $arr['file'],
			'func'  => $arr['func'],
			'title' => 'in '.$mod_dirname,
		);
		$num ++;
	}

	if ( file_exists(XOOPS_ROOT_PATH.'/'.$file_version) )
	{
		include_once XOOPS_ROOT_PATH.'/'.$file_version;

		if ( function_exists($func_version) )
		{
			$ver_list = $func_version();

			foreach ($ver_list as $ver)
			{
				$ver_version     = $ver['version'];
				$ver_file        = $ver['file'];
				$ver_func        = $ver['func'];
				$ver_description = $ver['description'];

				$file_ver = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/'.$ver_file;

				if ( file_exists(XOOPS_ROOT_PATH.'/'.$file_ver) )
				{
					if ($ver_description)
					{
						$title = $ver_description;
					}
					else
					{
						$title = $ver_version;
					}

					$plugins[$num] = array(
						'num'   => $num, 
						'file'  => $file_ver,
						'func'  => $ver_func,
						'title' => $title,
					);
					$num ++;
				}
			}
		}
	}
	elseif ( file_exists(XOOPS_ROOT_PATH.'/'.$file_search) )
	{
		$plugins[$num] = array(
			'num'   => $num, 
			'file'  => $file_search,
			'func'  => $func_search,
			'title' => 'in happy search',
		);
		$num ++;
	}

	return $plugins;
}

function check_plural_plugins( $mod_dirname )
{
	$file_version = $this->_get_file_version( $mod_dirname );
	$file_search  = $this->_get_file_search(  $mod_dirname );

	if( file_exists( XOOPS_ROOT_PATH.'/'.$file_version ) )
	{
		return true;
	}
	elseif( file_exists( XOOPS_ROOT_PATH.'/'.$file_search ) )
	{
		return true;
	}
	return false;
}

function _get_file_version( $mod_dirname )
{
	$file = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/version.php';
	return $file;
}

function _get_file_search( $mod_dirname )
{
	$file = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/'.$mod_dirname.'.php';
	return $file;
}

function _get_func_version( $mod_dirname )
{
	$func = 'happy_search_version_'.$mod_dirname;
	return $func;
}

function _get_func_search( $mod_dirname )
{
	$func = 'b_search_'.$mod_dirname;
	return $func;
}

// --- class end ---
}

// === class end ===
}

?>