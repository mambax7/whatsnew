<?php
// $Id: admin_header_discovery.php,v 1.2 2007/06/08 20:07:15 ohwada Exp $

// 2007-06-01 K.OHWADA
// api/rss_parser.php

// 2007-05-12 K.OHWADA
// module dupulication

//=========================================================
// What's New Module
// 2007-05-12 K.OHWADA
//=========================================================

include 'admin_header.php';

//---------------------------------------------------------
// system
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/class/template.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/rss_parser.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/rss_viewer.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once WHATSNEW_ROOT_PATH.'/admin/rss_discovery_class.php';

?>