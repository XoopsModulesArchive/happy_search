<?php
// $Id: config_main.php,v 1.3 2007/11/26 03:33:02 ohwada Exp $ 

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
		redirect_header("config_main.php", 2, _HAPPY_LINUX_SAVED);
	}
	break;

case 'template_clear':
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		xoops_error("Token Error");
		echo "<br />\n";
		echo $config_form->get_token_error(1);
		echo "<br />\n";
	}
	else
	{
		$config_store->template_clear();
		redirect_header("config_main.php", 1, _HAPPY_LINUX_CLEARED );
	}
	break;

default:
	xoops_cp_header();
	break;
}

happy_search_admin_print_header();
happy_search_admin_print_menu();

echo '<a name="form_main"></a>'."\n";
echo "<h4>". _AM_HAPPY_SEARCH_CONF_MAIN ."</h4>\n";
$config_form->show_by_catid( 1, _AM_HAPPY_SEARCH_CONF_MAIN );
echo "<br /><br />\n";

echo '<a name="form_template"></a>'."\n";
echo "<h4>"._AM_HAPPY_SEARCH_CONF_TEMPLATE."</h4>\n";
echo _AM_HAPPY_SEARCH_CONF_TEMPLATE_DESC."<br /><br />\n";
$config_form->show_form_template( _AM_HAPPY_SEARCH_CONF_TEMPLATE );

happy_search_admin_print_footer();
xoops_cp_footer();
exit();
// --- main end ---

?>