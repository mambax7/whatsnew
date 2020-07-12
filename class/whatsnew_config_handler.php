<?php
// $Id: whatsnew_config_handler.php,v 1.5 2007/05/15 05:24:25 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication
// add field conf_valuetype
// use happy_linux_config_base_handler

// 2006-06-20 K.OHWADA
// suppress following messages
//   Warning: Call-time pass-by-reference has been deprecated
//   Notice: Only variable references should be returned by reference
// use WHATSNEW_DEBUG_ERROR

//================================================================
// What's New Module
// this file contain 2 class
//   whatsnew_config 
//   whatsnew_config_handler
// 2005-10-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('whatsnew_config_handler') ) 
{

//================================================================
// class whatsnew_config
// modify form system XoopsConfigItem
//================================================================
class whatsnew_config extends happy_linux_config_base
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_config()
{
	$this->happy_linux_config_base();
}

// --- class end ---
}

//=========================================================
// class config handler
//=========================================================
class whatsnew_config_handler extends happy_linux_config_base_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_config_handler( $dirname )
{
	$this->happy_linux_config_base_handler( $dirname, 'config', 'conf_id', 'whatsnew_config' );

	$this->set_debug_db_sql(   WHATSNEW_DEBUG_SQL );
	$this->set_debug_db_error( WHATSNEW_DEBUG_ERROR );

}

//---------------------------------------------------------
// add_column_table
//---------------------------------------------------------
function check_version_220()
{
	$ret = $this->existsFieldName( 'conf_valuetype' );
	return $ret;
}

function add_column_table_220()
{
$sql = "
  ALTER TABLE ".$this->_table." ADD COLUMN (
  conf_valuetype varchar(255) NOT NULL default ''
)";

	$ret = $this->query($sql);
	return $ret;
}

// --- class end ---
}

// === class end ===
}

?>