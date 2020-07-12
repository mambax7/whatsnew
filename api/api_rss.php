<?php
// $Id: api_rss.php,v 1.8 2007/11/26 04:23:48 ohwada Exp $

// 2007-11-24 K.OHWADA
// memory.php

// 2007-10-10 K.OHWADA
// rss_builder.php

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH
// use whatsnew_constant.php

//=========================================================
// What's New Module
// 2005-09-28 K.OHWADA
//=========================================================

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/rss_builder.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/time.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/error.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_handler.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
if( !isset($WHATSNEW_DIRNAME) )
{
	$WHATSNEW_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );
}

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/include/whatsnew_version.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/include/whatsnew_constant.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_config_basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_module_basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_collect_plugins.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_build_block_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_rss_builder.php';

?>