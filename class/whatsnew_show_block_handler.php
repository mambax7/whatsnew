<?php
// $Id: whatsnew_show_block_handler.php,v 1.3 2008/10/11 10:30:48 ohwada Exp $

// 2008-10-11 nao-pon
// _get_template_filename()
// http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=866&forum=8

// 2007-12-01 K.OHWADA
// DEBUG_FORCE

// 2007-10-10 K.OHWADA
// rename whatsnew_show_block to whatsnew_show_block_handler
// divid to whatsnew_build_block_handler.php whatsnew_collect_plugins.php
// happy_linux_build_cache

// 2007-08-01 K.OHWADA
// BUG: cannot show HTML entity like &auml; &copy;

// 2007-05-12 K.OHWADA
// module dupulication
// XC 2.1 system comment
// divid to whatsnew_config_basic_handler whatsnew_module_basic_handler
// WHATSNEW_FIELD_PLUGIN -> 'plugin'

// 2006-07-17 K.OHWADA
// BUG 3142: include plugin more than one time

// 2006-06-25 K.OHWADA
// add get_plugins()

// 2006-06-20 K.OHWADA
// assign variable into template: date_m, date_l
// add _get_config()

// 2006-01-27 K.OHWADA
// BUG 3508: Undefined index: description
// REQ 3509: put into spacing in a summary 
//   add fucntion _add_space()

// 2006-01-10 K.OHWADA
// BUG: Undefined offset

// 2005-11-16 K.OHWADA
// REQ 3194: output real user name

// 2005-11-06 K.OHWADA
// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']
// add _html_special_chars_url(), _conv_js()

// 2005-09-28 K.OHWADA
// change block.new.php & func.whatsnew.php to class

//=========================================================
// What's New Module
// class show block
// 2004/08/20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_show_block_handler') ) 
{

//=========================================================
// class whatsnew_show_block_handler
//=========================================================
class whatsnew_show_block_handler extends happy_linux_build_cache
{
	var $_DIRNAME;
	var $_DIR_MODULE;
	var $_URL_MODULE;

	var $_build;
	var $_system;

	var $_xoops_uid = 0;
	var $_cache_id  = null;
	var $_cache_id_guest = null;

	var $_TIME_PROHIBIT = 180;	// 180 sec
	var $_ICON_MAX_COL = 5;
	var $_MODE_BUILD   = 0;

	var $_DEBUG_FORCE  = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_show_block_handler( $dirname )
{
	$this->happy_linux_build_cache();

	$this->_build  =& whatsnew_get_handler('build_block', $dirname );
	$this->_system =& happy_linux_system::getInstance();

	$this->_DIRNAME    = $dirname;
	$this->_URL_MODULE = XOOPS_URL.      '/modules/'.$dirname;
	$this->_DIR_MODULE = XOOPS_ROOT_PATH.'/modules/'.$dirname;

	$this->_xoops_uid = $this->_system->get_uid();

// dirname + uid
	$this->_cache_id       = $dirname.'_u'.$this->_xoops_uid;
	$this->_cache_id_guest = $dirname.'_u0';

}

//=========================================================
// public
//=========================================================
function &show_block( $mode )
{
	$this->_MODE_BUILD = $mode;
	$template_file     = 'whatsnew_blk_'. $mode .'.html';
	$cache_time        = $this->_get_conf('block_cache_time');

	$block =& $this->_make_block_lang();
	$block['dirname'] = $this->_DIRNAME;
	$block['content'] = $this->_build_template( $template_file, $cache_time );

// send ping
	$this->_send_ping( $this->_get_conf('block_ping') );

	return $block;
}

//=========================================================
// private
//=========================================================
//--------------------------------------------------------
// build_template
//--------------------------------------------------------
function _build_template( $template_file, $cache_time )
{
	$template = $this->_get_template_filename( $template_file ) ;
	return $this->build_cache_by_cache_id(
		$this->_cache_id, $template, $cache_time, $this->_DEBUG_FORCE );
}

function _get_template_filename( $template_file )
{
	$theme_set = $GLOBALS['xoopsConfig']['theme_set'] ;

// in XOOPS themes directory
	$template_1 = XOOPS_THEME_PATH . '/' . $theme_set . '/templates/' . $template_file ;

// in templates/parts/theme_set
	$template_2 = $this->_DIR_MODULE.'/templates/parts/'. $theme_set . '/' . $template_file;

// in templates/theme_set
	$template_3 = $this->_DIR_MODULE.'/templates/'. $theme_set . '/' . $template_file;

// in templates/parts (default)
	$template_4 = $this->_DIR_MODULE.'/templates/parts/'. $template_file;

	if ( is_file($template_1) ) {
		return $template_1 ;
	} elseif ( is_file($template_2) ) {
		return $template_2 ;
	} elseif ( is_file($template_3) ) {
		return $template_3 ;
	}
	return $template_4 ;
}

function &_build_template_icon_list()
{
	$template = $this->_DIR_MODULE.'/templates/parts/whatsnew_icon_list.html';

// build template
	$tpl = new XoopsTpl();
	$tpl->assign( 'icon_max_col', $this->_ICON_MAX_COL );
	$tpl->assign( 'icon_list',    $this->build_icon_list() );
	$ret = $tpl->fetch( $template );
	return $ret;
}

//--------------------------------------------------------
// make language
//--------------------------------------------------------
function &_make_block_lang()
{
	$lang = array(
		'lang_mod'     => _WHATSNEW_BLOCK_MODULE,
		'lang_cat'     => _WHATSNEW_BLOCK_CATEGORY,
		'lang_title'   => _WHATSNEW_BLOCK_TITLE,
		'lang_user'    => _WHATSNEW_BLOCK_USER,
		'lang_hits'    => _WHATSNEW_BLOCK_HITS,
		'lang_replies' => _WHATSNEW_BLOCK_REPLIES,
		'lang_date'    => _WHATSNEW_BLOCK_DATE,
		'lang_more'    => _WHATSNEW_BLOCK_MORE,
	);
	return $lang;
}

//--------------------------------------------------------
// build_block
//--------------------------------------------------------
function &build_block_date()
{
	return $this->_build->build_block_date();
}

function &build_block_module()
{
	return $this->_build->build_block_module();
}

function &build_icon_list()
{
	return $this->_build->build_icon_list();
}

function _get_conf($key)
{
	return $this->_build->_get_conf($key);
}

function get_time_latest()
{
	return $this->_build->get_time_latest();
}

//=========================================================
// override into build_cache
//=========================================================
function _assign_cache( &$tpl )
{
	switch ( $this->_MODE_BUILD )
	{
		case 'date':
		case 'bop':
			$this->_assign_date( $tpl );
			break;

		case 'module':
			$this->_assign_module( $tpl );
			break;

		case 'main':
			$this->_assign_main( $tpl );
			break;

		case 'other':
		default:
			$this->_assign_other( $tpl );
			break;
	}
}

function _assign_date( &$tpl )
{
	$tpl->assign('lines',     $this->build_block_date() );
	$tpl->assign('icon_list', $this->_build_template_icon_list() );
	$tpl->assign('dirname',   $this->_DIRNAME );
	$tpl->assign( $this->_make_block_lang() );
}

function _assign_module( &$tpl )
{
	$tpl->assign('modules',   $this->build_block_module() );
	$tpl->assign('dirname',   $this->_DIRNAME );
	$tpl->assign( $this->_make_block_lang() );
}

function _assign_main( &$tpl )
{
	// dummy
}

function _assign_other( &$tpl )
{
	// dummy
}

//=========================================================
// send ping
//=========================================================
function _send_ping( $flag )
{
	if ( !$flag )
	{	return;	}

	if ( ( $this->get_time_latest() - $this->_TIME_PROHIBIT ) > $this->_get_conf('ping_time') )
	{	return;	}

	$this->_refresh_ping();
}

function _refresh_ping()
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$this->_DIRNAME.'/api/api_ping.php';

	$ping =& whatsnew_ping::getInstance( $this->_DIRNAME );
	$ping->send_ping();
}

// --- class end ---
}

// === class end ===
}

?>