<?php
// $Id: whatsnew_module_handler.php,v 1.7 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// get_by_mid()
// permit field

// 2007-05-12 K.OHWADA
// module dupulication
// add field plugin
// use happy_linux_object_handler

// 2006-06-20 K.OHWADA
// suppress following messages
//   Notice: Only variable references should be returned by reference
// use WHATSNEW_DEBUG_ERROR

//================================================================
// What's New Module
// this file contain 2 class
//   whatsnew_module_object
//   whatsnew_module_handler
// 2005-10-01 K.OHWADA
//================================================================

//=========================================================
// class whatsnew_module_object
//=========================================================
class whatsnew_module_object extends happy_linux_object
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_module_object()
{
	$this->happy_linux_object();

	$this->initVar('id',          XOBJ_DTYPE_INT, 0, true);
	$this->initVar('mid',         XOBJ_DTYPE_INT, 0, true);
	$this->initVar('dirname',     XOBJ_DTYPE_TXTBOX, null, true, 255);
	$this->initVar('block_show',  XOBJ_DTYPE_INT,   0, true);
	$this->initVar('block_limit', XOBJ_DTYPE_INT,   0, true);
	$this->initVar('rss_show',    XOBJ_DTYPE_INT,   0, true);
	$this->initVar('rss_limit',   XOBJ_DTYPE_INT,   0, true);
	$this->initVar('block_icon',  XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('plugin',      XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('permit',      XOBJ_DTYPE_INT,   0, true);
	$this->initVar('aux_int_1',   XOBJ_DTYPE_INT,   0);
	$this->initVar('aux_int_2',   XOBJ_DTYPE_INT,   0);
	$this->initVar('aux_text_1',  XOBJ_DTYPE_TXTBOX, null, false, 255);
	$this->initVar('aux_text_2',  XOBJ_DTYPE_TXTBOX, null, false, 255);
}

// --- class end ---
}

//=========================================================
// class whatsnew_module_handler
//=========================================================
class whatsnew_module_handler extends happy_linux_object_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_module_handler( $dirname )
{
	$this->happy_linux_object_handler( $dirname, 'module', 'mid', 'whatsnew_module_object' );

	$this->set_debug_db_sql(   WHATSNEW_DEBUG_SQL );
	$this->set_debug_db_error( WHATSNEW_DEBUG_ERROR );
}

//---------------------------------------------------------
// load to cache
//---------------------------------------------------------
function load()
{
	$this->loadCache();
}

//---------------------------------------------------------
// function
//---------------------------------------------------------
function _build_insert_sql( &$obj )
{
	foreach ($obj->gets() as $k => $v) 
	{	${$k} = $v;	}

	$sql  = 'INSERT INTO '.$this->_table.' (';

	$sql .= 'mid, ';
	$sql .= 'dirname, ';
	$sql .= 'block_show, ';
	$sql .= 'block_limit, ';
	$sql .= 'rss_show, ';
	$sql .= 'rss_limit, ';
	$sql .= 'block_icon, ';
	$sql .= 'plugin, ';
	$sql .= 'permit, ';
	$sql .= 'aux_int_1, ';
	$sql .= 'aux_int_2, ';
	$sql .= 'aux_text_1, ';
	$sql .= 'aux_text_2 ';

	$sql .= ') VALUES (';

	$sql .= intval($mid).', ';
	$sql .= $this->quote($dirname).', ';
	$sql .= intval($block_show).', ';
	$sql .= intval($block_limit).', ';
	$sql .= intval($rss_show).', ';
	$sql .= intval($rss_limit).', ';
	$sql .= $this->quote($block_icon).', ';
	$sql .= $this->quote($plugin).', ';
	$sql .= intval($permit).', ';
	$sql .= intval($aux_int_1).', ';
	$sql .= intval($aux_int_2).', ';
	$sql .= $this->quote($aux_text_1).', ';
	$sql .= $this->quote($aux_text_2).' ';

	$sql .= ')';

	return $sql;	
}

function _build_update_sql( &$obj )
{
	foreach ($obj->gets() as $k => $v) 
	{	${$k} = $v;	}

	$sql  = 'UPDATE '.$this->_table.' SET ';

	$sql .= 'dirname='.$this->quote($dirname).', ';
	$sql .= 'block_show='.intval($block_show).', ';
	$sql .= 'block_limit='.intval($block_limit).', ';
	$sql .= 'rss_show='.intval($rss_show).', ';
	$sql .= 'rss_limit='.intval($rss_limit).', ';
	$sql .= 'block_icon='.$this->quote($block_icon).', ';
	$sql .= 'plugin='.$this->quote($plugin).', ';
	$sql .= 'permit='.intval($permit).', ';
	$sql .= 'aux_int_1='.intval($aux_int_1).', ';
	$sql .= 'aux_int_2='.intval($aux_int_2).', ';
	$sql .= 'aux_text_1='.$this->quote($aux_text_1).', ';
	$sql .= 'aux_text_2='.$this->quote($aux_text_2).' ';

	$sql .= 'WHERE mid='.intval($mid);

	return $sql;
}

//---------------------------------------------------------
// get
//---------------------------------------------------------
function &get_by_mid( $mid )
{
	return $this->get_one_by_key_value( 'mid', intval($mid) );
}

function &get_all()
{
	return $this->_module_mid_cache;
}

// --- class end ---
}

?>