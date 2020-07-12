<?php 
// $Id: happy_search.php,v 1.4 2008/02/16 16:29:21 ohwada Exp $ 

// 2008-02-16 K.OHWADA
// get_xoops_module_header()

// 2007-11-24 K.OHWADA
// change search_in_google_soap()

// 2007-07-01 K.OHWADA
// config_basic_handler

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search') ) 
{

//=========================================================
// class happy_search
//=========================================================
class happy_search extends happy_search_modules
{
	var $_FALG_MID_INIT        = true;
	var $_USE_GOOGLE_AJAX_INIT = true;
	var $_USE_GOOGLE_SOAP_INIT = true;

// class
	var $_google_handler;
	var $_class_html;
	var $_system;

	var $_conf;

// search search
	var $_search_results = null;

// set parameter
	var $_query_default        = null;
	var $_show_context_default = false;
	var $_use_google_ajax      = false;
	var $_use_google_soap      = false;

// sort by time
	var $MAX_SHOW_ALL    = 10;
	var $MIN_SHOW_MODULE = 1;
	var $_period      = -1; // unlimited

	var $_TEMPLATE_AJAX;
	var $_TEMPLATE_FORM;

	var $_post_use_module;
	var $_post_use_google_ajax;
	var $_post_use_google_soap;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search( $dirname )
{
	$this->happy_search_modules( $dirname );

	$config_handler        =& happy_linux_get_handler( 'config_basic', $dirname, 'happy_search' );
	$this->_google_handler =& happy_search_google::getInstance( $dirname );
	$this->_class_html     =& happy_linux_html::getInstance();
	$this->_system         =& happy_linux_system::getInstance();

	$this->_conf =& $config_handler->get_conf(); 

	$this->_TEMPLATE_AJAX = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/google_ajax.html';
	$this->_TEMPLATE_FORM = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/search_form.html';

}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// init
//---------------------------------------------------------
function init()
{
	$this->get_post_get_param();
	$this->set_min_keyword( $this->get_xoops_keyword_min() );
}

function get_post_get_param()
{
	$this->get_search_post_query();
	$this->get_search_post_action();
	$this->get_search_post_mids();
	$this->get_search_post_showcontext();
	$this->get_search_post_use_google_ajax();
	$this->get_search_post_use_google_soap();

	$this->get_post_get_andor();
	$this->get_post_get_uid();
	$this->get_post_get_mid();
	$this->get_post_get_start();
}

// first step
function get_search_post_query()
{
	$query = null;
	if ( $this->_post->is_post_set('query') )
	{
		$query = $this->_post->get_post_text('query');
	}
	elseif ( $this->_post->is_get_set('query') )
	{
		$query = $this->_post->get_get_text('query');
	}
	elseif ( $this->_query_default )
	{
		$query = $this->_query_default;
	}
	$this->_post_query = $query;
	return $query;
}

// second step
function get_search_post_action()
{
	$action = $this->_post->get_post_get_text('action');

	switch ( $action )
	{
		case 'search';
		case 'results':
		case 'showall':
		case 'showallbyuser':
		case 'google';
			$ret = $action;
			break;

		default:
			if ( $this->_post_query )
			{
				$ret = 'init';
			}
			else
			{
				$ret = 'search';
			}
			break;

	}

	$this->_post_action = $ret;
	return $ret;
}

// third step
function &get_search_post_mids()
{
	$val = false;
	switch ( $this->_post_action )
	{
		case 'search';
		case 'init':
			if ( $this->_FALG_MID_INIT )
			{
				$val =& $this->get_all_module_list();
			}
			break;

		default:
			$val = $this->get_post_get_mids();
			break;
	}

	$this->_post_mids =& $val;
	return $this->_post_mids;
}

function get_search_post_showcontext()
{
	switch ( $this->_post_action )
	{
		case 'search';
		case 'init':
			$val = $this->_show_context_default;
			break;

		default:
			$val = $this->get_post_get_showcontext(0);
			break;
	}

	$this->_post_showcontext = $val;
	return $this->_post_showcontext;
}

function get_search_post_use_google_ajax()
{
	switch ( $this->_post_action )
	{
		case 'search';
		case 'init':
			$val = $this->_USE_GOOGLE_AJAX_INIT;
			break;

		default:
			$val = $this->_post->get_post_get_int('use_google_ajax');
			break;
	}

	$this->_post_use_google_ajax = $val;
	return $this->_post_use_google_ajax;
}

function get_search_post_use_google_soap()
{
	switch ( $this->_post_action )
	{
		case 'search';
		case 'init':
			$val = $this->_USE_GOOGLE_SOAP_INIT;
			break;

		default:
			$val = $this->_post->get_post_get_int('use_google_soap');
			break;
	}

	$this->_post_use_google_soap = $val;
	return $this->_post_use_google_soap;
}

//---------------------------------------------------------
// check param
//---------------------------------------------------------
function check_input_param()
{
	if ( $this->_post_action == 'google' )
	{
		$this->set_flag_cabdicate(0);
	}

	$ret1 = $this->check_post_get_param_default();
	if ($ret1 == HAPPY_SEARCH_CODE_NORMAL)
	{
		$ret2 = $this->parse_query_default();
		if ( !$ret2 )
		{
			$ret1 = HAPPY_SEARCH_CODE_KEYTOOSHORT;
		}
	}
	return $ret1;
}

//---------------------------------------------------------
// search_in_modules
//---------------------------------------------------------
function search_in_first_modules( $limit )
{
	$this->set_search_list( $this->get_first_search_list()  );
	return $this->action_results_default( $limit );
}

function search_in_second_modules( $limit )
{
	$this->set_search_list( $this->get_second_search_list()  );
	return $this->action_results_default( $limit );
}

function &sort_results_by_time( $module_results )
{
	$serial = 0;	// all article
	$art_all_arr  = array();
	$art_time_arr = array();
	$art_time_flag_arr = array();
	$article_array = array();

	if ( !is_array($module_results) || (count($module_results) == 0) )
	{
		$false = false;
		return $false;
	}

	$time_since = 0;	// unlimited
	if ( $this->_period == 0 )
	{
		return $article_array;
	}
	elseif ( $this->_period > 0 )
	{
		$time_since = time() - $this->_period;
	}

	foreach( $module_results as $module )
	{
		$j = 0;
		if ( isset($module['results']) )
		{
			foreach ($module['results'] as $result)
			{
				$art_temp                = $result;
				$art_temp['mod_name']    = $module['name'];
				$art_temp['mod_dirname'] = $module['dirname'];
				$art_temp['serial_num']  = $serial;

				$art_all_arr[$serial]  = $art_temp;

				$time                  = $result['time'];
				$art_time_arr[$serial] = $time;

// mark time flag, if less than min show
				$flag_time = 0;
				if ( ($this->MIN_SHOW_MODULE > 0) && ($j < $this->MIN_SHOW_MODULE) && ($time > $time_since) )
				{
					$flag_time = 1;
				}
				$art_time_flag_arr[$serial] = $flag_time;

				$j ++;
				$serial ++;
			}
		}
	}

// sort by time
	arsort($art_time_arr, SORT_NUMERIC);

// mark time flag
	$i = 0;
	foreach ($art_time_arr as $num => $time)
	{
		if ( $time > $time_since )
		{
			$art_time_flag_arr[$num] = 1;
		}

		$i ++;
		if ($i >= $this->MAX_SHOW_ALL) break;
	}

	$i = 0;
// sort by time
	foreach ($art_time_arr as $num => $time)
	{
		if ( $art_time_flag_arr[$num] )
		{
			$article_array[$i++] = $art_all_arr[$num];
		}
	}

	return $article_array;
}

//---------------------------------------------------------
// google soap
//---------------------------------------------------------
function search_in_google_soap( $limit )
{
	$time_begin   = $this->_time->get_microtime();
	$memory_begin = happy_linux_memory_get_usage();

// input
	$search = $this->_google_handler->get_post_search();
	$page   = $this->_google_handler->get_post_page();
	$query  = $this->get_query_for_google();

	$ret = $this->_google_handler->search( $query, $search, $page, $limit );

	$this->_measure_array[ 'google soap' ] = array(
		'time'   => $this->_time->get_microtime()  - $time_begin,
		'memory' => happy_linux_memory_get_usage() - $memory_begin,
	);
	
	return $ret;
}

function build_template_google_soap()
{
	$this->_google_handler->set_query( $this->get_query() );
	$this->_google_handler->set_query_urlencode( $this->get_query_urlencode() );
	return $this->_google_handler->build_template( $this->get_show_context() );
}

function &get_google_soap_results()
{
	$ret =& $this->_google_handler->get_results();
	return $ret;
}

//---------------------------------------------------------
// build_google_ajax
//---------------------------------------------------------
function build_google_ajax()
{
	$tpl = new XoopsTpl();
	$tpl->assign('dirname',                $this->_DIRNAME );
	$tpl->assign('ga_api_key',             $this->_conf['ga_api_key'] );
	$tpl->assign('ga_use_site_search',     $this->_conf['ga_use_site_search'] );
	$tpl->assign('ga_use_web_search',      $this->_conf['ga_use_web_search'] );
	$tpl->assign('ga_use_blog_search',     $this->_conf['ga_use_blog_search'] );
	$tpl->assign('ga_use_news_search',     $this->_conf['ga_use_news_search'] );
	$tpl->assign('ga_use_book_search',     $this->_conf['ga_use_book_search'] );
	$tpl->assign('ga_use_video_search',    $this->_conf['ga_use_video_search'] );
	$tpl->assign('ga_use_local_search',    $this->_conf['ga_use_local_search'] );
	$tpl->assign('ga_draw_mode',           $this->_conf['ga_draw_mode'] );
	$tpl->assign('ga_local_center_point',  $this->_conf['ga_local_center_point']);
	$tpl->assign('ga_site_label',          $this->_conf['ga_site_label'] );
	$tpl->assign('ga_site_suffix',         $this->_conf['ga_site_suffix'] );
	$tpl->assign('ga_site_restriction',    $this->_conf['ga_site_restriction'] );
	$tpl->assign('ga_keyword',             $this->get_query('s') );
	$text = $tpl->fetch( $this->_TEMPLATE_AJAX );
	return $text;
}

//---------------------------------------------------------
// search_form
//---------------------------------------------------------
function get_search_form_default()
{
	$param = array(
		'action'              => $this->_post_action,
		'uid'                 => $this->_post_uid,
		'mid'                 => $this->_post_mid,
		'mids'                => $this->_post_mids,
		'start'               => $this->_post_start,
		'showcontext'         => $this->_post_showcontext,
		'min_keyword'         => $this->_min_keyword,
		'andor'               => $this->_mode_andor,
		'query_array'         => $this->_query_array,
		'candidate_array'     => $this->_candidate_array,
		'limit'               => 0,
	);

	$form = $this->_build_search_form( $param );
	return $form;
}

function _build_search_form( &$param )
{
	$mid                 =  $param['mid'];
	$mids                =  $param['mids'];
	$andor               =  $param['andor'];
	$showcontext         =  $param['showcontext'];
	$min_keyword         =  $param['min_keyword'];
	$mids                =& $param['mids'];
	$query_array         =& $param['query_array'];

	$search_name = $this->_system->get_module_name_by_dirname( HAPPY_SEARCH_SEARCH_DIRNAME );
	$xoogle_name = $this->_system->get_module_name_by_dirname( HAPPY_SEARCH_XOOGLE_DIRNAME );

	$query_s              = $this->implode_query_array( $query_array, ' ', 's' );
	$query_utf8_urlencode = $this->get_query_utf8_urlencode();
	$search_modules     = $this->_build_search_modules($param);
	$search_google_ajax = $this->_build_search_google_ajax();
	$search_google_soap = $this->_build_search_google_soap();

	$search_rule = '';
	if ( $min_keyword > 1 )
	{
		$search_rule .= sprintf(_SR_KEYIGNORE, $min_keyword, ceil($min_keyword/2));
		$search_rule .= "<br />\n";
	}
	$search_rule .= _HAPPY_SEARCH_KEY_SPACE;

	$selected_and   = $this->_class_html->build_html_selected($andor, 'AND');
	$selected_or    = $this->_class_html->build_html_selected($andor, 'OR');
	$selected_exact = $this->_class_html->build_html_selected($andor, 'exact');

	$checked_context_yes = $this->_class_html->build_html_checked($showcontext, 1);
	$checked_context_no  = $this->_class_html->build_html_checked($showcontext, 0);

	$tpl = new XoopsTpl();
	$tpl->assign('xoops_langcode', _LANGCODE );
	$tpl->assign('lang_yes',       _YES );
	$tpl->assign('lang_no',        _NO );
	$tpl->assign('lang_search',    _SR_SEARCH );
	$tpl->assign('lang_keywords',  _SR_KEYWORDS );
	$tpl->assign('lang_type',      _SR_TYPE );
	$tpl->assign('lang_all',       _SR_ALL );
	$tpl->assign('lang_any',       _SR_ANY );
	$tpl->assign('lang_exact',     _SR_EXACT );
	$tpl->assign('lang_search_in',    _SR_SEARCHIN );
	$tpl->assign('lang_search_rule',  _SR_SEARCHRULE );
	$tpl->assign('lang_show_context', _HAPPY_SEARCH_SHOW_CONTEXT );
	$tpl->assign('lang_xoops_name',   _HAPPY_SEARCH_XOOPS_SEARCH); 
	$tpl->assign('lang_google_name',  _HAPPY_SEARCH_GOOGLE_SEARCH);
	$tpl->assign('lang_google_ajax',  $this->_conf['label_google_ajax'] );
	$tpl->assign('lang_google_soap',  $this->_conf['label_google_soap'] );
	$tpl->assign('lang_search_name',  $search_name ); 
	$tpl->assign('lang_xoogle_name',  $xoogle_name );
	$tpl->assign('query_s',              $query_s );
	$tpl->assign('query_utf8_urlencode', $query_utf8_urlencode);
	$tpl->assign('search_google_ajax',   $search_google_ajax );
	$tpl->assign('search_google_soap',   $search_google_soap );
	$tpl->assign('search_modules', $search_modules );
	$tpl->assign('search_rule',    $search_rule );
	$tpl->assign('selected_and',   $selected_and );
	$tpl->assign('selected_or',    $selected_or );
	$tpl->assign('selected_exact', $selected_exact );
	$tpl->assign('checked_context_yes', $checked_context_yes );
	$tpl->assign('checked_context_no',  $checked_context_no );
	$text = $tpl->fetch( $this->_TEMPLATE_FORM );
	return $text;

}

function _build_search_modules( $param )
{
	$mid   =  $param['mid'];
	$mids  =  $param['mids'];

	$text  = '';
	$name  = "mids[]";

	$module_name_list =& $this->get_module_name_list(); 

	if ( is_array($mids) && count($mids) )  
	{
		$value_arr =& $mids;
	}
	else 
	{
		$value_arr = array( $mid );
	}

	if ( is_array($module_name_list) && count($module_name_list) )  
	{
		$text = $this->_class_html->build_html_input_checkbox_select_multi($name, $value_arr, array_flip($module_name_list) );
	}
	else
	{
		$text = _HAPPY_SEARCH_UNABLE_TO_SEARCH;
	}

	return $text;
}

function _build_search_google_ajax()
{
	$text = '';
	if( $this->_use_google_ajax )
	{
		$ajax_checked = $this->_class_html->build_html_checked($this->_post_use_google_ajax, 1);
		$text .= $this->_class_html->build_html_input_checkbox('use_google_ajax', 1, $ajax_checked );
		$text .= _HAPPY_SEARCH_USE_GOOGLE_AJAX;
		$text .= "<br />\n";
	}
	return $text;
}

function _build_search_google_soap()
{
	$text = '';
	if( $this->_use_google_soap )
	{
		$soap_checked = $this->_class_html->build_html_checked($this->_post_use_google_soap, 1);
		$text .= $this->_class_html->build_html_input_checkbox('use_google_soap', 1, $soap_checked );
		$text .= _HAPPY_SEARCH_USE_GOOGLE_SOAP;
		$text .= "<br />\n";
		$text .= $this->_google_handler->_makeSLRadio();
	}
	return $text;
}

//---------------------------------------------------------
// set parameter
//---------------------------------------------------------
function set_search_flag_highlight($val)
{
	$this->set_flag_highlight( $val );
	$this->_google_handler->set_flag_highlight( $val );
}

function set_max_show_all($val)
{
	$this->MAX_SHOW_ALL = intval($val);
}

function set_min_show_module($val)
{
	$this->MIN_SHOW_MODULE = intval($val);
}

function set_period($val)
{
	$this->_period = intval($val);
}

function set_query_default($val)
{
	$this->_query_default = $val;
}

function set_show_context_default($val)
{
	$this->_show_context_default = (bool)$val;
}

function set_use_google_ajax($val)
{
	$this->_use_google_ajax = (bool)$val;
}

function set_use_google_soap($val)
{
	$this->_use_google_soap = (bool)$val;
}

//---------------------------------------------------------
// get parameter
//---------------------------------------------------------
function get_show_context()
{
	return $this->_post_showcontext;
}

function get_post_use_google_ajax()
{
	return $this->_post_use_google_ajax;
}

function get_post_use_google_soap()
{
	return $this->_post_use_google_soap;
}

function get_use_google_ajax()
{
	if( $this->_use_google_ajax )
	{
		return $this->_post_use_google_ajax;
	}
	return false;
}

function get_use_google_soap()
{
	if( $this->_use_google_soap )
	{
		return $this->_post_use_google_soap;
	}
	return false;
}

//--------------------------------------------------------
// xoops_module_header
//--------------------------------------------------------
function get_xoops_module_header()
{
	$url_include = XOOPS_URL .'/modules/'. $this->_DIRNAME .'/include';
	$url_css = $url_include .'/happy_search.css';
	$url_js  = $url_include .'/happy_search.js';
	$text  = '<link href="'.  $url_css . '" rel="stylesheet" type="text/css" media="all" />'."\n";
	$text .= '<script src="'. $url_js . '" type="text/javascript" ></script>'."\n";
	$text .= $this->_system->get_template_vars('xoops_module_header')."\n";
	return $text;
}

// --- class end --
}

// === class end ===
}

?>