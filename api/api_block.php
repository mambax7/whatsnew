<?php
// $Id: api_block.php,v 1.4 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// memory.php

// 2007-10-10 K.OHWADA
// divid from block.new.php

//=========================================================
// What's New Module
// 2007-10-10 K.OHWADA
//=========================================================

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/multibyte.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/sanitize.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/system.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/time.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/error.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/strings.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/date.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/image_size.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/build_cache.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_object.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/basic_handler.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
if( !isset($WHATSNEW_DIRNAME) )
{
	$WHATSNEW_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );
}

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/include/whatsnew_constant.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/include/functions.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_config_basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_module_basic_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_collect_plugins.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_build_block_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_show_block_handler.php';

?>