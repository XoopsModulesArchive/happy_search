<?php
// $Id: happy_search_config_define.php,v 1.2 2008/01/18 14:33:26 ohwada Exp $

// 2008-01-18 K.OHWADA
// Notice [PHP]: Only variables should be assigned by reference

//================================================================
// Happy Search
// 2007-07-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('happy_search_config_define') ) 
{

//=========================================================
// class happy_search_config_define
//=========================================================
class happy_search_config_define extends happy_linux_config_define_base
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_config_define()
{
	$this->happy_linux_config_define_base();
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search_config_define();
	}
	return $instance;
}

//---------------------------------------------------------
// function
// same as xoops_version.php
//---------------------------------------------------------
// Notice [PHP]: Only variables should be assigned by reference
function &get_define()
{

//---------------------------------------------------------
// module
//---------------------------------------------------------
	$config[1]['name']      = 'num_first';
	$config[1]['title']     = '_AM_HAPPY_SEARCH_MODULE_NUM';
	$config[1]['catid']     = 0;
	$config[1]['formtype']  = 'text';
	$config[1]['valuetype'] = 'int';
	$config[1]['default']   = 5;

	$config[2]['name']      = 'label_first';
	$config[2]['title']     = '_AM_HAPPY_SEARCH_LABEL';
	$config[2]['catid']     = 0;
	$config[2]['formtype']  = 'text';
	$config[2]['valuetype'] = 'text';
	$config[2]['default']   = _HAPPY_SEARCH_THIS_SITE;

	$config[3]['name']      = 'num_second';
	$config[3]['title']     = '_AM_HAPPY_SEARCH_MODULE_NUM';
	$config[3]['catid']     = 0;
	$config[3]['formtype']  = 'text';
	$config[3]['valuetype'] = 'int';
	$config[3]['default']   = 5;

	$config[4]['name']      = 'label_second';
	$config[4]['title']     = '_AM_HAPPY_SEARCH_LABEL';
	$config[4]['catid']     = 0;
	$config[4]['formtype']  = 'text';
	$config[4]['valuetype'] = 'text';
	$config[4]['default']   = _HAPPY_SEARCH_RSS_SITE;

//---------------------------------------------------------
// main
//---------------------------------------------------------
	$config[11]['name']      = 'keyword';
	$config[11]['title']     = '_AM_HAPPY_SEARCH_KEYWORD';
	$config[11]['catid']     = 1;
	$config[11]['formtype']  = 'text';
	$config[11]['valuetype'] = 'text';
	$config[11]['default']   = 'xoops';

	$config[12]['name']        = 'show_context';
	$config[12]['title']       = '_AM_HAPPY_SEARCH_SHOW_CONTEXT';
	$config[12]['catid']     = 1;
	$config[12]['formtype']    = 'yesno';
	$config[12]['valuetype']   = 'int';
	$config[12]['default']     = 1;

	$config[13]['name']        = 'use_google_ajax';
	$config[13]['title']       = '_HAPPY_SEARCH_USE_GOOGLE_AJAX';
	$config[13]['catid']       = 1;
	$config[13]['formtype']    = 'yesno';
	$config[13]['valuetype']   = 'int';
	$config[13]['default']     = 0;

	$config[14]['name']      = 'label_google_ajax';
	$config[14]['title']     = '_AM_HAPPY_SEARCH_LABEL_GOOGLE_AJAX';
	$config[14]['catid']     = 1;
	$config[14]['formtype']  = 'text';
	$config[14]['valuetype'] = 'text';
	$config[14]['default']   = _HAPPY_SEARCH_LABEL_GOOGLE_AJAX;

	$config[15]['name']        = 'use_google_soap';
	$config[15]['title']       = '_HAPPY_SEARCH_USE_GOOGLE_SOAP';
	$config[15]['description'] = '_AM_HAPPY_SEARCH_USE_GOOGLE_SOAP_DESC';
	$config[15]['catid']       = 1;
	$config[15]['formtype']    = 'yesno';
	$config[15]['valuetype']   = 'int';
	$config[15]['default']     = 0;

	$config[16]['name']      = 'label_google_soap';
	$config[16]['title']     = '_AM_HAPPY_SEARCH_LABEL_GOOGLE_SOAP';
	$config[16]['catid']     = 1;
	$config[16]['formtype']  = 'text';
	$config[16]['valuetype'] = 'text';
	$config[16]['default']   = _HAPPY_SEARCH_LABEL_GOOGLE_SOAP;

//---------------------------------------------------------
// google soap
//---------------------------------------------------------
	$config[21]['name']        = 'google_key';
	$config[21]['title']       = '_AM_HAPPY_SEARCH_KEY_LABEL';
	$config[21]['catid']       = 2;
	$config[21]['formtype']    = 'textarea';
	$config[21]['valuetype']   = 'text';
	$config[21]['default']     = '0000';

	$config[22]['name']        = 'google_lr';
	$config[22]['title']       = '_AM_HAPPY_SEARCH_LANG_LABEL';
	$config[22]['catid']       = 2;
	$config[22]['formtype']    = 'textarea';
	$config[22]['valuetype']   = 'text';
	$config[22]['default']     = 'show_form';

	$config[23]['name']        = 'sldefault';
	$config[23]['title']       = '_AM_HAPPY_SEARCH_LB_DEFAULT';
	$config[23]['catid']       = 2;
	$config[23]['formtype']    = 'text';
	$config[23]['valuetype']   = 'text';
	$config[23]['default']     = 'web';

	$config[24]['name']        = 'siteactive';
	$config[24]['title']       = '_AM_HAPPY_SEARCH_SEARCH_THIS_SITE';
	$config[24]['catid']       = 2;
	$config[24]['formtype']    = 'yesno';
	$config[24]['valuetype']   = 'int';
	$config[24]['default']     = 1;

	$config[25]['name']        = 'webactive';
	$config[25]['title']       = '_AM_HAPPY_SEARCH_SEARCH_THE_WEB';
	$config[25]['catid']       = 2;
	$config[25]['formtype']    = 'yesno';
	$config[25]['valuetype']   = 'int';
	$config[25]['default']     = 1;

	$config[26]['name']        = 'sitelabel';
	$config[26]['title']       = '_AM_HAPPY_SEARCH_LB_LOCATION_LABEL';
	$config[26]['catid']       = 2;
	$config[26]['formtype']    = 'text';
	$config[26]['valuetype']   = 'text';
	$config[26]['default']     = 'this site (google)';

	$config[27]['name']        = 'weblabel';
	$config[27]['title']       = '_AM_HAPPY_SEARCH_LB_LOCATION_LABEL';
	$config[27]['catid']       = 2;
	$config[27]['formtype']    = 'text';
	$config[27]['valuetype']   = 'text';
	$config[27]['default']     = 'the web (google)';

//---------------------------------------------------------
// xoogle: not use
//---------------------------------------------------------
	$config[31]['name']        = 'lrinblock';
	$config[31]['title']       = '';
	$config[31]['catid']       = 0;
	$config[31]['formtype']    = 'yesno';
	$config[31]['valuetype']   = 'int';
	$config[31]['default']     = 1;

	$config[32]['name']        = 'slinblock';
	$config[32]['title']       = '';
	$config[32]['catid']       = 0;
	$config[32]['formtype']    = 'yesno';
	$config[32]['valuetype']   = 'int';
	$config[32]['default']     = 1;

	$config[33]['name']        = 'xoopsactive';
	$config[33]['title']       = '';
	$config[33]['catid']       = 0;
	$config[33]['formtype']    = 'yesno';
	$config[33]['valuetype']   = 'int';
	$config[33]['default']     = 1;

	$config[34]['name']        = 'xoopslabel';
	$config[34]['title']       = '';
	$config[34]['catid']       = 0;
	$config[34]['formtype']    = 'text';
	$config[34]['valuetype']   = 'text';
	$config[34]['default']     = 'this site (xoops)';

//---------------------------------------------------------
// google ajax
//---------------------------------------------------------
	$config[41]['name']        = 'ga_api_key';
	$config[41]['title']       = '_AM_HAPPY_SEARCH_API_KEY';
	$config[41]['description'] = '_AM_HAPPY_SEARCH_API_KEY_DESC';
	$config[41]['catid']       = 4;
	$config[41]['formtype']    = 'textarea';
	$config[41]['valuetype']   = 'text';
	$config[41]['default']     = '';

	$config[42]['name']        = 'ga_use_site_search';
	$config[42]['title']       = '_AM_HAPPY_SEARCH_USE_SITE_SEARCH';
	$config[42]['description'] = '';
	$config[42]['catid']       = 4;
	$config[42]['formtype']    = 'yesno';
	$config[42]['valuetype']   = 'int';
	$config[42]['default']     = 1;

	$config[43]['name']        = 'ga_site_label';
	$config[43]['title']       = '_AM_HAPPY_SEARCH_SITE_LABEL';
	$config[43]['description'] = '_AM_HAPPY_SEARCH_SITE_LABEL_DESC';
	$config[43]['catid']       = 4;
	$config[43]['formtype']    = 'text';
	$config[43]['valuetype']   = 'text';
	$config[43]['default']     = _HAPPY_SEARCH_THIS_SITE;

	$config[44]['name']        = 'ga_site_suffix';
	$config[44]['title']       = '_AM_HAPPY_SEARCH_SITE_SUFFIX';
	$config[44]['description'] = '_AM_HAPPY_SEARCH_SITE_SUFFIX_DESC';
	$config[44]['catid']       = 4;
	$config[44]['formtype']    = 'text';
	$config[44]['valuetype']   = 'text';
	$config[44]['default']     = 'siteSearch';

	$config[45]['name']        = 'ga_site_restriction';
	$config[45]['title']       = '_AM_HAPPY_SEARCH_SITE_RESTRICTION';
	$config[45]['description'] = '_AM_HAPPY_SEARCH_SITE_RESTRICTION_DESC';
	$config[45]['catid']       = 4;
	$config[45]['formtype']    = 'text';
	$config[45]['valuetype']   = 'text';
	$config[45]['default']     = XOOPS_URL;

	$config[46]['name']      = 'ga_use_web_search';
	$config[46]['title']     = '_AM_HAPPY_SEARCH_USE_WEB_SEARCH';
	$config[46]['catid']     = 4;
	$config[46]['formtype']  = 'yesno';
	$config[46]['valuetype'] = 'int';
	$config[46]['default']   = 1;

	$config[47]['name']      = 'ga_use_blog_search';
	$config[47]['title']     = '_AM_HAPPY_SEARCH_USE_BLOG_SEARCH';
	$config[47]['catid']     = 4;
	$config[47]['formtype']  = 'yesno';
	$config[47]['valuetype'] = 'int';
	$config[47]['default']   = 1;

	$config[48]['name']      = 'ga_use_news_search';
	$config[48]['title']     = '_AM_HAPPY_SEARCH_USE_NEWS_SEARCH';
	$config[48]['catid']     = 4;
	$config[48]['formtype']  = 'yesno';
	$config[48]['valuetype'] = 'int';
	$config[48]['default']   = 1;

	$config[49]['name']      = 'ga_use_book_search';
	$config[49]['title']     = '_AM_HAPPY_SEARCH_USE_BOOK_SEARCH';
	$config[49]['catid']     = 4;
	$config[49]['formtype']  = 'yesno';
	$config[49]['valuetype'] = 'int';
	$config[49]['default']   = 1;

	$config[51]['name']      = 'ga_use_video_search';
	$config[51]['title']     = '_AM_HAPPY_SEARCH_USE_VIDEO_SEARCH';
	$config[51]['catid']     = 4;
	$config[51]['formtype']  = 'yesno';
	$config[51]['valuetype'] = 'int';
	$config[51]['default']   = 1;

	$config[52]['name']      = 'ga_use_local_search';
	$config[52]['title']     = '_AM_HAPPY_SEARCH_USE_LOCAL_SEARCH';
	$config[52]['catid']     = 4;
	$config[52]['formtype']  = 'yesno';
	$config[52]['valuetype'] = 'int';
	$config[52]['default']   = 1;

	$config[53]['name']        = 'ga_local_center_point';
	$config[53]['title']       = '_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT';
	$config[53]['description'] = '_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT_DESC';
	$config[53]['catid']       = 4;
	$config[53]['formtype']    = 'text';
	$config[53]['valuetype']   = 'text';
	$config[53]['default']     = 'New York, NY';

	$config[54]['name']        = 'ga_draw_mode';
	$config[54]['title']       = '_AM_HAPPY_SEARCH_DRAW_MODE';
	$config[54]['description'] = '_AM_HAPPY_SEARCH_DRAW_MODE_DESC';
	$config[54]['catid']       = 4;
	$config[54]['formtype']    = 'radio';
	$config[54]['valuetype']   = 'text';
	$config[54]['default']     = 'linear';
	$config[54]['options']     = array(
		_AM_HAPPY_SEARCH_DRAW_MODE_LINEAR => 'linear',
		_AM_HAPPY_SEARCH_DRAW_MODE_TABBED => 'tabbed',
	);

//---------------------------------------------------------
// block
//---------------------------------------------------------
	$config[61]['name']      = 'block_num_first';
	$config[61]['title']     = '_AM_HAPPY_SEARCH_MODULE_NUM';
	$config[61]['catid']     = 6;
	$config[61]['formtype']  = 'text';
	$config[61]['valuetype'] = 'int';
	$config[61]['default']   = 5;

	$config[62]['name']      = 'block_min_first';
	$config[62]['title']     = '_AM_HAPPY_SEARCH_MODULE_MIN';
	$config[62]['catid']     = 6;
	$config[62]['formtype']  = 'text';
	$config[62]['valuetype'] = 'int';
	$config[62]['default']   = 1;

	$config[63]['name']      = 'block_total_first';
	$config[63]['title']     = '_AM_HAPPY_SEARCH_TOTAL';
	$config[63]['catid']     = 6;
	$config[63]['formtype']  = 'text';
	$config[63]['valuetype'] = 'int';
	$config[63]['default']   = 10;

	$config[64]['name']      = 'block_num_second';
	$config[64]['title']     = '_AM_HAPPY_SEARCH_MODULE_NUM';
	$config[64]['catid']     = 6;
	$config[64]['formtype']  = 'text';
	$config[64]['valuetype'] = 'int';
	$config[64]['default']   = 5;

	$config[65]['name']      = 'block_min_second';
	$config[65]['title']     = '_AM_HAPPY_SEARCH_MODULE_MIN';
	$config[65]['catid']     = 6;
	$config[65]['formtype']  = 'text';
	$config[65]['valuetype'] = 'int';
	$config[65]['default']   = 1;

	$config[66]['name']      = 'block_total_second';
	$config[66]['title']     = '_AM_HAPPY_SEARCH_TOTAL';
	$config[66]['catid']     = 6;
	$config[66]['formtype']  = 'text';
	$config[66]['valuetype'] = 'int';
	$config[66]['default']   = 10;

	$config[71]['name']        = 'block_keyword';
	$config[71]['title']       = '_AM_HAPPY_SEARCH_KEYWORD';
	$config[71]['catid']       = 7;
	$config[71]['formtype']    = 'text';
	$config[71]['valuetype']   = 'text';
	$config[71]['default']     = 'xoops';

	$config[72]['name']        = 'block_show_context';
	$config[72]['title']       = '_AM_HAPPY_SEARCH_SHOW_CONTEXT';
	$config[72]['catid']       = 7;
	$config[72]['formtype']    = 'yesno';
	$config[72]['valuetype']   = 'int';
	$config[72]['default']     = 1;

	$config[73]['name']        = 'block_period';
	$config[73]['title']       = '_AM_HAPPY_SEARCH_PERIOD';
	$config[73]['description'] = '_AM_HAPPY_SEARCH_PERIOD_DESC';
	$config[73]['catid']       = 7;
	$config[73]['formtype']    = 'text';
	$config[73]['valuetype']   = 'int';
	$config[73]['default']     = 60;

	$config[74]['name']        = 'block_google_ajax';
	$config[74]['title']       = '_HAPPY_SEARCH_USE_GOOGLE_AJAX';
	$config[74]['catid']       = 7;
	$config[74]['formtype']    = 'yesno';
	$config[74]['valuetype']   = 'int';
	$config[74]['default']     = 0;

	$config[75]['name']        = 'block_google_soap';
	$config[75]['title']       = '_HAPPY_SEARCH_USE_GOOGLE_SOAP';
	$config[75]['catid']       = 7;
	$config[75]['formtype']    = 'yesno';
	$config[75]['valuetype']   = 'int';
	$config[75]['default']     = 0;

//---------------------------------------------------------
	return $config;
}

// --- class end ---
}

// === class end ===
}

?>