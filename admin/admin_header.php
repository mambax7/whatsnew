<?php
// $Id: admin_header.php,v 1.12 2008/02/16 14:30:49 ohwada Exp $

// 2008-02-16 K.OHWADA
// BUG: Fatal error, if not exist happy_linux

// 2007-12-01 K.OHWADA
// blocks.php

// 2007-11-11 K.OHWADA
// api_block.php memory.php

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH
// use whatsnew_constant.php, compatible.php

// 20005-11-06 K.OHWADA
// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']

//=========================================================
// What's New Module
// admin header
// 2005-10-01 K.OHWADA
//=========================================================

include '../../../include/cp_header.php';

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

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
if ( !file_exists(XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php') ) 
{
	xoops_cp_header();
	xoops_error( 'require happy_linux module' );
	xoops_cp_footer();
	exit();
}

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/version.php';

// check happy_linux version
if ( HAPPY_LINUX_VERSION < _WHATSNEW_HAPPY_LINUX_VERSION ) 
{
	$msg = 'require happy_linux module v' . _WHATSNEW_HAPPY_LINUX_VERSION . ' or later';
	xoops_cp_header();
	xoops_error( $msg );
	xoops_cp_footer();
	exit();
}

// start execution time
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/time.php';
$happy_linux_time =& happy_linux_time::getInstance();

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once WHATSNEW_ROOT_PATH.'/api/api_block.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/language.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/admin_menu.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/post.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/html.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/form.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/form_lib.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/object_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/module_install.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
$XOOPS_LANGUAGE = $xoopsConfig['language'];

include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_install.php';
include_once WHATSNEW_ROOT_PATH.'/admin/admin_function.php';

if ( file_exists(WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php') ) 
{
	include_once WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/modinfo.php';
}
else
{
	include_once WHATSNEW_ROOT_PATH.'/language/english/modinfo.php';
}

// for main.php
if (file_exists( WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/main.php' )) 
{
	include_once WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/main.php';
}
else
{
	include_once WHATSNEW_ROOT_PATH.'/language/english/main.php';
}

// for blocks.php
if (file_exists( WHATSNEW_ROOT_PATH.'/language/'.$XOOPS_LANGUAGE.'/blocks.php' )) 
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