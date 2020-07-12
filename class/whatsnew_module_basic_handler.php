<?php
// $Id: whatsnew_module_basic_handler.php,v 1.3 2007/10/25 15:48:46 ohwada Exp $

// 2007-10-10 K.OHWADA
// happy_linux_basic_handler

// 2007-05-12 K.OHWADA
// divid from whatsnew_show_block.php

//=========================================================
// What's New Module
// 2007-05-12 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_module_basic_handler') ) 
{

//=========================================================
// class whatsnew_module_basic_handler
//=========================================================
class whatsnew_module_basic_handler extends happy_linux_basic_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_module_basic_handler( $dirname )
{
	$this->happy_linux_basic_handler( $dirname );
	$this->set_table_name('module');
	$this->set_id_name('mid');

// load config
	$this->_load_once();
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_module_basic_handler( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// load
//---------------------------------------------------------
function _load_once()
{
	if ( !$this->has_cached() )
	{
		$this->set_cached( $this->get_rows( 0, 0, true ) );
	}
}

// --- class end ---
}

// === class end ===
}

?>