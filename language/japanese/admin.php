<?php 
// $Id: admin.php,v 1.2 2007/07/04 11:02:54 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// 有朋自遠方来
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_AM_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_AM_LOADED', 1);

// exclude module 
define('_AM_HAPPY_SEARCH_CHECK_MODULE_NOT_TO_SEARCH','検索の対象から除外するモジュールにチェックを入れる');
//define('_AM_HAPPY_SEARCH_DBUPDATED','データベースを更新しました。');

// google
define('_AM_HAPPY_SEARCH_GOOGLE_KEY_INFO', '<p>Google Web APIを使うためには、Google に登録して、Google License Key を取得する必要がある。あなたは下記の URL でこの取得をすることができる。取得した Google License Key では、１日あたりの検索要求の数に制限がある。</p> 
<p> デフォルトの割当て制限は、１日あたり1000個までの検索要求である。この割当て制限に問題があるならば、api-support@google.com に連絡してください。</p> 
<p>ここから Google License Key を取得する: <a href="http://code.google.com/apis/soapsearch/" target="_blank">Google SOAP Search API</a>.</p>'); 
define('_AM_HAPPY_SEARCH_KEY_LABEL', 'Google License Key を入力する'); 
define('_AM_HAPPY_SEARCH_AM_HAPPY_SEARCHOGLE_BUTTON', 'Google 設定の更新'); 
define('_AM_HAPPY_SEARCH_NO_RESTRICTIONS', '選択せず'); 
define('_AM_HAPPY_SEARCH_GOOGLE_LANG_INFO', '<p>特定の言語で文書を検索できるように、上のリストからその言語を選択する</p>'); 
define('_AM_HAPPY_SEARCH_LANG_LABEL', '言語を選択する'); 
define('_AM_HAPPY_SEARCH_SLOCATION_LABEL', '検索場所の設定'); 
define('_AM_HAPPY_SEARCH_SLOCATION_DESC', 'ユーザが検索場所を指定することを許可する場合に、オプションを設定する'); 
define('_AM_HAPPY_SEARCH_SEARCH_THIS_SITE', 'Google API を利用してこのサイトを検索する'); 
define('_AM_HAPPY_SEARCH_SEARCH_THE_WEB', 'Google API を利用してWEB全体を検索する'); 
define('_AM_HAPPY_SEARCH_LB_ACTIVE', '表示'); 
define('_AM_HAPPY_SEARCH_LB_DEFAULT', 'デフォルト'); 
define('_AM_HAPPY_SEARCH_LB_SEARCH_FUNCTION', '場所を検索する'); 
define('_AM_HAPPY_SEARCH_LB_LOCATION_LABEL', 'ラベル / 名前'); 

// === 2007-07-01 ===
// module
define('_AM_HAPPY_SEARCH_MID','ID');
define('_AM_HAPPY_SEARCH_MNAME','モジュール名');
define('_AM_HAPPY_SEARCH_DIRNAME','デイレクトリ名');
define('_AM_HAPPY_SEARCH_ITEM','項目');
define('_AM_HAPPY_SEARCH_PLUGIN', 'プラグイン');
define('_AM_HAPPY_SEARCH_MOD_VERSION', 'バージョン');
define('_AM_HAPPY_SEARCH_NOTICE','注意');
define('_AM_HAPPY_SEARCH_NOTICE_PLURAL','１つのモジュールに複数のプラグインが存在します。<br />適切なプラグインを選択してください。');

// main
define('_AM_HAPPY_SEARCH_CONF_MAIN', 'メインページの設定'); 
define('_AM_HAPPY_SEARCH_KEYWORD',   'キーワードの初期値');
define('_AM_HAPPY_SEARCH_SHOW_CONTEXT', '本文表示の初期値');
define('_AM_HAPPY_SEARCH_MODULE_NUM',   'モジュール毎に検索する記事の数');
define('_AM_HAPPY_SEARCH_LABEL', 'タイトル');
define('_AM_HAPPY_SEARCH_FIRST', '１番目の検索');
define('_AM_HAPPY_SEARCH_FIRST_DESC', '除外するモジュール');
define('_AM_HAPPY_SEARCH_SECOND','２番目の検索');
define('_AM_HAPPY_SEARCH_SECOND_DESC','対象とするモジュール');
define('_AM_HAPPY_SEARCH_CHECK_MODULE_TO_SEARCH','検索の対象とするモジュールにチェックを入れる');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Google Soap 検索のタイトル');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Google Ajax 検索のタイトル');

// block
define('_AM_HAPPY_SEARCH_CONF_BLOCK', 'ブロックの設定'); 
define('_AM_HAPPY_SEARCH_PERIOD', '検索対象の期間 (日数)');
define('_AM_HAPPY_SEARCH_PERIOD_DESC', '<b>-1</b> は制限なし');
define('_AM_HAPPY_SEARCH_MODULE_MIN', 'モジュール毎に表示する最小の記事数');
define('_AM_HAPPY_SEARCH_TOTAL','全体で表示する最大の記事数');

// google soap
define('_AM_HAPPY_SEARCH_CONF_SOAP', 'Google Soap API 設定'); 
define('_AM_HAPPY_SEARCH_USE_GOOGLE_SOAP_DESC', 'このサービスは終了しています<br />新規に API Key を取得することは出来ません');

// google ajax
define('_AM_HAPPY_SEARCH_CONF_AJAX', 'Google Ajax API 設定'); 
define('_AM_HAPPY_SEARCH_API_KEY','Google API Key');
define('_AM_HAPPY_SEARCH_API_KEY_DESC', 'Google Ajax 検索を利用する場合は <br /> <a href="http://code.google.com/apis/ajaxsearch/signup.html" target="_blank">Sign up for the Google AJAX Search API</a> <br /> にて <br /> API key を取得してください<br /><br />パラメータの詳細は下記をご覧ください<br /><a href="http://code.google.com/apis/ajaxsearch/documentation/reference.html" target="_blank">Google AJAX Search API Class Reference</a>');
define('_AM_HAPPY_SEARCH_USE_SITE_SEARCH',  '特定のサイトを検索する');
define('_AM_HAPPY_SEARCH_USE_WEB_SEARCH',   'WEBを検索する');
define('_AM_HAPPY_SEARCH_USE_BLOG_SEARCH',  'ブログを検索する');
define('_AM_HAPPY_SEARCH_USE_NEWS_SEARCH',  'ニュースを検索する');
define('_AM_HAPPY_SEARCH_USE_BOOK_SEARCH',  '書籍を検索する');
define('_AM_HAPPY_SEARCH_USE_VIDEO_SEARCH', 'ビデオを検索する');
define('_AM_HAPPY_SEARCH_USE_LOCAL_SEARCH', '地域を検索する');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT','[地域検索] 中心地');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT_DESC','GlocalSearch - setCenterPoint');
define('_AM_HAPPY_SEARCH_SITE_LABEL', '[サイト検索] タイトル');
define('_AM_HAPPY_SEARCH_SITE_LABEL_DESC', 'GSearchControl - setUserDefinedLabel');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX','[サイト検索] 接尾語');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX_DESC','GSearchControl - setUserDefinedClassSuffix');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION','[サイト検索] URL');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION_DESC','GwebSearch - setSiteRestriction');
define('_AM_HAPPY_SEARCH_DRAW_MODE','表示形式');
define('_AM_HAPPY_SEARCH_DRAW_MODE_DESC','GdrawOptions - setDrawMode');
define('_AM_HAPPY_SEARCH_DRAW_MODE_LINEAR','縦形式');
define('_AM_HAPPY_SEARCH_DRAW_MODE_TABBED','タブ形式');

// template
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE','テンプレートのキャッシュ・クリア');
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE_DESC','template/parts/ ディレクトリにあるテンプレートを変更したときには、実行すること');

}
// --- define language end ---

?>