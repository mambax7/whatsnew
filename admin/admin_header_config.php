<?php
// $Id: admin_header_config.php,v 1.4 2007/11/15 11:25:39 ohwada Exp $

// 2007-11-11 K.OHWADA
// api/locate.php

// 2007-05-12 K.OHWADA
// module dupulication

//=========================================================
// What's New Module
// 2007-05-12 K.OHWADA
//=========================================================

include 'admin_header.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/locate.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/rss_builder.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_define_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_base_handler.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/config_store_handler.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_install.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_config_define.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_config_handler.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_config_store_handler.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_module_handler.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_module_store_handler.php';
include_once WHATSNEW_ROOT_PATH.'/admin/admin_config_class.php';

?>