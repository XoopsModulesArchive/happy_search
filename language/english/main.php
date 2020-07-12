<?php 
// $Id: main.php,v 1.3 2007/07/04 11:02:53 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

// 2007-02-18 K.OHWADA
// _HAPPY_SEARCH_THIS_SITE

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MB_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MB_LOADED', 1);

define('_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_HAPPY_SEARCH_DESC', 'Serach in this web site and in Google');
define('_HAPPY_SEARCH_XOOPS_SEARCH',  'Xoops Standard Search');
define('_HAPPY_SEARCH_GOOGLE_SEARCH', 'Google Search');
define('_HAPPY_SEARCH_MSG_OTHER', 'Move to the other search module'); 
define('_HAPPY_SEARCH_UNABLE_TO_SEARCH','There is no a page which can be searched');
define('_HAPPY_SEARCH_KEY_SPACE','Divide in <strong>space</strong>, when search by two or more keywords');
define('_HAPPY_SEARCH_SHOW_CONTEXT','Show context');

// 2007-02-18
define('_HAPPY_SEARCH_THIS_SITE',   'In This WEB Site');
define('_HAPPY_SEARCH_RSS_SITE',    'Rss Search');
define('_HAPPY_SEARCH_GOOGLE_SITE', 'Google Search');
define('_HAPPY_SEARCH_KEY_ERROR','Not set Google Key');
define('_HAPPY_SEARCH_ANY_LANGUAGE','Any Language');
define('_HAPPY_SEARCH_SYSTEM_COMMENT','Comment');

// === 2007-07-01 ===
// google ajax
define('_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Google Soap Search'); 
define('_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Google Ajax Search');
define('_HAPPY_SEARCH_USE_GOOGLE_SOAP', 'Use Google Soap Search'); 
define('_HAPPY_SEARCH_USE_GOOGLE_AJAX', 'Use Google Ajax Search');

}
// --- define language end ---

?>