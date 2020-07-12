<?php 
// $Id: index.php,v 1.7 2008/07/09 07:58:39 ohwada Exp $ 

// 2008-07-01 K.OHWADA
// add $show_img

// 2008-02-16 K.OHWADA
// xoops_module_header

// 2007-12-22 K.OHWADA
// BUG : not show module name

// 2007-11-24 K.OHWADA
// happy_linux_get_memory_usage_mb()
// move class/nusoap.php from index.php

// 2007-07-01 K.OHWADA
// google ajax

// 2007-02-18 K.OHWADA
// small change

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// TODO
// set contstant in admin
//---------------------------------------------------------

include 'header.php'; 

//---------------------------------------------------------
// contstant
//---------------------------------------------------------
$NUM_GOOGLE_SOAP = 10;
$show_img        = true;

//---------------------------------------------------------
// include nusoap class
//---------------------------------------------------------
$config_handler =& happy_search_get_handler( 'config_basic', HAPPY_SEARCH_DIRNAME );
$conf = $config_handler->get_conf();

$num_first       = $conf['num_first'];
$num_second      = $conf['num_second'];
$use_google_soap = false;

if ( $conf['use_google_soap'] && $NUM_GOOGLE_SOAP )
{
	if( class_exists( 'nusoap_base' ) ) 
	{
		if ( $xoopsUserIsAdmin )
		{
			include XOOPS_ROOT_PATH.'/header.php';
			xoops_error( 'conflict nusoap class' );
			include XOOPS_ROOT_PATH.'/footer.php';
			exit();
		}
	}
	else
	{
		include_once HAPPY_SEARCH_ROOT_PATH.'/class/nusoap.php';
		$use_google_soap = true;
	}
}

//---------------------------------------------------------
// main
//---------------------------------------------------------

// some plugin need global $myts
$myts =& MyTextSanitizer::getInstance();

$search_handler =& happy_search::getInstance( HAPPY_SEARCH_DIRNAME );
$search_handler->set_search_flag_highlight( true );
$search_handler->set_query_default(        $conf['keyword'] );
$search_handler->set_show_context_default( $conf['show_context'] );
$search_handler->set_use_google_ajax(      $conf['use_google_ajax'] );
$search_handler->set_use_google_soap(      $use_google_soap );
$search_handler->set_search_flag_highlight( true );
$search_handler->init();

$query_s         = $search_handler->get_query('s');
$action          = $search_handler->get_action();
$start           = $search_handler->get_start();
$show_context    = $search_handler->get_show_context();
$use_google_ajax = $search_handler->get_use_google_ajax();
$use_google_soap = $search_handler->get_use_google_soap();

// other search module
if ( isset($_GET['xoops']) && $_GET['xoops'] )
{
	$url = XOOPS_URL.'/search.php?query='. $query_s .'&amp;action=results';
	redirect_header($url, 1, _HAPPY_SEARCH_MSG_OTHER );
	exit();
}

if ( isset($_GET['suin']) && $_GET['suin'] )
{
	$url = XOOPS_URL.'/modules/'.HAPPY_SEARCH_SEARCH_DIRNAME.'/index.php?query='. $query_s .'&amp;action=results';
	redirect_header($url, 1, _HAPPY_SEARCH_MSG_OTHER );
	exit();
}

if ( isset($_GET['xoogle']) && $_GET['xoogle'] )
{
	$url = XOOPS_URL.'/modules/'.HAPPY_SEARCH_XOOGLE_DIRNAME.'/index.php?query='. $query_s;
	redirect_header($url, 1, _HAPPY_SEARCH_MSG_OTHER );
	exit();
}

// disable global search
if ( !$search_handler->check_xoops_enable_search() )
{
	header('Location: '.XOOPS_URL.'/index.php');
	exit();
}

// module name
$module_name = $xoopsModule->getVar('name');

$ret = $search_handler->check_input_param();
switch ($ret)
{
	case HAPPY_SEARCH_CODE_ENTER:
		redirect_header('index.php', 1, _SR_PLZENTER);
		exit();

	case HAPPY_SEARCH_CODE_NOPERM:
		redirect_header('index.php', 1, _NOPERM);
		exit();

	case HAPPY_SEARCH_CODE_KEYTOOSHORT:
		redirect_header('index.php', 2, $search_handler->get_lang_keytooshort() );
		exit();

	case HAPPY_SEARCH_CODE_SEARCH:
	case HAPPY_SEARCH_CODE_NORMAL:
	default:
		break;
}

$show_first  = 0;
$show_second = 0;
$show_result = 0;
$show_form   = 0;
$show_google_soap = 0;
$show_google_ajax = 0;
$google_soap      = null;

switch ($action) 
{
	case 'google':
		if( $use_google_soap && $NUM_GOOGLE_SOAP ) $show_google_soap = 1;
		break;	

	case 'init':
	case 'results':
		if( $num_first )  $show_first = 1;
		if( $num_second ) $show_second = 1;
		if( $use_google_soap && $NUM_GOOGLE_SOAP ) $show_google_soap = 1;
		if( $use_google_ajax ) $show_google_ajax = 1;
		$show_form   = 1;
		break;

	case 'search':
	case 'showall':
	default:
		$show_form = 1;
		break;
}

switch ($action) 
{
	case 'init':
	case 'results':
	case 'google':

// --- print page ---
		$xoopsOption['template_main'] = HAPPY_SEARCH_DIRNAME . '_index.html';
		include XOOPS_ROOT_PATH.'/header.php';

// search in modules
		if ($show_first)
		{
			$search_handler->search_in_first_modules( $num_first );
			$first_results = $search_handler->get_search_results();

			for ($i=0; $i<count($first_results); $i++)
			{
				$xoopsTpl->append('first_modules', $first_results[$i] );
			}
		}

// search in rssc module 
		if ($show_second)
		{
			$search_handler->search_in_second_modules( $num_second );
			$second_results = $search_handler->get_search_results();

			for ($i=0; $i<count($second_results); $i++)
			{
				$xoopsTpl->append('second_modules', $second_results[$i] );
			}
		}

// search in google 
		if ($show_google_soap)
		{
			$search_handler->search_in_google_soap( $NUM_GOOGLE_SOAP );
			$google_soap = $search_handler->build_template_google_soap();
		}

		break;

	case 'showall':
	case 'showallbyuser':

// --- print page ---
		$xoopsOption['template_main'] = HAPPY_SEARCH_DIRNAME . '_result_all.html';
		include XOOPS_ROOT_PATH.'/header.php';

		$search_handler->action_showall_default();

		$results =& $search_handler->get_showall_results();

		if ( is_array($results) && count($results) ) 
		{
			$show_result = 1;
			$count = count($results);

			$xoopsTpl->assign('showing', sprintf(_SR_SHOWING, $start+1, $start + $count));
			$xoopsTpl->assign('module_name', $search_handler->get_module_name_show() );
			$xoopsTpl->assign('navi',        $search_handler->get_navi() );

			for ($i=0; $i<$count; $i++)
			{
				$xoopsTpl->append('results', $results[$i]);
			}
		}

		break;

	case 'search':
	default:

// --- print page ---
		$xoopsOption['template_main'] = 'happy_search_index.html';
		include XOOPS_ROOT_PATH.'/header.php';

		break;
}

$xoopsTpl->assign('lang_search',         _SR_SEARCH);
$xoopsTpl->assign('lang_search_results', _SR_SEARCHRESULTS);
$xoopsTpl->assign('lang_keyword',        _SR_KEYWORDS);
$xoopsTpl->assign('lang_no_match',       _SR_NOMATCH);
$xoopsTpl->assign('lang_candidate',      _HAPPY_LINUX_SEARCH_CANDICATE );
$xoopsTpl->assign('lang_goto_admin',     _HAPPY_LINUX_GOTO_ADMIN);
$xoopsTpl->assign('lang_desc',           _HAPPY_SEARCH_DESC );
$xoopsTpl->assign('lang_xoops_name',     _HAPPY_SEARCH_XOOPS_SEARCH); 
$xoopsTpl->assign('lang_google_name',    _HAPPY_SEARCH_GOOGLE_SEARCH);
$xoopsTpl->assign('dirname',              HAPPY_SEARCH_DIRNAME);

$xoopsTpl->assign('lang_label_first',        $conf['label_first'] );
$xoopsTpl->assign('lang_label_second',       $conf['label_second'] );
$xoopsTpl->assign('lang_label_google_ajax',  $conf['label_google_ajax'] );
$xoopsTpl->assign('lang_label_google_soap',  $conf['label_google_soap'] );

// BUG : not show module name
$xoopsTpl->assign('module_name',         $module_name );

$xoopsTpl->assign('xoops_module_header', $search_handler->get_xoops_module_header() );
$xoopsTpl->assign('show_first',          $show_first );
$xoopsTpl->assign('show_second',         $show_second );
$xoopsTpl->assign('show_result',         $show_result );
$xoopsTpl->assign('show_context',        $show_context );
$xoopsTpl->assign('show_img',            $show_img );
$xoopsTpl->assign('is_module_admin',     $xoopsUserIsAdmin );

$xoopsTpl->assign('query',                $search_handler->get_query_for_form() );
$xoopsTpl->assign('lang_ignore',          $search_handler->get_lang_ignoredwors() );
$xoopsTpl->assign('keywords',             $search_handler->get_query_array() );
$xoopsTpl->assign('ignores',              $search_handler->get_ignore_array() );
$xoopsTpl->assign('candidates',           $search_handler->get_candidate_array() );
$xoopsTpl->assign('show_ignore',          $search_handler->get_count_ignore_array() );
$xoopsTpl->assign('show_candidate',       $search_handler->get_count_candidate_array() );
$xoopsTpl->assign('merged_urlencode',     $search_handler->get_merged_urlencode() );
$xoopsTpl->assign('query_utf8_urlencode', $search_handler->get_query_utf8_urlencode() );
$xoopsTpl->assign('google_ajax',          $search_handler->build_google_ajax() );

$xoopsTpl->assign('show_google_ajax', $show_google_ajax );
$xoopsTpl->assign('show_google_soap', $show_google_soap );
$xoopsTpl->assign('google_soap',      $google_soap );

$search_form = '';
if ($show_form)
{
	$search_form = $search_handler->get_search_form_default();
}
$xoopsTpl->assign('search_form', $search_form);

$xoopsTpl->assign('happy_linux_url', get_happy_linux_url() );
$xoopsTpl->assign('execution_time',  happy_linux_get_execution_time() );
$xoopsTpl->assign('memory_usage',    happy_linux_get_memory_usage_mb() );
$xoopsTpl->assign('measure_detail',  $search_handler->get_measure_detail() );
include XOOPS_ROOT_PATH.'/footer.php';
exit();
// --- print page end ---


function build_google_ajax( $dirname, $query )
{
	$config_handler =& happy_linux_get_handler( 'config_basic', $dirname, 'happy_search' );
	$conf = $config_handler->get_conf();

	$TEMPLATE = XOOPS_ROOT_PATH .'/modules/'. $dirname .'/templates/parts/google_ajax.html';

	$tpl = new XoopsTpl();
	$tpl->assign('ga_api_key',             $conf['ga_api_key'] );
	$tpl->assign('ga_use_site_search',     $conf['ga_use_site_search'] );
	$tpl->assign('ga_use_web_search',      $conf['ga_use_web_search'] );
	$tpl->assign('ga_use_blog_search',     $conf['ga_use_blog_search'] );
	$tpl->assign('ga_use_news_search',     $conf['ga_use_news_search'] );
	$tpl->assign('ga_use_book_search',     $conf['ga_use_book_search'] );
	$tpl->assign('ga_use_video_search',    $conf['ga_use_video_search'] );
	$tpl->assign('ga_use_local_search',    $conf['ga_use_local_search'] );
	$tpl->assign('ga_draw_mode',           $conf['ga_draw_mode'] );
	$tpl->assign('ga_local_center_point',  $conf['ga_local_center_point']);
	$tpl->assign('ga_site_label',          $conf['ga_site_label'] );
	$tpl->assign('ga_site_suffix',         $conf['ga_site_suffix'] );
	$tpl->assign('ga_site_restriction',    $conf['ga_site_restriction'] );
	$tpl->assign('ga_keyword',             $query );
	$text = $tpl->fetch( $TEMPLATE );
	return $text;
}

?>