<?php
// $Id: happy_search_google.php,v 1.5 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// soapclient -> ns_soapclient

// 2007-07-01 K.OHWADA
// config_basic_handler

// 2007-02-20 K.OHWADA
// small change _google_search()

// 2007-02-18 K.OHWADA
// move googleLangRestrictions() from google_manage.php

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_google') ) 
{

//=========================================================
// class happy_search_google
// using google soap api
// porting from xoogle include/xoogle.php
//=========================================================
class happy_search_google
{
	var $_DIRNAME;
	var $_MAX_RESULTS = 10;	// defined by google

// class instance
	var $_soap_client;
	var $_post;
	var $_convert;
	var $_strings;
	var $_highlight;

// set parameter
	var $_flag_highlight  = false;
	var $_query           = null;
	var $_query_urlencode = null;

// search result
	var $_results       = null;
	var $_error         = null;
	var $_soap_error    = null;
	var $_soap_call     = null;
	var $_soap_response = null;
	var $_page          = null;
	var $_paginate      = null;

// local
	var $_config = array();

	var $_TEMPLATE_MAIN;
	var $_TEMPLATE_PAGINATE;
	var $_TEMPLATE_FORM;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_google( $dirname )
{
	$this->_DIRNAME = $dirname;

	$config_handler =& happy_linux_get_handler('config_basic', $dirname, 'happy_search' );

	$this->_post           =& happy_linux_post::getInstance();
	$this->_convert        =& happy_linux_convert_encoding::getInstance();
	$this->_strings        =& happy_linux_strings::getInstance();
	$this->_highlight      =& happy_linux_highlight::getInstance();

	$this->_config = $config_handler->get_conf();

	$this->_highlight->set_replace_callback( 'happy_linux_highlighter_by_class' );
	$this->_highlight->set_class( 'happy_search_highlight' );

	$this->_TEMPLATE_MAIN     = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/google_soap.html';
	$this->_TEMPLATE_PAGINATE = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/google_soap_paginate.html';
	$this->_TEMPLATE_FORM     = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/google_soap_form.html';
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search_google( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// GET parameter
//---------------------------------------------------------
function get_post_query()
{
	$query = $this->_post->get_get_urlencode('google_query');
	return $query;
}

function get_post_page()
{
	$page = $this->_post->get_get_int('page', 1);
	return $page;
}

function get_post_lr()
{
	$lr = $this->_post->get_get_text('lr', $this->_config['google_lr'] );
	return $lr;
}

function get_post_search()
{
	$search = $this->_post->get_get_text('search', $this->_config['sldefault'] );
	return $search;
}

//---------------------------------------------------------
// config
//---------------------------------------------------------
function get_config()
{
	return $this->_config;
}

//---------------------------------------------------------
// search
//---------------------------------------------------------
function search( $query, $search, $page, $limit )
{
	if ( empty($query) || ($limit == 0) )
	{
		return true;	// no action
	}

	if ( !$this->_check_google_key() )
	{
		return false;
	}

	$this->_connect();

	$results =& $this->_google_search( $query, $search, $page, $limit );
	$results =& $this->_format_results( $results, $query );
	$this->_results =& $results;

	return true;
}

function &get_results()
{
	return $this->_results;
}

function get_error()
{
	return $this->_error;
}

function &get_soap_error()
{
	return $this->_soap_error;
}

function get_lr_select()
{
	$lr_select = null;

// check to see if we need a language restriction select box.
	if ( $this->_config['google_lr'] == 'show_form' )
	{
		$lr_select = $this->_makeLangSelect();	
	}

	return $lr_select;
}

function get_sl_select()
{
	$sl_select = $this->_makeSLRadio();
	return $sl_select;
}

function &get_post_vars()
{
	$post =& $_GET;

// if a search has been submitted fetch results
	if ( isset($_GET['google_query']) && ($_GET['google_query'] != '') )
	{
		$post['query'] = $this->get_post_query();

		if ( !isset($_GET['search']) || !$_GET['search'] )
		{
			$post['search'] = $this->_config['sldefault'];
		}
	}

	return $post;
}

//---------------------------------------------------------
// admin
//---------------------------------------------------------
function googleLangRestrictions()
{
	$lr[1]['label']  = 'Arabic'; $lr[1]['code'] = 'lang_ar';
	$lr[2]['label']  = 'Chinese (S)'; $lr[2]['code'] = 'lang_zh-CN';
	$lr[3]['label']  = 'Chinese (T)'; $lr[3]['code'] = 'lang_zh-TW';
	$lr[4]['label']  = 'Czech'; $lr[4]['code'] = 'lang_cs';
	$lr[5]['label']  = 'Danish'; $lr[5]['code'] = 'lang_da';
	$lr[6]['label']  = 'Dutch'; $lr[6]['code'] = 'lang_nl';
	$lr[7]['label']  = 'English'; $lr[7]['code'] = 'lang_en';
	$lr[8]['label']  = 'Estonian'; $lr[8]['code'] = 'lang_et';
	$lr[9]['label']  = 'Finnish'; $lr[9]['code'] = 'lang_fi';
	$lr[10]['label'] = 'French'; $lr[10]['code'] = 'lang_fr';
	$lr[11]['label'] = 'German'; $lr[11]['code'] = 'lang_de';
	$lr[12]['label'] = 'Greek'; $lr[12]['code'] = 'lang_el';
	$lr[13]['label'] = 'Hebrew'; $lr[13]['code'] = 'lang_iw';
	$lr[14]['label'] = 'Hungarian'; $lr[14]['code'] = 'lang_hu';
	$lr[15]['label'] = 'Icelandic'; $lr[15]['code'] = 'lang_is';
	$lr[16]['label'] = 'Italian'; $lr[16]['code'] = 'lang_it';
	$lr[17]['label'] = 'Japanese'; $lr[17]['code'] = 'lang_ja';
	$lr[18]['label'] = 'Korean'; $lr[18]['code'] = 'lang_ko';
	$lr[19]['label'] = 'Latvian'; $lr[19]['code'] = 'lang_lv';
	$lr[20]['label'] = 'Lithuanian'; $lr[20]['code'] = 'lang_lt';
	$lr[21]['label'] = 'Norwegian'; $lr[21]['code'] = 'lang_no';
	$lr[22]['label'] = 'Portuguese'; $lr[22]['code'] = 'lang_pt';
	$lr[23]['label'] = 'Polish'; $lr[23]['code'] = 'lang_pl';
	$lr[24]['label'] = 'Romanian'; $lr[24]['code'] = 'lang_ro';
	$lr[25]['label'] = 'Russian'; $lr[25]['code'] = 'lang_ru';
	$lr[26]['label'] = 'Spanish'; $lr[26]['code'] = 'lang_es';
	$lr[27]['label'] = 'Swedish'; $lr[27]['code'] = 'lang_sv';
	$lr[28]['label'] = 'Turkish'; $lr[28]['code'] = 'lang_tr';

	return $lr;
}

//---------------------------------------------------------
// private
//---------------------------------------------------------
function _connect()
{
	$this->_soap_client = new ns_soapclient( 'http://api.google.com/search/beta2' );

	if( XOOPS_USE_MULTIBYTES )
	{
		$this->_soap_client->soap_defencoding = 'UTF-8';
	}
}

function _check_google_key()
{
	$ret = true;

	if ( strstr( $this->_config['google_key'], '000000') || ! $this->_config['google_key'] )
	{
		$this->_error = _HAPPY_SEARCH_KEY_ERROR;
		$ret = false;
	}
	return $ret;
}

// this page contains functions used by xoogle
function &_google_search( $query, $search, $page, $max=10 )
{
// query
	$query = str_replace(' ', '+', $query);

	$query = $this->_convert->convert_to_utf8( trim($query) );

	if ( $search == 'site' )
	{
		$url = str_replace('http://', '', XOOPS_URL);
		$query .= ' site:'.$url;
	}

// max
	if ( $max > $this->_MAX_RESULTS )
	{
		$max = $this->_MAX_RESULTS;
	}

// start
	if ( $page > 1 )
	{
		$start = $page * $max;
	}
	else
	{
		$start = 0;
	}

// lr
	$lr = '';
	if ( $this->_config['google_lr'] == 'show_form' )
	{
		if ( isset($_GET['lr']) )
		{
			$lr = $_GET['lr'];
		}
	}
	elseif ( $this->_config['google_lr'] != 'no_lr' )
	{
 		$lr = $this->_config['google_lr'];
	}

	$options = array( 
             'key'        => $this->_config['google_key'],  // the Developer's key
             'q'          => $query,  // the search query
             'start'      => $start,  // the point in the search results should Google start
             'maxResults' => $max,    // the number of search results (max 10)
             'filter'     => true,    // should the results be filtered?
             'restrict'   => '',
             'safeSearch' => false,
             'lr'         => $lr,
             'ie'         => '',
             'oe'         => ''
	 );

	$results =& $this->_get_google_results( $options );
	$results =& $this->_convert->convert_array_from_utf8( $results );

	return $results;
}

function &_get_google_results( &$options )
{
	$NAME_SAPCE = 'urn:GoogleSearch';

	$total = 0;
	$this->_soap_error = null;

	$page  = $this->get_post_page();

// Call the taxCalc() function, passing the parameter list
	$results = $this->_soap_client->call('doGoogleSearch', $options, $NAME_SAPCE);
	if ( $results )
	{
		if ( isset($results['estimatedTotalResultsCount']) )
		{
			$total = $results['estimatedTotalResultsCount'];
		}
	}
	elseif ( $this->_soap_client->error_str )
	{
		$this->_soap_error = 'soap error : '.$this->_soap_client->error_str;
	}

	if ( $total == 0)
	{
		$this->_error = _SR_NOMATCH;
	}

	$this->_xoogle_paginate($total, $this->_MAX_RESULTS, $page, $total);

	$this->_soap_call     = htmlentities($this->_soap_client->request);
	$this->_soap_response = htmlentities($this->_soap_client->response);
	$this->_page          = $page;

	return $results;
}

function &_format_results( &$results, $query )
{
	$null = null;

	if ( !isset($results['resultElements']) )
	{
		return $null;
	}

	$elements = $results['resultElements'];

	if ( !is_array($elements) || (count($elements) == 0) )
	{
		return $null;
	}

	$query_array = explode(' ', $query);
	$arr = array();

	foreach ($elements as $element)
	{
		$title       = $this->_sanitize_html( $element['title'] );
		$url         = $this->_strings->sanitize_url(  $element['URL'] );
		$cached_size = $this->_strings->sanitize_text( $element['cachedSize'] );

		$snippet = $this->_sanitize_html( $element['snippet'] );
		if ( $this->_flag_highlight )
		{
			$snippet = $this->_highlight->build_highlight_keyword_array($snippet, $query_array);
		}

		$summary          = '';
		$directory_title  = '';
		$host_name        = '';
		$viewable_name    = '';
		$special_encoding = '';
		$related          = false;

		if ( isset($element['summary']) && $element['summary'] )
		{
			$summary = $this->_sanitize_html( $element['summary'] );
		}

		if ( isset($element['directoryTitle']) && $element['directoryTitle'] )
		{
			$directory_title = $this->_strings->sanitize_text( $element['directoryTitle'] );
		}

		if ( isset($element['hostName']) && $element['hostName'] )
		{
			$host_name = $this->_strings->sanitize_text( $element['hostName'] );
		}

		if ( isset($element['relatedInformationPresent']) )
		{
			$related = $element['relatedInformationPresent'];
		}

		if ( isset($element['directoryCategory']) )
		{
			$directory = $element['directoryCategory'];
		
			if ( isset($directory['fullViewableName']) && $directory['fullViewableName'] )
			{
				$viewable_name = $this->_strings->sanitize_url( $directory['fullViewableName'] );
			}
			if ( isset($directory['specialEncoding']) && $directory['specialEncoding'] )
			{
				$special_encoding = $this->_strings->sanitize_text( $directory['specialEncoding'] );
			}
		}

		$arr[] = array(
			'url'              => $url,
			'title'            => $title,
			'snippet'          => $snippet,
			'cached_size'      => $cached_size,
			'summary'          => $summary,
			'directory_title'  => $directory_title,
			'host_name'        => $host_name,
			'viewable_name'    => $viewable_name,
			'special_encoding' => $special_encoding,
			'related'          => $related,
		);
	}

	return $arr;
}

function _sanitize_html($str)
{
	$str = preg_replace("/>/", '> ', $str);
 	$str = strip_tags( $str );
	$str = $this->_strings->sanitize_text( $str );
	return $str;
}

// provides pagination by determining first record
function _xoogle_paginate($items, $limit, $page, $total_items)
{
	$paginate = array();

	if ( ! $page )
	{	$page = 1;	}

	$paginate['total_matched'] = $total_items;

	if ( $total_items > $items )
	{	$paginate['filter_on'] = true;	}

	$paginate['count'] = ceil($items / $limit);
	if ( $page > 1 )
	{
	    $paginate['start'] = $limit * ($page-1);
	}
	else 
	{
		$paginate['start'] = 0;
	}

	$paginate['first_rec'] = $paginate['start']+1;
	$paginate['last_rec']  = $paginate['start']+$limit;

	if ( $paginate['last_rec'] > $items )
	{	 $paginate['last_rec'] = $items;	}

	$paginate['limit'] = $limit;
	$paginate['page']  = $page; 
	
	if ( ($paginate['page'] <= $paginate['count']) && ($paginate['count'] > 1) )
	{
		$paginate['prev'] = $paginate['page'] - 1;
	}
	else 
	{
		$paginate['prev'] = 0;
	}

	if ( ($paginate['page'] >= 1) && ($paginate['count'] > 1) && ($paginate['page'] < $paginate['count']) )
	{
		$paginate['next'] = $paginate['page']+1;
	}
	else 
	{
		$paginate['next'] = 0;
	}

	$this->_paginate = $paginate;
	return $paginate;
}

function &get_paginate()
{
	return $this->_paginate;
}

function _makeLangSelect()
{
	$lr_list = $this->googleLangRestrictions();
	$lr      = $this->get_post_lr();

	$lr_select  = '<select name="lr">'."\n";
	$lr_select .= '<option value="">'. _HAPPY_SEARCH_ANY_LANGUAGE. '</option>'."\n";

	foreach ( $lr_list as $v )
	{
		$lr_select .= '<option value="'. htmlspecialchars($v['code'], ENT_QUOTES) .'"';

		if ( $lr == $v['code'] )
		{
			 $lr_select .= ' selected';
		} 

		$lr_select .= '>'. htmlspecialchars($v['label'], ENT_QUOTES) .'</option>'."\n";
	}

	$lr_select .= '</select>'."\n";

	return $lr_select;
}

function _makeSLSelect()
{
	$sldefault = $this->get_post_search();

	$sl_select = '<select name="search">'."\n";

	if ( $this->_config['webactive'] )
	{
		$sl_select .= '<option value="web"';

		if ( $sldefault == 'web')
		{	$sl_select .= ' selected';	}

		$sl_select .= '>'. htmlspecialchars($this->_config['weblabel'], ENT_QUOTES). '</option>'."\n";
	}

	if ( $this->_config['siteactive'] )
	{
		$sl_select .= '<option value="site"';

		if ( $sldefault == 'site')
		{	$sl_select .= ' selected';	}

		$sl_select .= '>'. htmlspecialchars($this->_config['sitelabel'], ENT_QUOTES). '</option>'."\n";
	}

//	if ( $this->_config['xoopsactive'] )
//	{
//		$sl_select .= '<option value="xoops"';
//		if ( $sldefault == 'xoops')
//		{	$sl_select .= ' selected';	}
//		$sl_select .= '>'. htmlspecialchars($this->_config['xoopslabel'], ENT_QUOTES) .'</option>'."\n";
//	}

	$sl_select .= '</select>'."\n";

	return $sl_select;
}

function _makeSLRadio()
{

	$sldefault = $this->get_post_search();

	$sl_select = '';

	if ( $this->_config['webactive'] )
	{
		$sl_select .= '<input type="radio" name="search" value="web"';

		if ( $sldefault == 'web')
		{	$sl_select .= ' checked';	}

		$sl_select .= '>'. htmlspecialchars($this->_config['weblabel'], ENT_QUOTES) ." &nbsp; \n";
	}

	if ( $this->_config['siteactive'] )
	{
		$sl_select .= '<input type="radio" name="search" value="site"';

		if ( $sldefault == 'site')
		{	$sl_select .= ' checked';	}

		$sl_select .= '>'. htmlspecialchars($this->_config['sitelabel'], ENT_QUOTES) ." &nbsp; \n";
	}

//	if ( $this->_config['xoopsactive'] )
//	{
//		$sl_select .= '<input type="radio" name="search" value="xoops"';
//		if ( $sldefault == 'xoops')
//		{	$sl_select .= ' checked';	}
//		$sl_select .= '>'. htmlspecialchars($this->_config['xoopslabel'], ENT_QUOTES) ." &nbsp; \n";
//	}

	return $sl_select;
}

//---------------------------------------------------------
// template
//---------------------------------------------------------
function build_template( $show_context )
{
	$tpl = new XoopsTpl();
	$tpl->assign('xoops_url',             XOOPS_URL );
	$tpl->assign('dirname',               $this->_DIRNAME );
	$tpl->assign('google_results',        $this->get_results() );
	$tpl->assign('google_error',          $this->get_error() );
	$tpl->assign('google_soap_error',     $this->get_soap_error() );
	$tpl->assign('show_context',          $show_context );
	$tpl->assign('google_soap_paginate',  $this->_build_google_soap_paginate() );
	$text = $tpl->fetch( $this->_TEMPLATE_MAIN );
	return $text;
}

function _build_google_soap_paginate()
{
	$tpl = new XoopsTpl();
	$tpl->assign('xoops_url',         XOOPS_URL );
	$tpl->assign('dirname',           $this->_DIRNAME );
	$tpl->assign('google_post',       $this->_get_google_post() );
	$tpl->assign('google_paginate',   $this->get_paginate() );
	$text = $tpl->fetch( $this->_TEMPLATE_PAGINATE );
	return $text;
}

function &_get_google_post()
{
	$post =& $_GET;
	$post['query_urlencode'] = $this->_query_urlencode;

	if ( !$this->_post->is_get_fill('search') )
	{
		$post['search'] = $this->_config['sldefault'];
	}

	return $post;
}

//---------------------------------------------------------
// set parameter
//---------------------------------------------------------
function set_flag_highlight($val)
{
	$this->_flag_highlight = (bool)$val;
}

function set_query($val)
{
	$this->_query = $val;
}

function set_query_urlencode($val)
{
	$this->_query_urlencode = $val;
}

// --- class end ---
}

// === class end ===
}

?>