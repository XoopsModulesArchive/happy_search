<?php 
// $Id: modinfo.php,v 1.2 2007/07/04 11:02:53 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// renewal
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MI_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MI_LOADED', 1);

define('_MI_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_MI_HAPPY_SEARCH_DESC', 'This module search in this web site and in Google');

// Blocks
define('_MI_HAPPY_SEARCH_BLOCK_FORM', 'Search'); 
define('_MI_HAPPY_SEARCH_BLOCK_FORM_DESC','Show search form in block');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT', 'Search [Transfer]');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT_DESC', 'It is possible to transfer to this module automatically, when there is a request to '. XOOPS_URL .'/ search.php, when making this block on.');
define('_MI_HAPPY_SEARCH_BLOCK_RESULT', 'Search Result'); 
define('_MI_HAPPY_SEARCH_BLOCK_RESULT_DESC','Show search result in block');

// Templates
define('_MI_HAPPY_SEARCH_TEMPLATE_INDEX','Search Result');
define('_MI_HAPPY_SEARCH_TEMPLATE_ALL','Search Result in each module');
define('_MI_HAPPY_SEARCH_TEMPLATE_FORM','Search Form');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_FORM','Google Serach Form');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_PAGE','Google Page Navination');

// Admin menu
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK','Gruop / Block Manage');
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK_DESC','The management of the access permition of the module and the block');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE','Template Manage');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE_DESC','The management of the template');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE','Exclude Module Manage');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE_DESC','The management of the module which is excluded to searcht');
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE', 'Google Config Manage'); 
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE_DESC', 'The management of the Google Configration'); 

// Title of config items
define('_MI_HAPPY_SEARCH_CONFIG1','Show context');
define('_MI_HAPPY_SEARCH_CONFIG_DESC1','show the corresponding part in context of the search result');

// === 2007-07-01 ===
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG','Module Config');
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG_DESC','The setting of this module');

}
// --- define language end ---

?>