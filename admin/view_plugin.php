<?php
// $Id: view_plugin.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

include_once 'admin_header.php';

if ( file_exists(XOOPS_ROOT_PATH.'/modules/system/language/'.$XOOPS_LANGUAGE.'/blocks.php') ) 
{
	include_once XOOPS_ROOT_PATH.'/modules/system/language/'.$XOOPS_LANGUAGE.'/blocks.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/modules/system/language/english/blocks.php';
}

//---------------------------------------------------------
// main
//---------------------------------------------------------
$config_form =& admin_config_form::getInstance();
$post        =& happy_linux_post::getInstance();

$dirname = $post->get_get('dirname');
$num     = $post->get_get_int('num');
$title   = 'WhatsNew Plugin for '.$dirname;

?>
<html><head>
<title><?php echo $title; ?></title>
</head><body>
<br />
&nbsp;
<a href="<?php echo XOOPS_URL; ?>/"><?php echo $xoopsConfig['sitename']; ?></a>
 &gt;&gt; 
<a href="<?php echo XOOPS_URL; ?>/modules/whatsnew/"><?php echo $xoopsModule->getVar('name'); ?></a>
 &gt;&gt; 
<a href="<?php echo XOOPS_URL; ?>/modules/whatsnew/admin/"><?php echo _MB_SYSTEM_ADMENU; ?></a>
 &gt;&gt; 
<input value="<?php echo _CLOSE; ?>" type="button" onclick="javascript:window.close();" />
<br />
<h3><?php echo $title; ?></h3>
<div style="margin: 5px; padding: 5px; border: 1px solid #808080; ">
<?php

$config_form->view_plugin($dirname, $num);

?>
</div>
<input value="<?php echo _CLOSE; ?>" type="button" onclick="javascript:window.close();" />
</body></html>
<?php

exit();
// --- main end ---

?>