<?php
// $Id: admin_functions.php,v 1.5 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// happy_linux_admin_menu
// table_manage.php

// 2007-07-01 K.OHWADA
// menu: preference.php blocks.php templates.php

// 2007-05-20 K.OHWADA
// XC 2.1: preferences

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// TODO
// merge 3 config: preferences, search, google
//---------------------------------------------------------

function happy_search_admin_print_header()
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_header( HAPPY_SEARCH_DIRNAME, _MI_HAPPY_SEARCH_DESC );
}

function happy_search_admin_print_footer()
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_footer();
}

function happy_search_admin_print_bread( $name1, $url1='', $name2='' )
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_admin_bread_crumb( $name1, $url1, $name2 );
}

function happy_search_admin_print_powerdby()
{

?>
<div style="text-align: right;">
<a href="http://linux.ohwada.jp/" target="_blank">happy search</a> | 
<a href="http://kjw0815.codns.com/wanisys/japanese/xoops/html/" target="_blank">xoogle euc-kr</a> | 
<a href="http://www.suin.jp" target="_blank">search</a> | 
<a href="http://xoopscube.jp/" target="_blank">xoops(original)</a>
</div>
<div style="text-align: right; font-size: small;">
&copy; 2006, Kenichi OHWADA
</div>
<?php

}

function happy_search_admin_print_menu()
{
	$MAX_COL = 4;

	$menu_arr = array(
		_MI_HAPPY_SEARCH_ADMIN_CONFIG  => 'index.php',
		_MI_HAPPY_SEARCH_ADMIN_GOOGLE  => 'google_manage.php',
		_AM_HAPPY_SEARCH_CONF_MAIN     => 'config_main.php',
		_AM_HAPPY_SEARCH_CONF_BLOCK    => 'config_block.php',

		_HAPPY_LINUX_CONF_TABLE_MANAGE => 'table_manage.php',
		_HAPPY_LINUX_AM_MODULE         => 'modules.php',
		_HAPPY_LINUX_AM_BLOCK          => 'blocks.php',
		_HAPPY_LINUX_AM_TEMPLATE       => 'templates.php',

		_HAPPY_LINUX_GOTO_MODULE       => '../index.php'
	);

	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_menu_table($menu_arr, $MAX_COL);

}

?>