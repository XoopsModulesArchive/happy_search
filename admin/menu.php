<?php
// $Id: menu.php,v 1.3 2007/07/04 11:02:52 ohwada Exp $ 

// 2007-03-03 K.OHWADA
// BUG: not find admin/xoogle.php

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

$adminmenu[0]  = array(
	'title' => _MI_HAPPY_SEARCH_ADMIN_CONFIG ,
	'link'  => "admin/index.php",
	'desc'  => _MI_HAPPY_SEARCH_ADMIN_CONFIG_DESC );
$adminmenu[1]  = array(
	'title' => _MI_HAPPY_SEARCH_ADMIN_GOOGLE ,
	'link'  => "admin/google_manage.php",
	'desc'  => _MI_HAPPY_SEARCH_ADMIN_GOOGLE_DESC );

?>