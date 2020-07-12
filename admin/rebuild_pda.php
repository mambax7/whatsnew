<?php
// $Id: rebuild_pda.php,v 1.5 2007/10/22 02:46:15 ohwada Exp $

// 2007-10-10 K.OHWADA
// rebuild_pda()

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-09-28 K.OHWADA
// change func.pda.php to class

//=========================================================
// What's New Module
// build and view for PDA 
// 2005-06-20 K.OHWADA
//=========================================================

include 'admin_header.php';
include_once WHATSNEW_ROOT_PATH.'/api/api_rss.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_build_main.php';
include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_pda_builder.php';

//=========================================================
// main
//=========================================================
$whatsnew_builder =& whatsnew_pda_builder::getInstance( WHATSNEW_DIRNAME );
$whatsnew_builder->rebuild_pda();
exit();
// --- main end ---


?>