<?php
// $Id: rebuild_rss.php,v 1.6 2007/10/22 02:46:15 ohwada Exp $

// 2007-10-10 K.OHWADA
// rebuild()

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-09-28 K.OHWADA
// change func.rss.php to class

//=========================================================
// What's New Module
// build and view RSS 
// 2004/08/20 K.OHWADA
//=========================================================

include 'admin_header.php';
include_once WHATSNEW_ROOT_PATH.'/api/api_rss.php';

//=========================================================
// main
//=========================================================
$whatsnew_builder =& whatsnew_rss_builder::getInstance( WHATSNEW_DIRNAME );
$whatsnew_builder->rebuild( 'rss' );
exit();
// --- main end ---

?>