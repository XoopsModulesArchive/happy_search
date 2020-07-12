<?php
// $Id: happy_search_config_handler.php,v 1.1 2007/07/04 11:07:48 ohwada Exp $

//================================================================
// Happy Search
// this file contain 2 class
//   happy_search_config 
//   happy_search_config_handler
// 2007-07-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('happy_search_config_handler') ) 
{

//================================================================
// class happy_search_config
//================================================================
class happy_search_config extends happy_linux_config_base
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_config()
{
	$this->happy_linux_config_base();
}

// --- class end ---
}

//=========================================================
// class config handler
//=========================================================
class happy_search_config_handler extends happy_linux_config_base_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function happy_search_config_handler( $dirname='happy_search' )
{
	$this->happy_linux_config_base_handler( $dirname, 'config', 'conf_id', 'happy_search_config' );
}

// --- class end ---
}

// === class end ===
}

?>