<?php
// $Id: discovery_atom.php,v 1.1 2007/05/15 05:27:23 ohwada Exp $

// 2007-05-12 K.OHWADA
// move from whatsnew/atom_auto.php

//=========================================================
// What's New Module
// ATOM auto discovery and and view
// 2004-08-22 K.OHWADA
//=========================================================

include 'admin_header_discovery.php';

//=========================================================
// main
//=========================================================
xoops_cp_header();
print_header();
print_menu();
echo "<h4>"._WHATSNEW_ATOM_AUTO."</h4>\n";
$rss_auto =& whatsnew_rss_discovery::getInstance();
$rss_auto->init( 'atom' );
$rss_auto->show();
xoops_cp_footer();
exit();
// --- main end ---

?>