<?php 
// $Id: main.php,v 1.3 2007/07/04 11:02:54 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

// 2007-02-18 K.OHWADA
// _HAPPY_SEARCH_THIS_SITE

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// ͭ����������
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MB_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MB_LOADED', 1);

define('_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_HAPPY_SEARCH_DESC', '����WEB���������Google�򸡺����ޤ�');
define('_HAPPY_SEARCH_XOOPS_SEARCH',  'Xoops ɸ�ม��');
define('_HAPPY_SEARCH_GOOGLE_SEARCH', 'Google ����');
define('_HAPPY_SEARCH_MSG_OTHER', '¾�θ����⥸�塼��ذ�ư���ޤ�'); 
define('_HAPPY_SEARCH_UNABLE_TO_SEARCH','�����Ǥ���ڡ���������ޤ���');
define('_HAPPY_SEARCH_KEY_SPACE','ʣ���Υ�����ɤǸ����������<strong>���ڡ���</strong>�Ƕ��ڤäƲ�������');
define('_HAPPY_SEARCH_SHOW_CONTEXT','��ʸ��ɽ������');

// 2007-02-18
define('_HAPPY_SEARCH_THIS_SITE',   '����WEB��������');
define('_HAPPY_SEARCH_RSS_SITE',    'RSS ����');
define('_HAPPY_SEARCH_GOOGLE_SITE', 'Google ����');
define('_HAPPY_SEARCH_KEY_ERROR','Google Key �����ꤵ��Ƥ��ʤ�');
define('_HAPPY_SEARCH_ANY_LANGUAGE','�ɤ�ʸ���Ǥ�');
define('_HAPPY_SEARCH_SYSTEM_COMMENT','������');

// === 2007-07-01 ===
// google ajax
define('_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Google Soap ����'); 
define('_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Google Ajax ����');
define('_HAPPY_SEARCH_USE_GOOGLE_SOAP', 'Google Soap ������Ԥ�'); 
define('_HAPPY_SEARCH_USE_GOOGLE_AJAX', 'Google Ajax ������Ԥ�');

}
// --- define language end ---

?>