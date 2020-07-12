<?php
// $Id: happy_search_modules.php,v 1.8 2008/07/09 07:51:54 ohwada Exp $ 

// 2008-07-01 K.OHWADA
// added img_url
// check exist time

// 2008-01-18 K.OHWADA
// Notice [PHP]: Only variables should be assigned by reference

// 2007-11-24 K.OHWADA
// build_measure_detail()
// Only variables should be assigned by reference

// 2007-07-01 K.OHWADA
// config_basic_handler
// get_all_module_list()

// 2007-05-20 K.OHWADA
// XC 2.1

// 2007-02-18 K.OHWADA
// xoops_modules_handler
// $_strict_dirname_flag
// Warning: array_merge() [function.array-merge]: Argument #1 is not an array on line 518
// Warning: usort() [function.usort]: The argument should be an array on line 535

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_modules') ) 
{

define('HAPPY_SEARCH_CODE_NORMAL',        0);
define('HAPPY_SEARCH_CODE_SEARCH',      301);
define('HAPPY_SEARCH_CODE_ENTER',       302);
define('HAPPY_SEARCH_CODE_NOPERM',      303);
define('HAPPY_SEARCH_CODE_KEYTOOSHORT', 304);

//=========================================================
// class happy_search_modules
// porting from suin's search index.php
//=========================================================
class happy_search_modules extends happy_linux_search
{

// constant
	var $_DIRNAME;
	var $_MAX_SHOWALL = 10;

// class
	var $_happy_search_module_handler;
	var $_xoops_module_handler;
	var $_plugin;
	var $_highlight;
	var $_time;

// action results
	var $_search_results = null;
	var $_modules        = null;
	var $_measure_array  = array();

// action showall
	var $_showall_results  = null;
	var $_module_name_show = null;
	var $_navi             = null;

// set parameter
	var $_flag_highlight       = false;

// local
	var $_module_objs_cached = null;

	var $_mid_list_groupperm;
	var $_mid_list_first_search;
	var $_mid_list_second_search;
	var $_mid_list_all;

	var $_mid_list_search = null;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_modules( $dirname )
{
	$this->_DIRNAME = $dirname;

	$this->happy_linux_search();
	$this->set_lang_zenkaku( _HAPPY_LINUX_ZENKAKU );
	$this->set_lang_hankaku( _HAPPY_LINUX_HANKAKU );

	$this->_happy_search_module_handler =& happy_search_get_handler('module', $dirname );
	$this->_xoops_module_handler        =& happy_search_xoops_module_handler::getInstance();
	$this->_plugin                      =& happy_search_plugin::getInstance( $dirname );

	$this->_highlight =& happy_linux_highlight::getInstance();
	$this->_time      =& happy_linux_time::getInstance();

	$this->_highlight->set_replace_callback( 'happy_linux_highlighter_by_class' );
	$this->_highlight->set_class( 'happy_search_highlight' );

// load
	$this->_load_mid_list_groupperm();
	$this->_load_first_search_list();
	$this->_load_second_search_list();
	$this->_load_all_list();
}

//---------------------------------------------------------
// search list
//---------------------------------------------------------
function _load_mid_list_groupperm()
{
	$list =& $this->_system->get_groupperm_mid_list();

// XC 2.1
	$legacy_mid = $this->_system->get_mid_by_dirname( 'legacy' );
	if ($legacy_mid)
	{
		$list[] = $legacy_mid;
	}

	$this->_mid_list_groupperm =& $list;
}

function _load_first_search_list()
{
	$notshow_list =& $this->_happy_search_module_handler->get_list_first_notshow();

	$arr = array();
	if ( is_array($this->_mid_list_groupperm) && count($this->_mid_list_groupperm) )
	{
		if ( is_array($notshow_list) && count($notshow_list) ) 
		{
			foreach( $this->_mid_list_groupperm as $mid )
			{
				if ( !in_array($mid, $notshow_list) )
				{
					$arr[] = $mid;
				}
			}
		}
		else
		{
			$arr =& $this->_mid_list_groupperm;
		}
	}

	$this->_mid_list_first_search =& $this->_xoops_module_handler->get_list_in_group( $arr );
}

function _load_second_search_list()
{
	$show_list =& $this->_happy_search_module_handler->get_list_second_show();

	$arr = array();
	if ( is_array($this->_mid_list_groupperm) && count($this->_mid_list_groupperm) )
	{
		if ( is_array($show_list) && count($show_list) ) 
		{
			foreach( $this->_mid_list_groupperm as $mid )
			{
				if ( in_array($mid, $show_list) )
				{
					$arr[] = $mid;
				}
			}
		}
	}

	$this->_mid_list_second_search =& $this->_xoops_module_handler->get_list_in_group( $arr );
}

function _load_all_list()
{
	$arr1 =& $this->_mid_list_first_search;
	$arr2 =& $this->_mid_list_second_search;
	$arr3 =  array();

	if ( is_array($arr1) && is_array($arr2) )
	{
		$arr  = array_merge($arr1, $arr2);
		$arr3 = array_unique($arr);
	}
	elseif ( is_array($arr1) )
	{
		$arr3 =& $arr1;
	}
	elseif ( is_array($arr2) )
	{
		$arr3 =& $arr2;
	}

	$this->_mid_list_all =& $arr3;
}

//---------------------------------------------------------
// check_param
//---------------------------------------------------------
function check_post_get_param_default()
{
	$param = array(
		'action' => $this->_post_action,
		'query'  => $this->_post_query,
		'mid'    => $this->_post_mid,
		'uid'    => $this->_post_uid,
	);

	$ret = $this->check_post_get_param( $param );
	return $ret;
}

function check_post_get_param( &$param )
{
	$action = $param['action'];
	$query  = $param['query'];
	$mid    = $param['mid'];
	$uid    = $param['uid'];

	switch ($action) 
	{
		case 'search':
			return HAPPY_SEARCH_CODE_SEARCH;	// show search form
			break;

		case 'results':
			if ( $query == '' ) 
			{
				return HAPPY_SEARCH_CODE_ENTER;	// goto this module
			}
			return HAPPY_SEARCH_CODE_NORMAL;	// OK
			break;

		case 'showall':
			if ( $query == '' || empty($mid) )
			{
				return HAPPY_SEARCH_CODE_ENTER;	// goto this module
			}
			if ( !$this->_check_show_mid($mid) )
			{
				return HAPPY_SEARCH_CODE_NOPERM;	// no permission
			}
			return HAPPY_SEARCH_CODE_NORMAL;	// OK
			break;

		case 'showallbyuser':
			if ( empty($mid) || empty($uid) )
			{
				return HAPPY_SEARCH_CODE_ENTER;	// goto this module
			}
			if ( !$this->_check_show_mid($mid) )
			{
				return HAPPY_SEARCH_CODE_NOPERM;	// no permission
			}
			return HAPPY_SEARCH_CODE_NORMAL;	// OK
			break;

		default:
			break;
	}

	return HAPPY_SEARCH_CODE_NORMAL;	// dummy
}

function _check_show_mid($mid)
{
	if( in_array($mid, $this->_mid_list_all) )
	{
		return true;
	}
	return false;
}

//---------------------------------------------------------
// action_results
//---------------------------------------------------------
function action_results_default( $limit )
{
	$_GET['showcontext'] = $this->_post_showcontext;

	$param = array(
		'mid'                  => '',
		'uid'                  => '',
		'start'                => 0,
		'action'               => $this->_post_action,
		'mids'                 => $this->_post_mids,
		'showcontext'          => $this->_post_showcontext,
		'andor'                => $this->_mode_andor,
		'query_array'          => $this->_query_array,
		'candidate_array'      => $this->_candidate_array,
		'merged_query_array'   => $this->get_merged_query_array(),
		'limit'                => $limit,
	);

	$ret = $this->action_results( $param );
	return $ret;
}

function action_results( &$param )
{
// clear result
	$this->_search_results = null;
	$this->_modules        = null;

	$mids        =  $param['mids'];
	$limit       =  $param['limit']; 
	$query_array =& $param['query_array'];

	if ( ($limit == 0) || !is_array($query_array) || (count($query_array) == 0) )
	{
		return true;	// no action
	}

	if ( !is_array($this->_mid_list_search) || ( count($this->_mid_list_search) == 0 ) )
	{
		return false;
	}

	if ( empty($mids) || !is_array($mids) ) 
	{
		return true;	// no action
	}

	$results = array();
	foreach ($mids as $mid) 
	{
		if ( in_array($mid, $this->_mid_list_search ) )
		{
			$obj =& $this->_xoops_module_handler->get_cache($mid);
			if ( is_object($obj) )
			{
				$param['mid']        =  $mid;
				$param['module_obj'] =& $obj;
				$results[] =& $this->_build_single_module( $param );
			}
		}
	}

// set result
	$this->_search_results =& $results;
	$this->_modules        =& $module_objs;
	return true;	// OK
}

function &_build_single_module( &$param )
{
	$limit       =  $param['limit']; 
	$showcontext =  $param['showcontext'];
	$module_obj  =& $param['module_obj'];

	if ( !is_object($module_obj) )
	{
		$false = false;
		return $false;
	}

	$this_dirname = $module_obj->getVar('dirname');
	$this_mid     = $module_obj->getVar('mid');
	$this_name    = $module_obj->getVar('name');

	$results =& $this->_search_single_module( $param );
	$count   =  count($results);

	if ( $count > $limit ) 
	{
		$results = array_slice($results, 0, $limit);
		$count   = $limit;
	}

 	if (!is_array($results) || $count == 0) 
 	{
		$no_match     = _SR_NOMATCH;
		$showall_link = '';
	}
	else 
	{
		$no_match = "";

		$results =& $this->_format_result( $results, $param );

		if ( $count == $limit ) 
		{
			$search_url   = $this->_build_search_url( 'showall', $param );
			$showall_link = '<a href="'. $search_url .'">'. _SR_SHOWALLR .'</a>';
		}
		else 
		{
			$showall_link = '';
		}
	}

	$module_results = array(
		'mid'          => $this_mid,
		'dirname'      => $this_dirname,
		'name'         => $this_name,
		'results'      => $results,
		'showall_link' => $showall_link,
		'no_match'     => $no_match,
	);

	unset($results1);
	unset($results2);
	unset($results);
	unset($module_obj);

	return $module_results;
}

function &get_search_results()
{
	return $this->_search_results;
}

//---------------------------------------------------------
// action_showall
//---------------------------------------------------------
function action_showall_default()
{
	$param = array(
		'action'               => $this->_post_action,
		'uid'                  => $this->_post_uid,
		'mid'                  => $this->_post_mid,
		'mids'                 => $this->_post_mids,
		'start'                => $this->_post_start,
		'showcontext'          => $this->_post_showcontext,
		'andor'                => $this->_mode_andor,
		'query_array'          => $this->_query_array,
		'candidate_array'      => $this->_candidate_array,
		'merged_query_array'   => $this->get_merged_query_array(),
		'limit'                => $this->_MAX_SHOWALL,
	);

	$ret = $this->action_showall( $param );
	return $ret;
}

function action_showall( &$param )
{
	$action      =  $param['action'];
	$mid         =  $param['mid']; 
	$uid         =  $param['uid']; 
	$start       =  $param['start']; 
	$limit       =  $param['limit']; 
	$andor       =  $param['andor'];
	$showcontext =  $param['showcontext'];
	$query_array =& $param['query_array'];

	$module_obj =& $this->_xoops_module_handler->get($mid);
	if ( !is_object($module_obj) )
	{	return false;	}

	$this_dirname =  $module_obj->getVar('dirname');
	$this_name    =  $module_obj->getVar('name');

	$param['module_obj'] = $module_obj;
	$results =& $this->_search_single_module( $param );

	if ( is_array($results) && count($results) ) 
	{
		$count = count($results);

		$next_results =& $module_obj->search( $query_array, $andor, 1, $start + $limit, $uid );
		$next_count = count($next_results);
		$has_next = false;

		if ( is_array($next_results) && ($next_count == 1) )
		{
			$has_next = true;
		}

		$results =& $this->_format_result($results, $param );
		$search_url = $this->_build_search_url( $action, $param );

		$navi = '<table><tr>';

		if ( $start > 0 ) 
		{
			$prev     = $start - $limit;
			$url_prev = $search_url .'&start='. $prev;
			$navi .= "\n".'<td align="left">';
			$navi .= "\n".'<a href="'. htmlspecialchars($url_prev) .'">'. _SR_PREVIOUS .'</a></td>';
		}

		$navi .= "\n".'<td>&nbsp;&nbsp;</td>';

		if ( false != $has_next ) 
		{
			$next     = $start + $limit;
			$url_next = $search_url .'&start='. $next;
			$navi .= "\n".'<td align="right"><a href="'. htmlspecialchars($url_next) .'">'. _SR_NEXT .'</a></td>';
		}

		$navi .= "\n".'</tr></table>'."\n";
	}

	$this->_showall_results  =& $results;
	$this->_module_name_show =  $this->_strings->sanitize_text($this_name);
	$this->_navi             =  $navi;

	return true;
}

function &get_showall_results()
{
	return $this->_showall_results;
}

//---------------------------------------------------------
// private common
//---------------------------------------------------------
function &_search_single_module( &$param )
{
	$time_begin   = $this->_time->get_microtime();
	$memory_begin = happy_linux_memory_get_usage();

	$uid                 =  $param['uid']; 
	$start               =  $param['start']; 
	$limit               =  $param['limit'];
	$andor               =  $param['andor'];
	$showcontext         =  $param['showcontext'];
	$query_array         =& $param['query_array'];
	$candidate_array     =& $param['candidate_array'];
	$module_obj          =& $param['module_obj']; 

	$this_dirname = $module_obj->getVar('dirname');

	$results1 = array();
	$results2 = array();
	$results  = array();

	$func = $this->_plugin->get_search_func_by_xoops_module_obj( $module_obj );
	if ( !function_exists($func) )
	{
		return $results;
	}

// Only variables should be assigned by reference
	$results1 = $func( $query_array, $andor, $limit, $start, $uid );

	if( is_array($candidate_array) && count($candidate_array) )
	{
		$arr = array();
		foreach ( $candidate_array as $candidate )
		{
			$arr[] = $candidate['keyword'];
		}

// Notice [PHP]: Only variables should be assigned by reference
		$results2 = $func( $arr, $andor, $limit, $start, $uid );
	}

// Warning: array_merge() Argument #1 is not an array
	if( is_array($results1) && count($results1) && is_array($results2) && count($results2) )
	{
		$results = array_merge($results1, $results2);
	}
	elseif( is_array($results1) && count($results1) )
	{
		$results =& $results1;
	}
	elseif( is_array($results2) && count($results2) )
	{
		$results =& $results2;
	}

// Warning: usort() The argument should be an array
	if( is_array($results) && count($results) )
	{
		usort($results, 'happy_search_sort_by_date');
	}

	$this->_measure_array[ $this_dirname ] = array(
		'time'   => $this->_time->get_microtime()  - $time_begin,
		'memory' => happy_linux_memory_get_usage() - $memory_begin,
	);

	return $results;
}

function &_get_search_func( &$param )
{
	$module_obj   =& $param['module_obj']; 
	$this_mid     =  $module_obj->getVar('mid');
	$this_dirname =  $module_obj->getVar('dirname');

	$mod_obj =& $this->_happy_search_module_handler->get( $this_mid );
	if ( is_object($mod_obj) )
	{
		$file_plugin = $mod_obj->getVar('plugin');
		if( $file_plugin && file_exists( XOOPS_ROOT_PATH.'/'.$file_plugin ) )
		{
			include_once XOOPS_ROOT_PATH.'/'.$file_plugin;
			$func = 'b_search_'.$this_dirname;
			if ( function_exists($func) )
			{
				return $func;
			}
		}
	}

	if( file_exists( XOOPS_ROOT_PATH.'/modules/'.$this->_DIRNAME.'/plugin/'.$this_dirname.'/'.$this_dirname.'.php' ) )
	{
		include_once XOOPS_ROOT_PATH.'/modules/'.$this->_DIRNAME.'/plugin/'.$this_dirname.'/'.$this_dirname.'.php';
		$func = 'b_search_'.$this_dirname;
		if ( function_exists($func) )
		{
			return $func;
		}
	}

	$func = $this->_xoops_module_handler->get_search_func( $module_obj );
	return $func;
}

function &_format_result( &$results, &$param )
{
	$showcontext        =  $param['showcontext'];
	$module_obj         =& $param['module_obj'];
	$merged_query_array =& $param['merged_query_array'];

	$this_dirname = $module_obj->getVar('dirname');
	$count = count($results);

	for ($i=0; $i<$count; $i++) 
	{
		$res = $results[$i];

		$title      = '';
		$link       = '';
		$uid        = '';
		$uname      = '';
		$time       = 0;
		$time_l     = '';
		$time_s     = '';
		$context    = '';
		$full_link  = '';
		$img_url    = '';
		$img_width  = 0;
		$img_height = 0;

		if ( isset($res['title']) && $res['title'] )
		{
			$title = $this->_strings->sanitize_text( $res['title'] );
		}

		if ( isset($res['link']) && $res['link'] )
		{
			$link = $this->_strings->sanitize_url( $res['link'] );
			$link = '/modules/'. $this_dirname .'/'. $link;
		}

		if ( isset($res['image']) && $res['image'] )
		{
			$image = $this->_strings->sanitize_url( $res['image'] );
			$image = '/modules/'. $this_dirname .'/'. $image;
		}
		else 
		{
			$image = '/modules/'. $this->_DIRNAME .'/images/posticon.gif';
		}

		if ( isset($res['uid']) && $res['uid'] )
		{
			$uid   = intval( $res['uid'] );
			$uname = XoopsUser::getUnameFromId( $uid );
		}

// check exist time
		if ( isset($res['time']) && $res['time']  )
		{
			$time   = intval( $res['time'] );
			$time_l = formatTimestamp( $time, 'l' );
			$time_m = formatTimestamp( $time, 'm' );
			$time_s = formatTimestamp( $time, 's' );
		}

		if ( isset($res['context']) && $res['context'] )
		{
			$context = $this->_strings->sanitize_textarea( $res['context'] );

			if ( $this->_flag_highlight )
			{
				$context = $this->_highlight->build_highlight_keyword_array($context, $merged_query_array);
			}

			if ( $showcontext != 1 )
			{
				$context = '';
			}
		}

		if ( isset($res['full_link']) && $res['full_link'] )
		{
			$full_link = $this->_strings->sanitize_url( $res['full_link'] );
		}

		if ( isset($res['img_url']) && $res['img_url'] )
		{

			$img_url = $this->_strings->sanitize_url( $res['img_url'] );
			if ( isset($res['img_width']) && isset($res['img_height']) )
			{
				$img_width  = intval( $res['img_width'] );
				$img_height = intval( $res['img_height'] );
			}
		}

		$results[$i] = array(
			'title'      => $title,
			'link'       => $link,
			'image'      => $image,
			'uid'        => $uid,
			'uname'      => $uname,
			'time'       => $time,
			'time_l'     => $time_l,
			'time_s'     => $time_s,
			'context'    => $context,
			'full_link'  => $full_link,
			'img_url'    => $img_url,
			'img_width'  => $img_width,
			'img_height' => $img_height,
		);

	}

	return $results;
}

function _build_search_url( $action, &$param )
{
	$mid          =  $param['mid'];
	$uid          =  $param['uid'];
	$andor        =  $param['andor'];
	$showcontext  =  $param['showcontext'];
	$query_array  =& $param['query_array'];

	$search_url  = XOOPS_URL .'/modules/'. $this->_DIRNAME .'/index.php?';
	$search_url .= 'query='. $this->urlencode_implode_array( $query_array );
	$search_url .= '&mid='. $mid;
	$search_url .= '&action='. $action;
	$search_url .= '&andor='. $andor;
	$search_url .= '&showcontext='. $showcontext;

	if ($action == 'showallbyuser') 
	{
		$search_url .= '&uid='. $uid;
	}

	return $search_url;
}

//---------------------------------------------------------
// xoops module handler
//---------------------------------------------------------
function &get_module_name_list()
{
	$arr = array();
	if ( is_array($this->_mid_list_all) && count($this->_mid_list_all) )
	{
		foreach ($this->_mid_list_all as $mid) 
		{
			$obj =& $this->_xoops_module_handler->get_cache($mid);
			if ( is_object($obj) )
			{
				$arr[ $obj->getVar('mid') ] = $obj->getVar('name');
			}
		}
	}
	return $arr;
}

//---------------------------------------------------------
// get parameter
//---------------------------------------------------------
function &get_first_search_list()
{
	$ret =& $this->_mid_list_first_search;
	return $ret;
}

function &get_second_search_list()
{
	$ret =& $this->_mid_list_second_search;
	return $ret;
}

function &get_all_module_list()
{
	$ret =& $this->_mid_list_all;
	return $ret;
}

function get_module_name_show()
{
	 return $this->_module_name_show;
}

function get_navi()
{
	 return $this->_navi;
}

function &get_modules()
{
	 return $this->_get_module_objs_search();
}

function get_measure_detail()
{
	$text = '<table class="happy_search_measure_detail">'."\n";
	$time_total   = 0;
	$memory_total = 0;
	foreach ( $this->_measure_array as $k => $v )
	{
		$time   = $v['time'];
		$memory = $v['memory'];
		$time_total   += $time;
		$memory_total += $memory;
		$text  .= '<tr><td>'. $this->_strings->sanitize_text($k) .'</td>';
		$text  .= '<td>'. sprintf("%6.3f", $time) .'</td>';
		$text  .= '<td>'. sprintf("%6.3f", $memory / 1000000 ) ."</td></tr>\n";
	}
	$text .= '<tr><td> total </td>';
	$text .= '<td>'. sprintf("%6.3f", $time_total) .' sec </td>';
	$text .= '<td>'. sprintf("%6.3f", $memory_total / 1000000 ) ." MB </td></tr>\n";
	$text .= "</table>\n";
	return $text;
}

//---------------------------------------------------------
// set parameter
//---------------------------------------------------------
function set_flag_highlight($val)
{
	$this->_flag_highlight = (bool)$val;
}

function set_search_list( &$list )
{
	$this->_mid_list_search =& $list;
}

// --- class end ---
}

//=========================================================
// function
//=========================================================
function happy_search_sort_by_date($p1, $p2) 
{
// check exist time
	if ( isset($p2['time']) && isset($p1['time']) )
	{
	    return ($p2['time'] - $p1['time']);
	}
	return false;
}

// === class end ===
}

?>