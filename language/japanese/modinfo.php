<?php 
// $Id: modinfo.php,v 1.2 2007/07/04 11:02:54 ohwada Exp $ 

// 2007-07-01 K.OHWADA
// renewal
// module depulication

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
// ͭ����������
//=========================================================

// --- define language begin ---
if( !defined('HAPPY_SEARCH_LANG_MI_LOADED') ) 
{

define('HAPPY_SEARCH_LANG_MI_LOADED', 1);

define('_MI_HAPPY_SEARCH_NAME', 'Happy Search'); 
define('_MI_HAPPY_SEARCH_DESC', '���������Google�򸡺�����⥸�塼��');

// Blocks
define('_MI_HAPPY_SEARCH_BLOCK_FORM', '����'); 
define('_MI_HAPPY_SEARCH_BLOCK_FORM_DESC','�����ե������֥�å���ɽ�����ޤ���');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT', '����[ž����]');
define('_MI_HAPPY_SEARCH_BLOCK_REDIRECT_DESC', '���Υ֥�å��򥪥�ˤ��Ƥ����'.XOOPS_URL.'/search.php�ؤΥꥯ�����Ȥ�ͭ�ä��ݤ˼�ưŪ�ˤ��Υ⥸�塼���ž���Ǥ��ޤ���');
define('_MI_HAPPY_SEARCH_BLOCK_RESULT', '�������'); 
define('_MI_HAPPY_SEARCH_BLOCK_RESULT_DESC','������̤�֥�å���ɽ�����ޤ���');

// Templates
define('_MI_HAPPY_SEARCH_TEMPLATE_INDEX','�������');
define('_MI_HAPPY_SEARCH_TEMPLATE_ALL','�⥸�塼���̸������');
define('_MI_HAPPY_SEARCH_TEMPLATE_FORM','�����ե�����');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_FORM','Google�����ե�����');
define('_MI_HAPPY_SEARCH_TEMPLATE_GOOGLE_PAGE','Google �ڡ����ʥ�');

// Admin menu
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK','���롼��/�֥�å�����');
define('_MI_HAPPY_SEARCH_ADMIN_BLOCK_DESC','���Υ⥸�塼��Υ����������ȥ֥�å��δ���');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE','�ƥ�ץ졼�ȴ���');
define('_MI_HAPPY_SEARCH_ADMIN_TEMPLATE_DESC','���Υ⥸�塼��Υƥ�ץ졼�Ȥ����');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE','�����⥸�塼�����');
define('_MI_HAPPY_SEARCH_ADMIN_EXCLUDE_DESC','�������оݤ����������⥸�塼��δ���');
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE', 'Google �������'); 
define('_MI_HAPPY_SEARCH_ADMIN_GOOGLE_DESC', '���Υ⥸�塼��� Google ��������'); 

// Title of config items
define('_MI_HAPPY_SEARCH_CONFIG1','��ʸ��ɽ������');
define('_MI_HAPPY_SEARCH_CONFIG_DESC1','������̤���ʸ�γ���������ʬ��ɽ�����ޤ���');

// === 2007-07-01 ===
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG','�⥸�塼������');
define('_MI_HAPPY_SEARCH_ADMIN_CONFIG_DESC','���Υ⥸�塼�������');

}
// --- define language end ---

?>