<?php 
// $Id: main.php,v 1.1 2007/07/14 14:36:34 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

// 2007-02-18 K.OHWADA
// _HAPPY_SEARCH_THIS_SITE

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// UTF-8
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MB_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MB_LOADED', 1);

define('_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_HAPPY_SEARCH_DESC', 'このWEBサイト内とGoogleを検索します');
define('_HAPPY_SEARCH_XOOPS_SEARCH',  'Xoops 標準検索');
define('_HAPPY_SEARCH_GOOGLE_SEARCH', 'Google 検索');
define('_HAPPY_SEARCH_MSG_OTHER', '他の検索モジュールへ移動します'); 
define('_HAPPY_SEARCH_UNABLE_TO_SEARCH','検索できるページがありません。');
define('_HAPPY_SEARCH_KEY_SPACE','複数のキーワードで検索する場合は<strong>スペース</strong>で区切って下さい。');
define('_HAPPY_SEARCH_SHOW_CONTEXT','本文を表示する');

// 2007-02-18
define('_HAPPY_SEARCH_THIS_SITE',   'このWEBサイト内');
define('_HAPPY_SEARCH_RSS_SITE',    'RSS 検索');
define('_HAPPY_SEARCH_GOOGLE_SITE', 'Google 検索');
define('_HAPPY_SEARCH_KEY_ERROR','Google Key が設定されていない');
define('_HAPPY_SEARCH_ANY_LANGUAGE','どんな言語でも');
define('_HAPPY_SEARCH_SYSTEM_COMMENT','コメント');

// === 2007-07-01 ===
// google ajax
define('_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Google Soap 検索'); 
define('_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Google Ajax 検索');
define('_HAPPY_SEARCH_USE_GOOGLE_SOAP', 'Google Soap 検索を行う'); 
define('_HAPPY_SEARCH_USE_GOOGLE_AJAX', 'Google Ajax 検索を行う');

}
// --- define language end ---

?>