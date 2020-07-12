<?php 
// $Id: block_search.php,v 1.8 2007/11/26 03:38:58 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// move class/nusoap.php from api/block.php

// 2007-07-01 K.OHWADA
// config_basic_handler
// module depulication

// 2007-06-01 K.OHWADA
// BUG: Undefined variable: XOOPS_LANGUAGE 

// 2007-02-20 K.OHWADA
// google search

// 2007-02-18 K.OHWADA
// happy_search_xoops_module_handler.php

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// TODO
// set contstant in admin
//---------------------------------------------------------

// --- block function begin ---
if( !function_exists( 'b_happy_search_form' ) ) 
{

//---------------------------------------------------------
// b_happy_search_form
//---------------------------------------------------------
function b_happy_search_form()
{
	global $xoopsConfig;
	$XOOPS_LANGUAGE = $xoopsConfig['language'];

// search.php
	if ( file_exists(XOOPS_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/search.php') ) 
	{
		include_once XOOPS_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/search.php';
	}
	else
	{
		include_once XOOPS_ROOT_PATH.'/language/english/search.php';
	}

	$block = array(
		'lang_search'         => _SR_SEARCH,
		'lang_search_results' => _SR_SEARCHRESULTS,
		'lang_keyword'        => _SR_KEYWORDS,
	);

	return $block;
}

//---------------------------------------------------------
// b_happy_search_redirect
//---------------------------------------------------------
function b_happy_search_redirect( $options )
{
	$DIRNAME = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0];

	$request_url = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if( preg_match("|".XOOPS_URL."/search.php|", $request_url ) )
	{
		$redirect_url = XOOPS_URL .'/modules/'. $DIRNAME .'/index.php?'. $_SERVER['QUERY_STRING'];
		header( 'Location: '. $redirect_url );
		exit();
	}
	return false;
}

//---------------------------------------------------------
// b_happy_search_result
//---------------------------------------------------------
function b_happy_search_result( $options )
{
	$DIRNAME = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0];

	include_once XOOPS_ROOT_PATH. '/modules/'. $DIRNAME .'/api/block.php';

//---------------------------------------------------------
// contstant
//---------------------------------------------------------
	$NUM_GOOGLE_SOAP = 10;

//---------------------------------------------------------
// include nusoap class
//---------------------------------------------------------
	global $xoopsUserIsAdmin;
	$is_admin = $xoopsUserIsAdmin;

	$config_handler =& happy_search_get_handler( 'config_basic', $DIRNAME );
	$conf = $config_handler->get_conf();

	$block_google_soap = false;
	$nusoap_error      = '';

	if ( $conf['block_google_soap'] && $NUM_GOOGLE_SOAP )
	{
		if( class_exists( 'nusoap_base' ) ) 
		{
			$nusoap_error = 'conflict nusoap class';
		}
		else
		{
			include_once XOOPS_ROOT_PATH. '/modules/'. $DIRNAME .'/class/nusoap.php';
			$block_google_soap = true;
		}
	}

//---------------------------------------------------------
// main
//---------------------------------------------------------
	$search_handler =& happy_search::getInstance( $DIRNAME );

	$search_handler->set_query_default(        $conf['block_keyword'] );
	$search_handler->set_show_context_default( $conf['block_show_context'] );
	$search_handler->set_period(               $conf['block_period'] * 86400 );
	$search_handler->init();
	$search_handler->check_input_param();

// search in first modules
	$search_handler->search_in_first_modules( $conf['block_num_first'] );

	$results = $search_handler->get_search_results();
	$search_handler->set_max_show_all(    $conf['block_total_first'] );
	$search_handler->set_min_show_module( $conf['block_min_first'] );
	$first_results = $search_handler->sort_results_by_time( $results );

	$show_first = 0;
	if ( is_array($first_results) && count($first_results) )
	{
		$show_first = 1;
	}

// search in second modules
	$search_handler->search_in_second_modules( $conf['block_num_second'] );

	$results = $search_handler->get_search_results();
	$search_handler->set_max_show_all(    $conf['block_total_second'] );
	$search_handler->set_min_show_module( $conf['block_min_second'] );
	$second_results = $search_handler->sort_results_by_time( $results );

	$show_second = 0;
	if ( is_array($second_results) && count($second_results) )
	{
		$show_second = 1;
	}

// search in google soap
	$show_google_soap    = 0;
	$google_soap_results = '';

	if ( $block_google_soap )
	{
		$search_handler->search_in_google_soap( $NUM_GOOGLE_SOAP );
		$google_soap_results =& $search_handler->get_google_soap_results();

		if ( is_array($google_soap_results) && count($google_soap_results) )
		{
			$show_google_soap = 1;
		}
	}

	$block = array(
		'lang_search'         => _SR_SEARCH,
		'lang_search_results' => _SR_SEARCHRESULTS,
		'lang_keyword'        => _SR_KEYWORDS,
		'lang_label_first'       => $conf['label_first'],
		'lang_label_second'      => $conf['label_second'],
		'lang_label_google_ajax' => $conf['label_google_ajax'],
		'lang_label_google_soap' => $conf['label_google_soap'],
		'show_context'           => $conf['block_show_context'],
		'show_google_ajax'       => $conf['block_google_ajax'],
		'keywords'            => $search_handler->get_query_array(),
		'query'               => $search_handler->get_query(),
		'google_ajax'         => $search_handler->build_google_ajax(),
		'show_first'          => $show_first,
		'first_results'       => $first_results,
		'show_second'         => $show_second,
		'second_results'      => $second_results,
		'show_google_soap'    => $show_google_soap,
		'google_soap_results' => $google_soap_results,
		'is_admin'            => $is_admin,
		'nusoap_error'        => $nusoap_error,
	);

	return $block;
}

// --- block function end ---
}

?>