<?php
// $Id: whatsnew_pda_builder.php,v 1.2 2007/10/22 02:46:16 ohwada Exp $

// 2007-10-10 K.OHWADA
// change template: db -> file

// 2007-05-12 K.OHWADA
// module dupulication
// change filename from whatsnew_build_pda.php

// 2005-09-28 K.OHWADA
// change func.pda.php to class

//=========================================================
// What's New Module
// class template builder for PDA 
// 2005-06-20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_pda_builder') ) 
{

//=========================================================
// class whatsnew_pda_builder
//=========================================================
class whatsnew_pda_builder extends happy_linux_build_rss
{

// class
	var $_build;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_pda_builder( $dirname )
{
	$DIR_XML = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/templates/xml';
	$HEADER  = 'Content-Type:text/html';

	$this->happy_linux_build_rss();
	$this->set_dirname( $dirname );
	$this->set_header_build( $HEADER );
	$this->set_template_other( $DIR_XML.'/build_pda.html' );
	$this->set_title_other( 'WhatsNew PDA' );
	$this->set_mode( 'other' );

// class
	$this->_build =& whatsnew_build_main::getInstance( $dirname );

	$this->set_cache_time( $this->_get_conf('rss_cache_time') );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_pda_builder( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function build_pda()
{
	$this->build_rss();
}

function rebuild_pda()
{
	$this->rebuild_rss();
}

function view_pda()
{
	$this->view_rss();
}

//-----------------------------------------------
// use class build main
//-----------------------------------------------
function _get_conf($key)
{
	return $this->_build->_get_conf($key);
}

function &build_lines()
{
	return $this->_build->build_pda();
}

function sanitize_text($str)
{
	return $this->_build->sanitize_text($str);
}

function sanitize_url($str)
{
	return $this->_build->sanitize_url($str);
}

//=========================================================
// override into build_rss
//=========================================================
function _assign_other( &$tpl )
{
	$tpl->assign('xoops_charset', _CHARSET);
	$tpl->assign('site_url',  $this->sanitize_text( $this->_get_conf('site_url')  ));
	$tpl->assign('site_name', $this->sanitize_text( $this->_get_conf('site_name') ));
	$tpl->assign('site_desc', $this->sanitize_text( $this->_get_conf('site_desc') ));

	if ( $this->_get_conf('image_url') )
	{
		$tpl->assign('image_url', $this->sanitize_url( $this->_get_conf('image_url') ) );
	}

	$tpl->assign('lines', $this->build_lines() );
}

// --- class end ---
}

// === class end ===
}

?>