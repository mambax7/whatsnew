<?php
// $Id: index.php,v 1.12 2008/02/16 14:30:13 ohwada Exp $

// 2008-02-16 K.OHWADA
// get_xoops_module_header()

// 2007-11-24 K.OHWADA
// get_measure_detail()

// 2007-11-11 K.OHWADA
// refresh_cache()
// happy_linux_get_memory_usage_mb()
// get_happy_linux_url()

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-25 K.OHWADA
// use whatsnew_constant.php

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH

// 2005-09-28 K.OHWADA
// change index.php to class

//=========================================================
// What's New Module
// 2004/08/20 K.OHWADA
//=========================================================

include 'header.php';

//class
$class_show =& whatsnew_show_main::getInstance( WHATSNEW_DIRNAME );

if ( $class_show->get_op() == 'refresh' )
{
	$class_show->refresh_cache();
	redirect_header( 'index.php', 1, _HAPPY_LINUX_REFRESHED );
	exit();
}

// start
include XOOPS_ROOT_PATH.'/header.php';
$xoopsOption['template_main'] = WHATSNEW_DIRNAME."_index.html";

$xoopsTpl->assign('lang_goto_admin',     _HAPPY_LINUX_GOTO_ADMIN);
$xoopsTpl->assign('dirname',             WHATSNEW_DIRNAME );
$xoopsTpl->assign('xoops_module_header', $class_show->get_xoops_module_header() );
$xoopsTpl->assign('module_name',         $class_show->get_module_name() );
$xoopsTpl->assign('is_module_admin',     $class_show->is_module_admin() );
$xoopsTpl->assign('content',             $class_show->build_main());

$xoopsTpl->assign('happy_linux_url', get_happy_linux_url() );
$xoopsTpl->assign('execution_time',  happy_linux_get_execution_time() );
$xoopsTpl->assign('memory_usage',    happy_linux_get_memory_usage_mb() );
$xoopsTpl->assign('measure_detail',  $class_show->get_measure_detail() );
include XOOPS_ROOT_PATH.'/footer.php';
exit();
?>