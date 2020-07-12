<?php
// $Id: config_block.php,v 1.2 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// happy_search_admin_print_footer()

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

include 'admin_header.php';

// class
$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();

$op = $config_form->get_post_get_op();

switch($op)
{
case 'save':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->save();
		redirect_header("config_block.php", 2, _HAPPY_LINUX_SAVED);
	}
	break;

default:
	xoops_cp_header();
	break;
}

happy_search_admin_print_header();
happy_search_admin_print_menu();

echo '<a name="form_block"></a>'."\n";
echo "<h4>". _AM_HAPPY_SEARCH_CONF_BLOCK ."</h4>\n";
$config_form->print_form_block( _AM_HAPPY_SEARCH_CONF_BLOCK );
echo "<br /><br />\n";

$config_form->show_by_catid( 7, _AM_HAPPY_SEARCH_CONF_BLOCK );
echo "<br /><br />\n";

happy_search_admin_print_footer();
xoops_cp_footer();
exit();
// --- main end ---

?>