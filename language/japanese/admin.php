<?php 
// $Id: admin.php,v 1.2 2007/07/04 11:02:54 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// google ajax
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// ͭ����������
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_AM_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_AM_LOADED', 1);

// exclude module 
define('_AM_HAPPY_SEARCH_CHECK_MODULE_NOT_TO_SEARCH','�������оݤ����������⥸�塼��˥����å��������');
//define('_AM_HAPPY_SEARCH_DBUPDATED','�ǡ����١����򹹿����ޤ�����');

// google
define('_AM_HAPPY_SEARCH_GOOGLE_KEY_INFO', '<p>Google Web API��Ȥ�����ˤϡ�Google ����Ͽ���ơ�Google License Key ���������ɬ�פ����롣���ʤ��ϲ����� URL �Ǥ��μ����򤹤뤳�Ȥ��Ǥ��롣�������� Google License Key �Ǥϡ�����������θ����׵�ο������¤����롣</p> 
<p> �ǥե���Ȥγ��������¤ϡ�����������1000�ĤޤǤθ����׵�Ǥ��롣���γ��������¤����꤬����ʤ�С�api-support@google.com ��Ϣ���Ƥ���������</p> 
<p>�������� Google License Key ���������: <a href="http://code.google.com/apis/soapsearch/" target="_blank">Google SOAP Search API</a>.</p>'); 
define('_AM_HAPPY_SEARCH_KEY_LABEL', 'Google License Key �����Ϥ���'); 
define('_AM_HAPPY_SEARCH_AM_HAPPY_SEARCHOGLE_BUTTON', 'Google ����ι���'); 
define('_AM_HAPPY_SEARCH_NO_RESTRICTIONS', '���򤻤�'); 
define('_AM_HAPPY_SEARCH_GOOGLE_LANG_INFO', '<p>����θ����ʸ��򸡺��Ǥ���褦�ˡ���Υꥹ�Ȥ��餽�θ�������򤹤�</p>'); 
define('_AM_HAPPY_SEARCH_LANG_LABEL', '��������򤹤�'); 
define('_AM_HAPPY_SEARCH_SLOCATION_LABEL', '������������'); 
define('_AM_HAPPY_SEARCH_SLOCATION_DESC', '�桼��������������ꤹ�뤳�Ȥ���Ĥ�����ˡ����ץ��������ꤹ��'); 
define('_AM_HAPPY_SEARCH_SEARCH_THIS_SITE', 'Google API �����Ѥ��Ƥ��Υ����Ȥ򸡺�����'); 
define('_AM_HAPPY_SEARCH_SEARCH_THE_WEB', 'Google API �����Ѥ���WEB���Τ򸡺�����'); 
define('_AM_HAPPY_SEARCH_LB_ACTIVE', 'ɽ��'); 
define('_AM_HAPPY_SEARCH_LB_DEFAULT', '�ǥե����'); 
define('_AM_HAPPY_SEARCH_LB_SEARCH_FUNCTION', '���򸡺�����'); 
define('_AM_HAPPY_SEARCH_LB_LOCATION_LABEL', '��٥� / ̾��'); 

// === 2007-07-01 ===
// module
define('_AM_HAPPY_SEARCH_MID','ID');
define('_AM_HAPPY_SEARCH_MNAME','�⥸�塼��̾');
define('_AM_HAPPY_SEARCH_DIRNAME','�ǥ��쥯�ȥ�̾');
define('_AM_HAPPY_SEARCH_ITEM','����');
define('_AM_HAPPY_SEARCH_PLUGIN', '�ץ饰����');
define('_AM_HAPPY_SEARCH_MOD_VERSION', '�С������');
define('_AM_HAPPY_SEARCH_NOTICE','���');
define('_AM_HAPPY_SEARCH_NOTICE_PLURAL','���ĤΥ⥸�塼���ʣ���Υץ饰����¸�ߤ��ޤ���<br />Ŭ�ڤʥץ饰��������򤷤Ƥ���������');

// main
define('_AM_HAPPY_SEARCH_CONF_MAIN', '�ᥤ��ڡ���������'); 
define('_AM_HAPPY_SEARCH_KEYWORD',   '������ɤν����');
define('_AM_HAPPY_SEARCH_SHOW_CONTEXT', '��ʸɽ���ν����');
define('_AM_HAPPY_SEARCH_MODULE_NUM',   '�⥸�塼����˸������뵭���ο�');
define('_AM_HAPPY_SEARCH_LABEL', '�����ȥ�');
define('_AM_HAPPY_SEARCH_FIRST', '�����ܤθ���');
define('_AM_HAPPY_SEARCH_FIRST_DESC', '��������⥸�塼��');
define('_AM_HAPPY_SEARCH_SECOND','�����ܤθ���');
define('_AM_HAPPY_SEARCH_SECOND_DESC','�оݤȤ���⥸�塼��');
define('_AM_HAPPY_SEARCH_CHECK_MODULE_TO_SEARCH','�������оݤȤ���⥸�塼��˥����å��������');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_SOAP', 'Google Soap �����Υ����ȥ�');
define('_AM_HAPPY_SEARCH_LABEL_GOOGLE_AJAX', 'Google Ajax �����Υ����ȥ�');

// block
define('_AM_HAPPY_SEARCH_CONF_BLOCK', '�֥�å�������'); 
define('_AM_HAPPY_SEARCH_PERIOD', '�����оݤδ��� (����)');
define('_AM_HAPPY_SEARCH_PERIOD_DESC', '<b>-1</b> �����¤ʤ�');
define('_AM_HAPPY_SEARCH_MODULE_MIN', '�⥸�塼�����ɽ������Ǿ��ε�����');
define('_AM_HAPPY_SEARCH_TOTAL','���Τ�ɽ���������ε�����');

// google soap
define('_AM_HAPPY_SEARCH_CONF_SOAP', 'Google Soap API ����'); 
define('_AM_HAPPY_SEARCH_USE_GOOGLE_SOAP_DESC', '���Υ����ӥ��Ͻ�λ���Ƥ��ޤ�<br />������ API Key ��������뤳�ȤϽ���ޤ���');

// google ajax
define('_AM_HAPPY_SEARCH_CONF_AJAX', 'Google Ajax API ����'); 
define('_AM_HAPPY_SEARCH_API_KEY','Google API Key');
define('_AM_HAPPY_SEARCH_API_KEY_DESC', 'Google Ajax ���������Ѥ������ <br /> <a href="http://code.google.com/apis/ajaxsearch/signup.html" target="_blank">Sign up for the Google AJAX Search API</a> <br /> �ˤ� <br /> API key ��������Ƥ�������<br /><br />�ѥ�᡼���ξܺ٤ϲ���������������<br /><a href="http://code.google.com/apis/ajaxsearch/documentation/reference.html" target="_blank">Google AJAX Search API Class Reference</a>');
define('_AM_HAPPY_SEARCH_USE_SITE_SEARCH',  '����Υ����Ȥ򸡺�����');
define('_AM_HAPPY_SEARCH_USE_WEB_SEARCH',   'WEB�򸡺�����');
define('_AM_HAPPY_SEARCH_USE_BLOG_SEARCH',  '�֥��򸡺�����');
define('_AM_HAPPY_SEARCH_USE_NEWS_SEARCH',  '�˥塼���򸡺�����');
define('_AM_HAPPY_SEARCH_USE_BOOK_SEARCH',  '���Ҥ򸡺�����');
define('_AM_HAPPY_SEARCH_USE_VIDEO_SEARCH', '�ӥǥ��򸡺�����');
define('_AM_HAPPY_SEARCH_USE_LOCAL_SEARCH', '�ϰ�򸡺�����');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT','[�ϰ踡��] �濴��');
define('_AM_HAPPY_SEARCH_LOCAL_CENTER_POINT_DESC','GlocalSearch - setCenterPoint');
define('_AM_HAPPY_SEARCH_SITE_LABEL', '[�����ȸ���] �����ȥ�');
define('_AM_HAPPY_SEARCH_SITE_LABEL_DESC', 'GSearchControl - setUserDefinedLabel');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX','[�����ȸ���] ������');
define('_AM_HAPPY_SEARCH_SITE_SUFFIX_DESC','GSearchControl - setUserDefinedClassSuffix');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION','[�����ȸ���] URL');
define('_AM_HAPPY_SEARCH_SITE_RESTRICTION_DESC','GwebSearch - setSiteRestriction');
define('_AM_HAPPY_SEARCH_DRAW_MODE','ɽ������');
define('_AM_HAPPY_SEARCH_DRAW_MODE_DESC','GdrawOptions - setDrawMode');
define('_AM_HAPPY_SEARCH_DRAW_MODE_LINEAR','�ķ���');
define('_AM_HAPPY_SEARCH_DRAW_MODE_TABBED','���ַ���');

// template
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE','�ƥ�ץ졼�ȤΥ���å��塦���ꥢ');
define('_AM_HAPPY_SEARCH_CONF_TEMPLATE_DESC','template/parts/ �ǥ��쥯�ȥ�ˤ���ƥ�ץ졼�Ȥ��ѹ������Ȥ��ˤϡ��¹Ԥ��뤳��');

}
// --- define language end ---

?>