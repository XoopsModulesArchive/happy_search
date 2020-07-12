<?php
// $Id: happy_search_xoogle_handler.php,v 1.1.1.1 2006/12/01 12:19:23 ohwada Exp $

//=========================================================
// Happy Search
// this file contain 2 class
//   happy_search_xoogle 
//   happy_search_xoogle_handler
// 2006-11-11 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('happy_search_xoogle_handler') ) 
{

//=========================================================
// class happy_search_xoogle
//=========================================================
class happy_search_xoogle extends happy_linux_object
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_xoogle()
{
	$this->happy_linux_object();

	$this->initVar('xoogleid',    XOBJ_DTYPE_INT, 0, false);
	$this->initVar('google_key',  XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('google_lr',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('lrinblock',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('xoopsactive', XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('sldefault',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('siteactive',  XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('webactive',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('slinblock',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('sitelabel',   XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('weblabel',    XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('xoopslabel',  XOBJ_DTYPE_TXTBOX, null, false, 255);

}

// --- class end ---
}

//=========================================================
// class happy_search_xoogle_handler
//=========================================================
class happy_search_xoogle_handler extends happy_linux_object_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_xoogle_handler( $dirname )
{
	$this->happy_linux_object_handler( $dirname, 'xoogle', 'xoogleid', 'happy_search_xoogle' );

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
	$sql .= 'google_key, ';
	$sql .= 'google_lr, ';
	$sql .= 'lrinblock, ';
	$sql .= 'xoopsactive, ';
	$sql .= 'sldefault, ';
	$sql .= 'siteactive, ';
	$sql .= 'webactive, ';
	$sql .= 'slinblock, ';
	$sql .= 'sitelabel, ';
	$sql .= 'weblabel, ';
	$sql .= 'xoopslabel ';
	$sql .= ') VALUES ( ';
	$sql .= $this->quote($google_key) .', ';
	$sql .= $this->quote($google_lr) .', ';
	$sql .= $this->quote($lrinblock) .', ';
	$sql .= $this->quote($xoopsactive) .', ';
	$sql .= $this->quote($sldefault) .', ';
	$sql .= $this->quote($siteactive) .', ';
	$sql .= $this->quote($webactive) .', ';
	$sql .= $this->quote($slinblock) .', ';
	$sql .= $this->quote($sitelabel) .', ';
	$sql .= $this->quote($weblabel) .', ';
	$sql .= $this->quote($xoopslabel) .' ';
	$sql .= ')';

	return $sql;
}

function _build_update_sql(&$obj)
{
	foreach ($obj->gets() as $k => $v) 
	{	${$k} = $v;	}

	$sql = 'UPDATE '. $this->_table .' SET ';
	$sql .= 'google_key = '.  $this->quote($google_key). ', ';
	$sql .= 'google_lr = '.   $this->quote($google_lr). ', ';
	$sql .= 'lrinblock = '.   $this->quote($lrinblock). ', ';
	$sql .= 'xoopsactive = '. $this->quote($xoopsactive). ', ';
	$sql .= 'sldefault = '.   $this->quote($sldefault). ', ';
	$sql .= 'siteactive = '.  $this->quote($siteactive). ', ';
	$sql .= 'webactive = '.   $this->quote($webactive). ', ';
	$sql .= 'slinblock = '.   $this->quote($slinblock). ', ';
	$sql .= 'sitelabel = '.   $this->quote($sitelabel). ', ';
	$sql .= 'weblabel = '.    $this->quote($weblabel). ', ';
	$sql .= 'xoopslabel = '.  $this->quote($xoopslabel). ' ';
	$sql .= 'WHERE xoogleid='. intval($xoogleid);

	return $sql;
}

//---------------------------------------------------------
// update
//---------------------------------------------------------
function &update_by_global_post()
{
	$obj =& $this->get(1);

	$obj->setVars( $_POST );
	$obj->set_var_checkbox_by_global_post( 'lrinblock' );
	$obj->set_var_checkbox_by_global_post( 'slinblock' );
	$obj->set_var_checkbox_by_global_post( 'siteactive' );
	$obj->set_var_checkbox_by_global_post( 'webactive' );
	$obj->set_var_checkbox_by_global_post( 'xoopsactive' );

	$this->update($obj);
	$config =& $obj->gets();
	return $config;
}

//---------------------------------------------------------
// get config
//---------------------------------------------------------
function &get_config()
{
	$obj    =& $this->get(1);
	$config =& $obj->gets();
	return $config;
}

// --- class end ---
}

// === class end ===
}

?>