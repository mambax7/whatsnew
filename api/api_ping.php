<?php
// $Id: api_ping.php,v 1.8 2007/11/26 04:23:48 ohwada Exp $

// 2007-11-24 K.OHWADA
// memory.php

// 2007-10-10 K.OHWADA
// api_rss.php

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH

//=========================================================
// What's New Module
// 2005-10-01 K.OHWADA
//=========================================================

//---------------------------------------------------------
// system
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/class/snoopy.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
if( !isset($WHATSNEW_DIRNAME) )
{
	$WHATSNEW_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );
}

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/api/api_rss.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/multibyte.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/system.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/strings.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/image_size.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/weblog_updates.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_ping_handler.php';

?>