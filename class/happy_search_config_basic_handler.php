<?php
// $Id: happy_search_config_basic_handler.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $

//================================================================
// Happy Search
// 2007-07-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('happy_search_config_basic_handler') ) 
{

//=========================================================
// class happy_search_config_basic_handler
//=========================================================
class happy_search_config_basic_handler extends happy_linux_basic_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_config_basic_handler( $dirname )
{
	$this->happy_linux_basic_handler( $dirname );

	$this->set_table_name('config');
	$this->set_id_name('conf_id');

// init
	$this->_get_config_data();
}

// --- class end ---
}

// === class end ===
}

?>