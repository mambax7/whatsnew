<?php
// $Id: whatsnew_show_main.php,v 1.10 2008/02/16 14:30:51 ohwada Exp $

// 2008-02-16 K.OHWADA
// get_xoops_module_header()

// 2007-12-01 K.OHWADA
// get_measure_detail()

// 2007-11-11 K.OHWADA
// divid to whatsnew_build_main.php
// refresh_cache()
// remove happy_linux_locate_factory

// 2007-05-12 K.OHWADA
// module dupulication
// remove measure_time_start()

// 2005-09-29 K.OHWADA
// change index.php & func.whatsnew.php to class

//=========================================================
// What's New Module
// 2004/08/20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_show_main') ) 
{

//=========================================================
// class whatsnew_show_main
//=========================================================
class whatsnew_show_main extends whatsnew_show_block_handler
{
	var $_build;
	var $_post;
	var $_locate;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_show_main( $dirname )
{
	$this->whatsnew_show_block_handler( $dirname );

	$this->_build  =& whatsnew_build_main::getInstance( $dirname );
	$this->_post   =& happy_linux_post::getInstance();
	$this->_locate =& happy_linux_locate_factory::getInstance();
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_show_main( $dirname );
	}
	return $instance;
}

// --------------------------------------------------------
// main function
// --------------------------------------------------------
function build_main()
{
	$this->_MODE_BUILD = 'main';

	$ret = $this->_build_template(
		$this->_get_main_template_file(),
		$this->_get_conf('main_cache_time')
	);	

// send ping
	$this->_send_ping( $this->_get_conf('main_ping') );

	return $ret;
}

function refresh_cache()
{
// login mode
	if ( $this->_xoops_uid > 0 )
	{
		$this->_refresh_parts( 'whatsnew_main_date.html',  true );
		$this->_refresh_parts( 'whatsnew_main_bop.html',   true );
		$this->_refresh_parts( 'whatsnew_blk_date.html',   true );
		$this->_refresh_parts( 'whatsnew_blk_bop.html',    true );
		$this->_refresh_parts( 'whatsnew_blk_module.html', true );
	}

// guest cache
	$this->_refresh_parts( 'whatsnew_main_date.html' );
	$this->_refresh_parts( 'whatsnew_main_bop.html' );
	$this->_refresh_parts( 'whatsnew_blk_date.html' );
	$this->_refresh_parts( 'whatsnew_blk_bop.html' );
	$this->_refresh_parts( 'whatsnew_blk_module.html' );

	$this->_refresh_all_rss();
}

function get_op()
{
	return $this->_post->get_get_text('op');
}

function is_module_admin()
{
	return $this->_system->is_module_admin();
}

function get_module_name( $format='s' )
{
	return $this->_system->get_module_name( $format );
}

// --------------------------------------------------------
// private
// --------------------------------------------------------
function _get_main_template_file()
{
	if ( $this->_get_conf('main_tpl') ) {
		$file = 'whatsnew_main_bop.html';
	} else {
		$file = 'whatsnew_main_date.html';
	}
	return $file;
}

function _refresh_parts( $template_file, $flag=false )
{
	$template = $this->_DIR_MODULE.'/templates/parts/'.$template_file;

	$cache_id = $this->_cache_id_guest;
	if ( $flag )
	{
		$cache_id = $this->_cache_id;
	}

	$this->clear_cache_by_cache_id( $cache_id, $template );
}

function _refresh_all_rss()
{
	include_once $this->_DIR_MODULE.'/api/api_pda.php';

	$rss_builder =& whatsnew_rss_builder::getInstance( $this->_DIRNAME );
	$pda_builder =& whatsnew_pda_builder::getInstance( $this->_DIRNAME );

	$rss_builder->clear_all_guest_cache();
	$pda_builder->clear_all_guest_cache();
}

function _get_welcome()
{
	$uname = '<b>'.$this->_system->get_uname_by_uid( $this->_xoops_uid ).'</b>';
	return sprintf( _HAPPY_LINUX_WELCOME, $uname );
}

//--------------------------------------------------------
// build_main_modules
//--------------------------------------------------------
function &build_main_modules()
{
	return $this->_build->build_main_modules();
}

function get_measure_detail()
{
	return $this->_build->get_measure_detail();
}

function get_xoops_module_header()
{
	$url_css = $this->_URL_MODULE .'/include/whatsnew.css';
	$url_js  = $this->_URL_MODULE .'/include/whatsnew.js';
	$text  = '<link href="'.  $url_css . '" rel="stylesheet" type="text/css" media="all" />'."\n";
	$text .= '<script src="'. $url_js . '" type="text/javascript" ></script>'."\n";
	$text .= $this->_system->get_template_vars('xoops_module_header')."\n";
	return $text;
}

//=========================================================
// override into whatsnew_show_block
//=========================================================
function _assign_main( &$tpl )
{
	$tpl->assign( $this->_make_block_lang() );
	$tpl->assign( 'lang_cached_time', _WHATSNEW_CACHED_TIME );
	$tpl->assign( 'lang_refresh',     _WHATSNEW_REFRESH_CACHE );
	$tpl->assign( 'welcome',     $this->_get_welcome() );
	$tpl->assign( 'cached_time', formatTimestamp( time(), 'l' ) );
	$tpl->assign( 'modules',     $this->build_main_modules() );
}

// --- class end ---
}

// === class end ===
}

?>