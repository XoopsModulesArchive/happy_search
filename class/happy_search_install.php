<?php
// $Id: happy_search_install.php,v 1.1 2007/11/26 03:34:21 ohwada Exp $

//=========================================================
// Happy Search
// 2007-11-24 K.OHWADA
//=========================================================

if( ! class_exists('happy_search_install') ) 
{

//=========================================================
// class happy_search_install
//=========================================================
class happy_search_install extends happy_linux_module_install
{
	var $_DIRNAME;

	var $_module_table;

	var $_FIRST_NOTSHOW_ARRAY = array('rssc', 'rssc0', 'xoogle');
	var $_SECOND_SHOW_ARRAY   = array('rssc', 'rssc0');

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_install( $dirname )
{
	$this->_DIRNAME = $dirname;

	$this->happy_linux_module_install();
	$this->set_config_define_class( happy_search_config_define::getInstance( $dirname ) );
	$this->set_config_table_name( $dirname.'_config' );

	$this->_module_table = $this->prefix( $dirname.'_module' );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search_install( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function check_install()
{
	if ( !$this->check_init_config() )
	{	return false;	}

	if ( !$this->_check_init_module() )
	{	return false;	}

	return true;
}

function install()
{
	if ( !$this->check_init_config() )
	{
		$this->init_config();
		$this->set_msg( $this->get_init_config_msg() );
	}

	if ( !$this->_check_init_module() )
	{
		$this->_init_module();
		$this->set_msg( $this->build_init_msg( $this->_module_table ) );
	}

	return $this->return_flag_error();
}

function check_update()
{
	if ( !$this->_check_module_040() )
	{	return false;	}

	if ( !$this->check_update_config() )
	{	return false;	}

	return true;
}

function update()
{
echo " update() ";

	if ( !$this->_check_module_040() )
	{
		$this->clear_error();
		$this->drop_table( $this->_module_table );
		$this->_create_module_table();
		$this->_init_module();
		$this->set_msg( $this->build_update_msg( $this->_module_table ) );
	}

	$this->update_config();
	$this->set_msg( $this->get_update_config_msg() );

	$this->clear_all_template();
	$this->set_msg( $this->build_tpl_msg() );

	return $this->return_flag_error();
}

//---------------------------------------------------------
// module table
//---------------------------------------------------------
function _create_module_table()
{
$sql = "
CREATE TABLE ". $this->_module_table ." (
  id smallint(5) unsigned NOT NULL auto_increment,
  mid int(8) NOT NULL default '0',
  first_notshow tinyint(1) NOT NULL default '0',
  second_show   tinyint(1) NOT NULL default '0',
  plugin_file  varchar(255) default '',
  plugin_func  varchar(255) default '',
  aux_int_1 int(5) default '0',
  aux_int_2 int(5) default '0',
  aux_text_1 varchar(255) default '',
  aux_text_2 varchar(255) default '',
  PRIMARY KEY (id),
  KEY mid (mid)
) TYPE=MyISAM
";
	
	return $this->query($sql);
}

function _init_module()
{
	$xoops_module_objs =& $this->get_xoops_module_objects_isactive();

	foreach ( $xoops_module_objs as $obj )
	{
		$mid        = $obj->getVar('mid',       'n');
		$dirname    = $obj->getVar('dirname',   'n');
		$has_search = $obj->getVar('hassearch', 'n');

		if ( ( $has_search != 1 )&&( $dirname != 'system' )&&( $dirname != 'legacy' ))
		{	continue;	}

		$first_notshow = 0;
		$second_show   = 0;

		if ( in_array($dirname, $this->_FIRST_NOTSHOW_ARRAY) )
		{	$first_notshow = 1;	}
		if ( in_array($dirname, $this->_SECOND_SHOW_ARRAY) )
		{	$second_show = 1;	}

		$row = array(
			'mid'           => $mid,
			'first_notshow' => $first_notshow,
			'second_show'   => $second_show,
		);

		$this->_insert_module( $row );
	}

}

function _insert_module( &$row )
{
	return $this->query( $this->_build_insert_module_sql( $row ) );
}

function _build_insert_module_sql( &$row )
{
	$plugin_file = '';
	$plugin_func = '';
	$aux_int_1   = 0;
	$aux_int_2   = 0;
	$aux_text_1  = '';
	$aux_text_2  = '';

	foreach ($row as $k => $v) 
	{	${$k} = $v;	}

	$sql  = 'INSERT INTO '. $this->_module_table .' (';
	$sql .= 'mid, ';
	$sql .= 'first_notshow, ';
	$sql .= 'second_show, ';
	$sql .= 'plugin_file, ';
	$sql .= 'plugin_func, ';
	$sql .= 'aux_int_1, ';
	$sql .= 'aux_int_2, ';
	$sql .= 'aux_text_1, ';
	$sql .= 'aux_text_2 ';
	$sql .= ') VALUES ( ';
	$sql .= intval($mid) .', ';
	$sql .= intval($first_notshow) .', ';
	$sql .= intval($second_show).', ';
	$sql .= $this->quote($plugin_file).', ';
	$sql .= $this->quote($plugin_func).', ';
	$sql .= intval($aux_int_1).', ';
	$sql .= intval($aux_int_2).', ';
	$sql .= $this->quote($aux_text_1).', ';
	$sql .= $this->quote($aux_text_2).' ';
	$sql .= ')';

	return $sql;
}

function _check_init_module()
{
	return $this->get_count_all( $this->_module_table );
}

function _check_module_040()
{
	return $this->exists_column( $this->_module_table, 'plugin_file' );
}

//---------------------------------------------------------
// template
//---------------------------------------------------------
function clear_all_template()
{
	$dir_tpl = XOOPS_ROOT_PATH .'/modules/'. $this->_DIRNAME .'/templates';

	$this->clear_error();

	$this->clear_compiled_tpl_by_dir( $dir_tpl .'/parts' );

	return $this->return_errors();
}

// --- class end ---
}

// === class end ===
}

?>