<?php
// $Id: menu.php,v 1.3 2005/10/22 08:10:52 ohwada Exp $

// 2005-10-01 K.OHWADA
// add menu 2-4

//=========================================================
// What's New Module
// admin menu
// 2004/08/20 K.OHWADA
//=========================================================

$adminmenu[1]['title'] = _MI_WHATSNEW_ADMENU1;
$adminmenu[1]['link']  = "admin/index.php";
$adminmenu[2]['title'] = _MI_WHATSNEW_ADMENU_CONFIG2;
$adminmenu[2]['link']  = "admin/config_2.php";
$adminmenu[3]['title'] = _MI_WHATSNEW_ADMENU_RSS;
$adminmenu[3]['link']  = "admin/manage_rss.php";
$adminmenu[4]['title'] = _MI_WHATSNEW_ADMENU_PING;
$adminmenu[4]['link']  = "admin/send_ping.php";

?>
