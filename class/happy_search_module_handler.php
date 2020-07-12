<?php
// $Id: happy_search_module_handler.php,v 1.4 2007/11/26 03:33:02 ohwada Exp $

// 2007-11-24 K.OHWADA
// get_by_mid()

// 2007-07-01 K.OHWADA
// renewal

// 2007-03-03 K.OHWADA
// conflict class name in XC21 
// happy_search_module -> happy_search_module_object

//=========================================================
// Happy Search
// this file contain 2 class
//   happy_search_module_object 
//   happy_search_module_handler
// 2006-11-11 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_module_handler') ) 
{

//=========================================================
// class happy_search_module_object
//=========================================================
class happy_search_module_object extends happy_linux_object
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_module_object()
{
	$this->happy_linux_object();

	$this->initVar('id',            XOBJ_DTYPE_INT, 0, true);
	$this->initVar('mid',           XOBJ_DTYPE_INT, 0, false);
	$this->initVar('first_notshow', XOBJ_DTYPE_INT, 0, false);
	$this->initVar('second_show',   XOBJ_DTYPE_INT, 0, false);
	$this->initVar('plugin_file',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('plugin_func',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('aux_int_1',     XOBJ_DTYPE_INT,   0);
	$this->initVar('aux_int_2',     XOBJ_DTYPE_INT,   0);
	$this->initVar('aux_text_1',    XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('aux_text_2',    XOBJ_DTYPE_TXTBOX, null, false, 255);
	
}

// --- class end ---
}

//=========================================================
// class happy_search_module_handler
//=========================================================
class happy_search_module_handler extends happy_linux_object_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_module_handler( $dirname )
{
	$this->happy_linux_object_handler( $dirname, 'module', 'mid', 'happy_search_module_object' );

	$this->set_debug_db_sql(   HAPPY_SEARCH_DEBUG_SQL );
	$this->set_debug_db_error( HAPPY_SEARCH_DEBUG_ERROR );
}


//---------------------------------------------------------
// basic function
//---------------------------------------------------------
function _build_insert_sql(&$obj)
{
	foreach ($obj->gets() as $k => $v) 
	{	${$k} = $v;	}

	$sql  = 'INSERT INTO '. $this->_table .' (';

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

function _build_update_sql(&$obj)
{
	foreach ($obj->gets() as $k => $v) 
	{	${$k} = $v;	}

	$sql = 'UPDATE '. $this->_table .' SET ';
	$sql .= 'first_notshow='.intval($first_notshow). ', ';
	$sql .= 'second_show='.intval($second_show).', ';
	$sql .= 'plugin_file='.$this->quote($plugin_file).', ';
	$sql .= 'plugin_func='.$this->quote($plugin_func).', ';
	$sql .= 'aux_int_1='.intval($aux_int_1).', ';
	$sql .= 'aux_int_2='.intval($aux_int_2).', ';
	$sql .= 'aux_text_1='.$this->quote($aux_text_1).', ';
	$sql .= 'aux_text_2='.$this->quote($aux_text_2).' ';
	$sql .= 'WHERE mid='. intval($mid);

	return $sql;
}

//---------------------------------------------------------
// get count
//---------------------------------------------------------
function get_count_by_mid($mid)
{
	$criteria = new CriteriaCompo();
	$criteria->add( new criteria('mid', $mid, '=') );
	$ret = $this->getCount($criteria);
	return $ret;
}

//---------------------------------------------------------
// get object
//---------------------------------------------------------
function &get_by_mid( $mid )
{
	return $this->get_one_by_key_value( 'mid', intval($mid) );
}

//---------------------------------------------------------
// get list
//---------------------------------------------------------
function &get_list_first_notshow()
{
	$criteria = new CriteriaCompo();
	$criteria->add( new criteria('first_notshow', 0, '!=') );
	$ret =& $this->getList($criteria);
	return $ret;
}

function &get_list_second_show()
{
	$criteria = new CriteriaCompo();
	$criteria->add( new criteria('second_show', 0, '!=') );
	$ret =& $this->getList($criteria);
	return $ret;
}

//---------------------------------------------------------
// create table
//---------------------------------------------------------
function create_table()
{
$sql = "
CREATE TABLE ". $this->_table ." (
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
	$ret = $this->query($sql);
	return $ret;
}

function check_version_040()
{
	$ret = $this->existsFieldName( 'plugin_file' );
	return $ret;
}

// --- class end ---
}

// === class end ===
}

?>