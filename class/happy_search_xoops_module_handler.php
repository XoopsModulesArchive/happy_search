<?php
// $Id: happy_search_xoops_module_handler.php,v 1.4 2007/11/26 03:33:02 ohwada Exp $

// 2007-11-24 K.OHWADA
// get_objects_isactive_all()

// 2007-07-01 K.OHWADA
// happy_linux_object_handler
// get_list_in_group()

// 2007-05-20 K.OHWADA
// XC 2.1; legacy module

//=========================================================
// Happy Search
// 2007-02-18 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_xoops_module_handler') ) 
{

//=========================================================
// class happy_search_xoops_module_handler
//=========================================================
class happy_search_xoops_module_handler extends happy_linux_object_handler
{
	var $_cached_obj_isactive = null;
	var $_dirname_comment = 'system';

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_xoops_module_handler()
{
	$this->happy_linux_object_handler( '', '', 'mid', 'XoopsModule' );
	$this->_table =  $this->_db->prefix( 'modules' );

	$this->set_debug_db_sql(   HAPPY_SEARCH_DEBUG_SQL );
	$this->set_debug_db_error( HAPPY_SEARCH_DEBUG_ERROR );

	$system =& happy_linux_system::getInstance();

	if ( $system->is_active_legacy_module() ) {
		$this->_dirname_comment = 'legacy';
	} else {
		$this->_dirname_comment = 'system';
	}

}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new happy_search_xoops_module_handler();
	}
	return $instance;
}

//---------------------------------------------------------
// basic function
//---------------------------------------------------------
function &get_cache($id)
{
	if ( isset($this->_cached[ $id ]) ) {
		$obj =& $this->_cached[ $id ];
	} else {
		$obj =& $this->get($id);
		if ( $obj->getVar('dirname') == $this->_dirname_comment ) {
			$obj->setVar( 'name', _HAPPY_SEARCH_SYSTEM_COMMENT );
		}
		$this->_cached[$id] = $obj;
	}
	return $obj;
}

function &get_objects_isactive_cache()
{
	if ( is_array($this->_cached_obj_isactive) ) {
		$objs =& $this->_cached_obj_isactive;
	} else {
		$objs =& $this->get_objects_isactive();
		$this->_cached_obj_isactive =& $objs;
	}
	return $objs;
}

function &get_list_in_group( &$group )
{
	$list   = null;
	$except = null;
	$objs =& $this->get_objects_in_group( $group, $except );
	if ( is_array($objs) ) {
		$list = array_keys($objs);
	}
	return $list;
}

function &get_list_isactive()
{
	$list   = null;
	$objs =& $this->get_objects_isactive_cache();
	if ( is_array($objs) ) {
		$list = array_keys($objs);
	}
	return $list;
}

function &get_objects_in_group( &$group, &$except )
{
	if ( !is_array($group) || (count($group) == 0) )
	{
		$null = null;
		return $null;
	}

	$where = "mid IN ( ". implode(',', $group) ." )";
	if ( is_array($except) && count($except) ) 
	{
		foreach ($except as $mid) 
		{
			$where .= " AND mid <> ".$mid;
		}
	}

	$objs =& $this->get_objects_isactive( $where );
	return $objs;
}

function &get_objects_isactive( $in_where=null )
{
	$where = "isactive = 1";
	$where .= " AND ( hassearch = 1 OR dirname = '".$this->_dirname_comment."' )";

	if ( $in_where ) 
	{
		$where .= " AND ".$in_where;
	}
	$objs =& $this->get_objects_where( $where );
	return $objs;
}

function &get_objects_isactive_all()
{
	$where = "isactive = 1";
	$objs =& $this->get_objects_where( $where );
	return $objs;
}

function &get_objects_where( $where=null )
{
	$sql  = "SELECT * FROM ". $this->_table;
	if ( $where ) 
	{
		$sql .= " WHERE ".$where;
	}
	$sql .= " ORDER BY weight ASC, mid ASC";
	$objs =& $this->get_objects_by_sql($sql);
	return $objs;
}

function &get_objects_by_sql( $sql, $limit=0, $start=0, $id_as_key=true )
{
	$ret = array();

	$result =& $this->query($sql, $limit, $start);
	if (!$result) 
	{	return $ret;	}

	while( $row =& $this->fetchArray($result) ) {

		$obj =& new XoopsModule();
		$obj->assignVars($row);
		if ( $obj->getVar('dirname') == $this->_dirname_comment ) {
			$obj->setVar('name', _HAPPY_SEARCH_SYSTEM_COMMENT );
		}
		if (!$id_as_key) {
			$ret[] =& $obj;
		} else {
			$mid = $row['mid'];
			$this->_cached[ $mid ] =& $obj;
			$ret[ $mid ]           =& $obj;
		}
		unset($obj);
	}

	return $ret;
}

//---------------------------------------------------------
// search function
//---------------------------------------------------------
function &get_search_file_func( &$obj )
{
	$ret = false;
	if ($obj->getVar('hassearch') != 1) {
		return $ret;
	}
	$search =& $obj->getInfo('search');
	if ($obj->getVar('hassearch') != 1 || !isset($search['file']) || !isset($search['func']) || $search['func'] == '' || $search['file'] == '') {
		return $ret;
	}
	$arr = array(
		'file' => 'modules/'.$obj->getVar('dirname').'/'.$search['file'], 
		'func' => $search['func'],
	);
	return $arr;
}

//---------------------------------------------------------
// param
//---------------------------------------------------------
function get_dirname_comment()
{
	return $this->_dirname_comment;
}

// --- class end ---
}

// === class end ===
}

?>