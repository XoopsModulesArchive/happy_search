<?php 
// $Id: modinfo.php,v 1.2 2007/07/04 11:02:54 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// renewal
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// 有朋自遠方来
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MI_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MI_LOADED', 1);

define('_MI_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_MI_HAPPY_SEARCH_DESC', 'サイト内とGoogleを検索するモジュール');

// Blocks
define('_MI_HAPPY_SEARCH_BLOCK_FORM', '検索'); 
define('_MI_HAPPY_SEARCH_BLOCK_FORM_DESC','検索フォームをブロックに表示します。');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT', '検索[転送用]');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT_DESC', 'このブロックをオンにしていると'.XOOPS_URL.'/search.phpへのリクエストが有った際に自動的にこのモジュールに転送できます。');
define('_MI_HAPPY_SEARCH_BLOCK_RESULT', '検索結果'); 
define('_MI_HAPPY_SEARCH_BLOCK_RESULT_DESC','検索結果をブロックに表示します。');

// Templates
define('_MI_HAPPY_SEARCH_TEMPLATE_INDEX','検索結果');
define('_MI_HAPPY_SEARCH_TEMPLATE_ALL','モジュール別検索結果');
define('_MI_HAPPY_SEARCH_TEMPLATE_FORM','検索フォーム');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_FORM','Google検索フォーム');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_PAGE','Google ページナビ');

// Admin menu
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK','グループ/ブロック管理');
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK_DESC','このモジュールのアクセス権とブロックの管理');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE','テンプレート管理');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE_DESC','このモジュールのテンプレートを管理');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE','除外モジュール管理');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE_DESC','検索の対象から除外するモジュールの管理');
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE', 'Google 設定管理'); 
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE_DESC', 'このモジュールの Google 設定を管理'); 

// Title of config items
define('_MI_HAPPY_SEARCH_CONFIG1','本文を表示する');
define('_MI_HAPPY_SEARCH_CONFIG_DESC1','検索結果に本文の該当する部分を表示します。');

// === 2007-07-01 ===
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG','モジュール設定');
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG_DESC','このモジュールの設定');

}
// --- define language end ---

?>