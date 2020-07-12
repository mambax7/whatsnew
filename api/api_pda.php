<?php
// $Id: api_pda.php,v 1.6 2007/11/26 04:23:48 ohwada Exp $

// 2007-11-24 K.OHWADA
// memory.php

//=========================================================
// What's New Module
// 2007-10-10 K.OHWADA
//=========================================================

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
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/include/memory.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_build_main.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_pda_builder.php';

?>