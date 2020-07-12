<?php
// $Id: admin_config_class.php,v 1.2 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// happy_search_install
// get_by_mid()

//=========================================================
// Happy Search
// 2007-07-01 K.OHWADA
//=========================================================

//=========================================================
// class admin_config_form
//=========================================================
class admin_config_form extends happy_linux_config_form
{
	var $_happy_search_module_handler;
	var $_xoops_module_handler;
	var $_google_class;
	var $_plugin;
	var $_system;

	var $_flag_all_modules = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function admin_config_form()
{
	$this->happy_linux_config_form();

	$define =& happy_search_config_define::getInstance();
	$this->set_config_handler('config', HAPPY_SEARCH_DIRNAME, 'happy_search');
	$this->set_config_define( $define );

	$this->_happy_search_module_handler =& happy_search_get_handler('module', HAPPY_SEARCH_DIRNAME );
	$this->_xoops_module_handler =& happy_search_xoops_module_handler::getInstance();
	$this->_google_class         =& happy_search_google::getInstance( HAPPY_SEARCH_DIRNAME );
	$this->_plugin               =& happy_search_plugin::getInstance( HAPPY_SEARCH_DIRNAME );

	$this->_system =& happy_linux_system::getInstance();

// init
	$this->load();
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new admin_config_form();
	}
	return $instance;
}

//---------------------------------------------------------
// module table
//---------------------------------------------------------
function print_form_modules( $title )
{
	if ( $this->_post->get_get_text('show') == 'all' )
	{	$this->_flag_all_modules = true;	}

	echo '<div align="right"><a href="?show=all">Show All Modules</a></div>';

	$xoops_module_objs =& $this->_xoops_module_handler->get_objects_isactive_all();

	echo $this->build_form_begin('module_manage');
	echo $this->build_html_input_hidden('op', 'module_save');
	echo $this->build_token();

	echo '<table width="100%" border="0" cellspacing="1" class="outer">'."\n";
	echo '<tr><th colspan="4">'. $title .'</th></tr>'."\n";

	echo '<tr>'."\n";
	echo '<th align="center">';
		echo _AM_HAPPY_SEARCH_MID;
	echo '</th>'."\n";
	echo '<th align="center">';
		echo _AM_HAPPY_SEARCH_DIRNAME;
	echo '</th>'."\n";
	echo '<th align="center">';
		echo _AM_HAPPY_SEARCH_FIRST;
		echo "<br />\n";
		echo _AM_HAPPY_SEARCH_FIRST_DESC;
	echo '</th>'."\n";
	echo '<th align="center">';
		echo _AM_HAPPY_SEARCH_SECOND;
		echo "<br />\n";
		echo _AM_HAPPY_SEARCH_SECOND_DESC;
	echo '</th>'."\n";
	echo '</tr>'."\n";

	foreach ( $xoops_module_objs as $xoops_module_obj )
	{
		$this->print_form_module_each( $xoops_module_obj );
	}

	echo '<tr>'."\n";
	echo '<th></th>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_ITEM   .'</th>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_FIRST  .'</th>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_SECOND .'</th>'."\n";
	echo '</tr>'."\n";

	$this->print_form_module_line(_AM_HAPPY_SEARCH_LABEL,      'label_first', 'label_second', 20);
	$this->print_form_module_line(_AM_HAPPY_SEARCH_MODULE_NUM, 'num_first',   'num_second',   5);

	echo '<tr>';
	echo '<td colspan="2" class="foot"></td>'."\n";
	echo '<td colspan="2" class="foot">'."\n";
		echo $this->build_html_input_submit('submit', _HAPPY_LINUX_FORM_SUBMIT);
	echo '</td></tr>';
	echo '</table>'."\n";
	echo $this->build_form_end();
}

function print_form_module_line($label, $name1, $name2, $size=5)
{
	$class = $this->build_form_class_even_odd();
	echo '<tr class="'. $class .'" align="left">'."\n";
	echo '<td></td>'."\n";
	echo '<td>';
		echo $label;
	echo '</td>'."\n";	
	echo '<td>';
		echo $this->build_conf_textbox_by_name( $name1, $size );
	echo '</td>'."\n";
	echo '<td>';
		echo $this->build_conf_textbox_by_name( $name2, $size );
	echo '</td>'."\n";
	echo '</tr>'."\n";
}

function print_form_module_each( &$xoops_module_obj )
{
	$dirname    = $xoops_module_obj->getVar('dirname');
	$has_search = $xoops_module_obj->getVar('hassearch');
	$dirname_comment = $this->_xoops_module_handler->get_dirname_comment();

	if ( ( $has_search == 1 )||( $dirname == $dirname_comment ))
	{
		$this->print_form_module_each_has_search( $xoops_module_obj );
	}
	elseif ( $this->_flag_all_modules )
	{
		$this->print_form_module_each_not_search( $xoops_module_obj );
	}
}

function print_form_module_each_has_search( &$xoops_module_obj )
{
	$mid       = $xoops_module_obj->getVar('mid');
	$dirname   = $xoops_module_obj->getVar('dirname');
	$dirname_s = $xoops_module_obj->getVar('dirname', 's');
	$name_s    = $xoops_module_obj->getVar('name',    's');

	$first_notshow = 0;
	$second_show   = 0;

	$search_obj =& $this->_happy_search_module_handler->get_by_mid( $mid );
	if ( is_object($search_obj) )
	{
		$first_notshow = $search_obj->getVar('first_notshow');
		$second_show   = $search_obj->getVar('second_show');
	}

	$color_first  = $first_notshow ? "red"  : "black" ;
	$color_second = $second_show   ? "blue" : "black" ;

	$name_first  = 'first_notshows['. $mid .']';
	$name_second = 'second_shows['.   $mid .']';

	$class = $this->build_form_class_even_odd();

	echo '<tr class="'. $class .'" align="left">'."\n";
	echo '<td>';
		echo $mid;
		echo " \n";
		echo $this->build_html_input_hidden('mod_ids[]', $mid);
	echo '</td>'."\n";
	echo '<td>';
		echo $dirname_s;
	echo '</td>'."\n";
	echo '<td>';
		echo '<span style="color:'.$color_first.' ;">';
		echo $this->build_form_checkbox_yesno($name_first, $first_notshow);
		echo ' ' . $name_s;
		echo '</span>';
	echo '</td>'."\n";
		echo '<td>';
		echo '<span style="color:'.$color_second.' ;">';
		echo $this->build_form_checkbox_yesno($name_second, $second_show);
		echo ' ' . $name_s;
		echo '</span>';
	echo '</td>'."\n";
	echo '</tr>'."\n";
}

function print_form_module_each_not_search( &$xoops_module_obj )
{
	$mid       = $xoops_module_obj->getVar('mid');
	$dirname   = $xoops_module_obj->getVar('dirname');
	$dirname_s = $xoops_module_obj->getVar('dirname', 's');
	$name_s    = $xoops_module_obj->getVar('name',    's');

	$class = $this->build_form_class_even_odd();

	echo '<tr class="'. $class .'" align="left">'."\n";
	echo '<td>';
		echo $mid;
	echo '</td>'."\n";
	echo '<td>';
		echo $dirname_s;
	echo '</td>'."\n";
	echo '<td>';
		echo $name_s;
	echo '</td>'."\n";
	echo '<td>';
		echo '---';
	echo '</td>'."\n";
	echo '</tr>'."\n";
}

//---------------------------------------------------------
// plugin
//---------------------------------------------------------
function exists_plugin_plural()
{
	$xoops_module_objs =& $this->_xoops_module_handler->get_objects_isactive_cache();
	foreach ( $xoops_module_objs as $xoops_module_obj )
	{
		$mod_dirname = $xoops_module_obj->getVar('dirname');
		if (($mod_dirname != 'system')&&($mod_dirname != 'legacy'))
		{
			if ( $this->_plugin->check_plural_plugins( $mod_dirname ) )
			{
				return true;
			}
		}
	}
	return false;
}

function print_form_plugins()
{
	$xoops_module_objs =& $this->_xoops_module_handler->get_objects_isactive_cache();

	echo $this->build_form_begin('plugin');
	echo $this->build_token();
	echo $this->build_html_input_hidden('op', 'plugin_save');

	echo '<table class="outer" width="100%">'."\n";
	echo '<tr>';
	echo '<th align="center">'._AM_HAPPY_SEARCH_MID.'</th>'."\n";
	echo '<th align="center">'._AM_HAPPY_SEARCH_MNAME.'</th>'."\n";
	echo '<th align="center">'._AM_HAPPY_SEARCH_DIRNAME.'</th>'."\n";
	echo '<th align="center">'._AM_HAPPY_SEARCH_MOD_VERSION.'</th>'."\n";
	echo '<th align="center">'._AM_HAPPY_SEARCH_PLUGIN.'</th>'."\n";
	echo '</tr>'."\n";

	foreach ( $xoops_module_objs as $xoops_module_obj )
	{
		$mod_dirname = $xoops_module_obj->getVar('dirname');
		if (($mod_dirname != 'system')&&($mod_dirname != 'legacy'))
		{
			if ( $this->_plugin->check_plural_plugins( $mod_dirname ) )
			{
				$this->print_form_plugin_line($xoops_module_obj);
			}
		}
	}

	echo '<tr class="foot"><td></td><td></td><td colspan="3">';
	echo $this->build_form_submit( 'submit', _HAPPY_LINUX_FORM_SUBMIT );
	echo '</tr>'."\n";
	echo '</table>'."\n";
	echo $this->build_form_end();
	echo '<br />'."\n";
}

function print_form_plugin_line( &$xoops_module_obj )
{
	$mid       = $xoops_module_obj->getVar('mid');
	$version   = $xoops_module_obj->getVar('version');
	$dirname   = $xoops_module_obj->getVar('dirname');
	$dirname_s = $xoops_module_obj->getVar('dirname', 's');
	$name_s    = $xoops_module_obj->getVar('name',    's');

	$version_s = round($version / 100, 2);
	$plugin_s  = $this->build_form_plugin_select( $xoops_module_obj );

	$mod_ids = $this->build_html_input_hidden('mod_ids[]', $mid);
	$class   = $this->build_form_class_even_odd();

	echo '<tr class="'. $class .'" align="left">'."\n";
	echo '<td>'.$mid.' '.$mod_ids.'</td>';
	echo '<td>'.$name_s.'</td>';
	echo '<td>'.$dirname_s.'</td>';
	echo '<td>'.$version_s.'</td>'."\n";
	echo '<td>'.$plugin_s.'</td>';
	echo '</tr>'."\n";
}

function build_form_plugin_select( &$xoops_module_obj )
{
	$mid         = $xoops_module_obj->getVar('mid');
	$mod_dirname = $xoops_module_obj->getVar('dirname');

	$text   = '';

	$plugin_file   = '';
	$plugin_func   = '';

	$search_obj =& $this->_happy_search_module_handler->get_by_mid( $mid );
	if ( is_object($search_obj) )
	{
		$plugin_file = $search_obj->getVar('plugin_file');
		$plugin_func = $search_obj->getVar('plugin_func');
	}

	$plugins  = $this->_plugin->get_plugins_by_xoops_module_obj( $xoops_module_obj );
	$flag_checked = false;

	foreach ($plugins as $plug)
	{
		$num   = $plug['num']; 
		$file  = $plug['file']; 
		$func  = $plug['func']; 
		$title = $plug['title']; 

		$name_num   = 'plugin_nums['.      $mid .']';
		$name_file  = 'plugin_file_nums['. $mid .']['. $num .']';
		$name_func  = 'plugin_func_nums['. $mid .']['. $num .']';
		$file_show  = $this->sanitize_text($file);
		$func_show  = $this->sanitize_text($func);
		$title_show = $this->sanitize_text($title);
		$checked    = $this->build_html_checked($plugin_file, $file);
		$url        = 'view_plugin.php?dirname='. $mod_dirname .'&amp;num='. $num;

		if ($checked)
		{
			$flag_checked = true;
		}

		$text .= $this->build_html_input_radio( $name_num,  $num, $checked);
		$text .= $this->build_html_input_hidden($name_file, $file_show);
		$text .= $this->build_html_input_hidden($name_func, $func_show);
		$text .= $title_show." \n";
		$text .= $this->build_html_a_href_name($url, '[view]', '_blank');
		$text .= "<br />\n";
	}

	if ( !$flag_checked )
	{
		$text .= '<span style="color:#ff0000">Not Select</span> <br />'."\n";
	}

	return $text;
}

//---------------------------------------------------------
// block
//---------------------------------------------------------
function print_form_block( $title )
{
	echo $this->build_form_begin('block');
	echo $this->build_html_input_hidden('op', 'save');
	echo $this->build_token();

	echo '<table width="100%" border="0" cellspacing="1" class="outer">'."\n";
	echo '<tr><th colspan="3">'. $title .'</th></tr>'."\n";

	echo '<tr>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_ITEM   .'</th>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_FIRST  .'</th>'."\n";
	echo '<th align="center">'. _AM_HAPPY_SEARCH_SECOND .'</th>'."\n";
	echo '</tr>'."\n";

	$this->print_form_block_line(_AM_HAPPY_SEARCH_MODULE_NUM, 'block_num_first',   'block_num_second');
	$this->print_form_block_line(_AM_HAPPY_SEARCH_MODULE_MIN, 'block_min_first',   'block_min_second');
	$this->print_form_block_line(_AM_HAPPY_SEARCH_TOTAL,      'block_total_first', 'block_total_second');

	echo '<tr>';
	echo '<td class="foot"></td>'."\n";
	echo '<td colspan="2" class="foot">'."\n";
		echo $this->build_html_input_submit('submit', _HAPPY_LINUX_FORM_SUBMIT);
	echo '</td></tr>';
	echo '</table>'."\n";
	echo $this->build_form_end();
}

function print_form_block_line($label, $name1, $name2)
{
	$class = $this->build_form_class_even_odd();
	echo '<tr class="'. $class .'" align="left">'."\n";
	echo '<td>';
		echo $label;
	echo '</td>'."\n";	
	echo '<td>';
		echo $this->build_conf_textbox_by_name( $name1 );
	echo '</td>'."\n";
	echo '<td>';
		echo $this->build_conf_textbox_by_name( $name2 );
	echo '</td>'."\n";
	echo '</tr>'."\n";
}

//---------------------------------------------------------
// view_plugin
//---------------------------------------------------------
function view_plugin($mod_dirname, $num)
{
	$xoops_module_obj =& $this->_system->get_module_by_dirname( $mod_dirname );
	$plugins          =& $this->_plugin->get_plugins_by_xoops_module_obj( $xoops_module_obj );

	if ( isset($plugins[$num]['file']) )
	{
		$file = $plugins[$num]['file'];
	}
	else
	{
		echo "no plugin file: $mod_dirname";
		return false;
	}

	$file_plugin  = XOOPS_ROOT_PATH.'/'.$file;

	if ( file_exists($file_plugin) )
	{
		highlight_file($file_plugin);
	}
	else
	{
		echo "no plugin file: $file_plugin";
		return false;
	}

	return;
}

//---------------------------------------------------------
// google
//---------------------------------------------------------
function build_google_lr()
{
// get the google language restrictions to display in form
	$google_lr = $this->_google_class->googleLangRestrictions();

	$opt = array(
		_AM_HAPPY_SEARCH_NO_RESTRICTIONS => 'no_lr',
	);

	foreach ( $google_lr as $lr )
	{
		$opt[ $lr['label'] ] = $lr['code'];
	}

	$value = $this->get_by_name('google_lr', 'value');
	$text  = $this->build_html_select('google_lr', $value, $opt);
	$text .= $this->build_conf_hidden_by_name('google_lr');
	return $text;
}

function build_sldefault_site()
{
	$value   = $this->get_by_name('sldefault', 'value');
	$checked = $this->build_html_checked($value, 'site');

	$text  = $this->build_html_input_radio('sldefault', 'site', $checked);
	$text .= $this->build_conf_hidden_by_name('sldefault');
	return $text;
}

function build_sldefault_web()
{
	$value   = $this->get_by_name('sldefault', 'value');
	$checked = $this->build_html_checked($value, 'web');

	$text = $this->build_html_input_radio('sldefault', 'web', $checked);
	return $text;
}

//---------------------------------------------------------
// show_template
//---------------------------------------------------------
function show_form_template( $title )
{
	echo $this->build_form_begin('template_clear');
	echo $this->build_token();
	echo $this->build_html_input_hidden('op', 'template_clear');
	echo "<table class='outer' width='100%' ><tr>";
	echo "<th align='left'>".$title."</th>";
	echo "</tr>\n";
	echo "<tr class='foot'><td>";
	echo $this->build_html_input_submit( 'submit', _HAPPY_LINUX_CLEAR );
	echo "</td></tr></table>\n";
	echo $this->build_form_end();
	echo "<br />\n";
}

// --- class end ---
}

//================================================================
// class admin_config_store
//================================================================
class admin_config_store extends happy_linux_error
{
	var $_config_store_handler;
	var $_module_store_handler;
	var $_install;
	var $_class_dir;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function admin_config_store()
{
	$this->happy_linux_error();

// config_store_handler
	$define =& happy_search_config_define::getInstance( HAPPY_SEARCH_DIRNAME );
	$this->_config_store_handler =& happy_linux_config_store_handler::getInstance();
	$this->_config_store_handler->set_handler('config', HAPPY_SEARCH_DIRNAME, 'happy_search');
	$this->_config_store_handler->set_define( $define );

// handler
	$this->_module_store_handler =& happy_search_get_handler('module_store', HAPPY_SEARCH_DIRNAME );
	$this->_install              =& happy_search_install::getInstance(       HAPPY_SEARCH_DIRNAME );

	$this->_class_dir =& happy_linux_dir::getInstance();

}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new admin_config_store();
	}
	return $instance;
}

//---------------------------------------------------------
// save config
//---------------------------------------------------------
function save()
{
	$ret = $this->_config_store_handler->save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_config_store_handler->getErrors() );
	}

	return $ret;
}

function module_save()
{
	$this->_clear_errors();

	$ret = $this->_module_store_handler->module_save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_module_store_handler->getErrors() );
	}

	$ret = $this->_config_store_handler->save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_config_store_handler->getErrors() );
	}

	return $this->returnExistError();
}

function plugin_save()
{
	$this->_clear_errors();

	$ret = $this->_module_store_handler->plugin_save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_module_store_handler->getErrors() );
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// init
//---------------------------------------------------------
function check_init()
{
	if ( !$this->_install->check_install() )
	{	return false;	}

	return true;
}

function init()
{
	$this->_clear_errors();

	$ret = $this->_install->install();
	if ( !$ret )
	{
		$this->_set_errors( $this->_install->get_message() );
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// upgrade
//---------------------------------------------------------
function check_upgrade()
{
	if ( !$this->_install->check_update() )
	{	return false;	}

	return true;
}

function upgrade()
{
	$this->_clear_errors();

	$ret = $this->_install->update();
	if ( !$ret )
	{
		$this->_set_errors( $this->_install_handler->get_message() );
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// template clear
//---------------------------------------------------------
function template_clear()
{
	$this->_install->clear_all_template();
}

// --- class end ---
}

?>