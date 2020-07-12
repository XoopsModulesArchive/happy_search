<?php 
// $Id: admin.php,v 1.2 2007/07/04 11:02:53 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_AM_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_AM_LOADED', 1);

// exclude module 
define('_AM_HAPPY_SEARCH_CHECK_MODULE_NOT_TO_SEARCH','Check in the checkbox of the module whitch is excluded to search');
//define('_AM_HAPPY_SEARCH_DBUPDATED','Updated Databese');

// google
define('_AM_HAPPY_SEARCH_GOOGLE_KEY_INFO', '<p>In order to use Google Web APIs you first must register with Google to receive an authentication key. You can do this online at the url below. Your key will have a limit on the number of requests a day that you can make.</p> 
<p> The default limit is 1000 queries per day. If you have problems with your key or getting the correct the daily quota of queries, please contact api-support@google.com.</p> 
<p>Get your Google License Key here: <a href="http://code.google.com/apis/soapsearch/" target="_blank">Google SOAP Search API</a>.</p>'); 
define('_AM_HAPPY_SEARCH_KEY_LABEL', 'Enter your Google License Key'); 
define('_AM_HAPPY_SEARCH_AM_HAPPY_SEARCHOGLE_BUTTON', 'Update Google Settings'); 
define('_AM_HAPPY_SEARCH_NO_RESTRICTIONS', 'No Restrictions'); 
define('_AM_HAPPY_SEARCH_GOOGLE_LANG_INFO', '<p>To search for documents within a particular language, select that language from the list above.</p>'); 
define('_AM_HAPPY_SEARCH_LANG_LABEL', 'Select a Langugage Restriction'); 
define('_AM_HAPPY_SEARCH_SLOCATION_LABEL', 'Search Location Settings'); 
define('_AM_HAPPY_SEARCH_SLOCATION_DESC', 'Configure these options to set which locations you will allow your users to search.'); 
define('_AM_HAPPY_SEARCH_SEARCH_THIS_SITE', 'Search this site using the google api'); 
define('_AM_HAPPY_SEARCH_SEARCH_THE_WEB', 'Search the web using the google api'); 
define('_AM_HAPPY_SEARCH_LB_ACTIVE', 'Visible'); 
define('_AM_HAPPY_SEARCH_LB_DEFAULT', 'Default'); 
define('_AM_HAPPY_SEARCH_LB_SEARCH_FUNCTION', 'Search Location'); 
define('_AM_HAPPY_SEARCH_LB_LOCATION_LABEL', 'Label / Name'); 

// === 2007-07-01 ===
// module
define('_AM_HAPPY_SEARCH_MID','ID');
define('_AM_HAPPY_SEARCH_MNAME','Module Nname');
define('_AM_HAPPY_SEARCH_DIRNAME','Directory Name');
define('_AM_HAPPY_SEARCH_ITEM','Item');
define('_AM_HAPPY_SEARCH_PLUGIN', 'Plugin');
define('_AM_HAPPY_SEARCH_MOD_VERSION', 'Version');
define('_AM_HAPPY_SEARCH_NOTICE','Notice');
define('_AM_HAPPY_SEARCH_NOTICE_PLURAL','There are plural plugins in one module<br />Please select appropriate plugin');

// main
define('_AM_HAPPY_SEARCH_CONF_MAIN', 'Main Page Setting'); 
define('_AM_HAPPY_SEARCH_KEYWORD',   'Default value of Keyword');
define('_AM_HAPPY_SEARCH_SHOW_CONTEXT', 'Default value of Show Context');
define('_AM_HAPPY_SEARCH_MODULE_NUM',   'Number of the articles to search in each module');
define('_AM_HAPPY_SEARCH_LABEL', 'Label');
define('_AM_HAPPY_SEARCH_FIRST', 'First Search');
define('_AM_HAPPY_SEARCH_FIRST_DESC', 'Exclude Modules');
define('_AM_HAPPY_SEARCH_SECOND','Second Search');
define('_AM_HAPPY_SEARCH_SECOND_DESC','Include Modules');
define('_AM_HAPPY_SEARCH_CHECK_MODULE_TO_SEARCH','Check in the checkbox of the module whitch is included to search');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Label of Google Soap Search');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Label of Google Ajax Search');

// block
define('_AM_HAPPY_SEARCH_CONF_BLOCK', 'Block Setting'); 
define('_AM_HAPPY_SEARCH_PERIOD', 'Period of Search (Days)');
define('_AM_HAPPY_SEARCH_PERIOD_DESC', '<b>-1</b> is unlimited');
define('_AM_HAPPY_SEARCH_MODULE_MIN', 'Minium number of articles to show in each module');
define('_AM_HAPPY_SEARCH_TOTAL','Total number of the articles to show');

// google soap
define('_AM_HAPPY_SEARCH_CONF_SOAP', 'Google Soap API Setting'); 
define('_AM_HAPPY_SEARCH_USE_GOOGLE_SOAP_DESC', 'This service was over.<br />You cannot get new API Key');

// google ajax
define('_AM_HAPPY_SEARCH_CONF_AJAX', 'Google Ajax API Setting'); 
define('_AM_HAPPY_SEARCH_API_KEY','Google API Key');
define('_AM_HAPPY_SEARCH_API_KEY_DESC', 'Get the API key on <br/> <a href="http://code.google.com/apis/ajaxsearch/signup.html" target="_blank">Sign up for the Google AJAX Search API</a> <br />when you use Google Ajax Search <br /><br />For the details of the parameter, see the following <br /><a href="http://code.google.com/apis/ajaxsearch/documentation/reference.html" target="_blank">Google AJAX Search API Class Reference</a>');
define('_AM_HAPPY_SEARCH_USE_SITE_SEARCH',  'Use Restric Site Search');
define('_AM_HAPPY_SEARCH_USE_WEB_SEARCH',   'Use Web Search');
define('_AM_HAPPY_SEARCH_USE_BLOG_SEARCH',  'Use Blog Search');
define('_AM_HAPPY_SEARCH_USE_NEWS_SEARCH',  'Use News Search');
define('_AM_HAPPY_SEARCH_USE_BOOK_SEARCH',  'Use Book Search');
define('_AM_HAPPY_SEARCH_USE_VIDEO_SEARCH', 'Use Video Search');
define('_AM_HAPPY_SEARCH_USE_LOCAL_SEARCH', 'Use Local Search');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT','[Local Search] Center Point');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT_DESC','GlocalSearch - setCenterPoint');
define('_AM_HAPPY_SEARCH_SITE_LABEL', '[Restric Site Search] Label');
define('_AM_HAPPY_SEARCH_SITE_LABEL_DESC', 'GSearchControl - setUserDefinedLabel');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX','[Restric Site Search] Class Suffix');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX_DESC','GSearchControl - setUserDefinedClassSuffix');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION','[Restric Site Search] Restrict URL');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION_DESC','GwebSearch - setSiteRestriction');
define('_AM_HAPPY_SEARCH_DRAW_MODE','Draw Mode');
define('_AM_HAPPY_SEARCH_DRAW_MODE_DESC','GdrawOptions - setDrawMode');
define('_AM_HAPPY_SEARCH_DRAW_MODE_LINEAR','Linear');
define('_AM_HAPPY_SEARCH_DRAW_MODE_TABBED','Tabbed');

// template
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE','Clear cache of Templates');
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE_DESC','MUST execute, when changing template files in template/parts/ directory');

}
// --- define language end ---

?>