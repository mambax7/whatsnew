<?php
// $Id: header.php,v 1.6 2008/02/16 14:30:13 ohwada Exp $

// 2008-02-16 K.OHWADA
// BUG: Fatal error, if not exist happy_linux

// 2007-11-11 K.OHWADA
// api_block.php memory.php

// 2007-08-01 K.OHWADA
// happy_linux/include/sanitize.php

// 2007-05-12 K.OHWADA
// module dupulication

//=========================================================
// What's New Module
// 2007-05-12 K.OHWADA
//=========================================================

//---------------------------------------------------------
// system
//---------------------------------------------------------
include '../../mainfile.php';

include_once XOOPS_ROOT_PATH.'/class/template.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
if( !defined('WHATSNEW_DIRNAME') )
{
	define('WHATSNEW_DIRNAME', $xoopsModule->dirname() );
}

if( !defined('WHATSNEW_ROOT_PATH') )
{
	define('WHATSNEW_ROOT_PATH', XOOPS_ROOT_PATH.'/modules/'.WHATSNEW_DIRNAME );
}

if( !defined('WHATSNEW_URL') )
{
	define('WHATSNEW_URL', XOOPS_URL.'/modules/'.WHATSNEW_DIRNAME );
}

include_once WHATSNEW_ROOT_PATH.'/include/whatsnew_version.php';
include_once WHATSNEW_ROOT_PATH.'/include/whatsnew_constant.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
if ( !file_exists(XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php') ) 
{
	include XOOPS_ROOT_PATH.'/header.php';
	xoops_error( 'require happy_linux module' );
	include XOOPS_ROOT_PATH.'/footer.php';
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php';

// check happy_linux version
if ( HAPPY_LINUX_VERSION < _WHATSNEW_HAPPY_LINUX_VERSION ) 
{
	$msg = 'require happy_linux module v' . _WHATSNEW_HAPPY_LINUX_VERSION . ' or later';
	include XOOPS_ROOT_PATH.'/header.php';
	xoops_error( $msg );
	include XOOPS_ROOT_PATH.'/footer.php';
	exit();
}

// start execution time
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/time.php';
$happy_linux_time =& happy_linux_time::getInstance( true );
if ( WHATSNEW_DEBUG_TIME )
{
	$happy_linux_time->print_lap_time();
}

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once WHATSNEW_ROOT_PATH.'/api/api_block.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/language.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/locate.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/post.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
$XOOPS_LANGUAGE = $xoopsConfig['language'];

include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_build_main.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_show_main.php';

if ( file_exists(WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php') ) 
{
	include_once WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php';
}
else
{
	include_once WHATSNEW_ROOT_PATH.'/language/english/modinfo.php';
}

if ( file_exists(WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/blocks.php') ) 
{
	include_once WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/blocks.php';
}
else
{
	include_once WHATSNEW_ROOT_PATH.'/language/english/blocks.php';
}

// compatible to old version
include_once WHATSNEW_ROOT_PATH.'/language/compatible.php';

?>