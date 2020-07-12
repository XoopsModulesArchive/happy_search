<?php
// $Id: google_manage.php,v 1.4 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// happy_search_admin_print_footer()

// 2007-07-01 K.OHWADA
// google ajax

// 2007-02-18 K.OHWADA
// move googleLangRestrictions() to happy_search_google.php

//=========================================================
// Happy Search
// porting from xoogle index.php
// 2006-11-11 K.OHWADA
//=========================================================

//---------------------------------------------------------
// NOT use
//   lrinblock, slinblock, xoopsactive, xoopslabel
//---------------------------------------------------------

include 'admin_header.php';

$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();

$op = $config_form->get_post_get_op();
if ($op == 'save')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->save();
		redirect_header('google_manage.php', 2, _HAPPY_LINUX_SAVED);
	}
}
else
{
	xoops_cp_header();
}

happy_search_admin_print_header();
happy_search_admin_print_menu();

echo "<h3>". _MI_HAPPY_SEARCH_ADMIN_GOOGLE ."</h3>\n";

// --- ajax form --
echo "<h4>". _AM_HAPPY_SEARCH_CONF_AJAX ."</h4>\n";
$config_form->show_by_catid( 4, _AM_HAPPY_SEARCH_CONF_AJAX );

// --- soap form --
echo "<h4>". _AM_HAPPY_SEARCH_CONF_SOAP ."</h4>\n";
echo _AM_HAPPY_SEARCH_USE_GOOGLE_SOAP_DESC ."<br /><br />\n";

echo $config_form->build_form_begin('google_manage');
echo $config_form->build_token();
echo $config_form->build_html_input_hidden('op', 'save');

echo '<table class="outer" cellpadding="10" cellspacing="1">'."\n";
echo '<tr><th>';
	echo  _AM_HAPPY_SEARCH_CONF_SOAP;
echo "</th></tr>\n";
echo '<tr><td class="odd">';
	echo '<b>'._AM_HAPPY_SEARCH_KEY_LABEL.'</b>';
	echo $config_form->build_conf_textbox_by_name('google_key', 50);
	echo _AM_HAPPY_SEARCH_GOOGLE_KEY_INFO;
echo "</td></tr>\n";
echo '<tr><td class="even">';
	echo '<b>'._AM_HAPPY_SEARCH_LANG_LABEL.'</b> &nbsp; ';
	echo $config_form->build_google_lr();
	echo "<br /><br />\n";
	echo _AM_HAPPY_SEARCH_GOOGLE_LANG_INFO;
echo "</td></tr>\n";
echo '<tr><td class="odd">';
	echo "<b>". _AM_HAPPY_SEARCH_SLOCATION_LABEL ."</b><br />\n";
	echo _AM_HAPPY_SEARCH_SLOCATION_DESC ."<br />\n";

echo '<table cellpadding="5">'."\n";
echo '<tr>';
	echo '<td><b>'. _AM_HAPPY_SEARCH_LB_ACTIVE .'</b></td>';
	echo '<td><b>'. _AM_HAPPY_SEARCH_LB_DEFAULT .'</b></td>';
	echo '<td><b>'. _AM_HAPPY_SEARCH_LB_SEARCH_FUNCTION .'</b></td>';
	echo '<td><b>'. _AM_HAPPY_SEARCH_LB_LOCATION_LABEL .'</b></td>';
echo "</tr>\n<tr><td>";
	echo $config_form->build_conf_checkbox_by_name('siteactive');
echo '</td><td>';
	echo $config_form->build_sldefault_site();
echo '</td><td>';
	echo _AM_HAPPY_SEARCH_SEARCH_THIS_SITE;
echo '</td><td>';
	echo $config_form->build_conf_textbox_by_name('sitelabel', 20);
echo "</td></tr>\n<tr><td>";
	echo $config_form->build_conf_checkbox_by_name('webactive');
echo '</td><td>';
	echo $config_form->build_sldefault_web();
echo '</td><td>';
	echo _AM_HAPPY_SEARCH_SEARCH_THE_WEB;
echo '</td><td>';
	echo $config_form->build_conf_textbox_by_name('weblabel', 20);
echo "</td></tr></table>\n";

echo "</td></tr>\n";
echo '<tr><td class="foot">';
	echo $config_form->build_form_submit( 'submit', _HAPPY_LINUX_FORM_SUBMIT );
echo "</td></tr></table>\n";

echo $config_form->build_form_end();
// --- soap form end --

happy_search_admin_print_footer();
xoops_cp_footer();
exit();
// === main end ===


?>