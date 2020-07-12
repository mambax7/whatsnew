<?php
// $Id: blocks.php,v 1.1 2007/06/08 20:09:24 ohwada Exp $

//=========================================================
// What's New Module
// 2007-06-01 K.OHWADA
//=========================================================

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/admin.php';

//=========================================================
// main
//=========================================================
xoops_cp_header();

$admin =& happy_linux_admin::getInstance();
$admin->print_blocks();

xoops_cp_footer();
exit();
// --- end of main ---

?>