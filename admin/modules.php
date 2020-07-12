<?php
// $Id: modules.php,v 1.1 2007/11/26 03:22:14 ohwada Exp $

//=========================================================
// What's New Module
// 2007-11-24 K.OHWADA
//=========================================================

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/admin.php';

//=========================================================
// main
//=========================================================
xoops_cp_header();

$admin =& happy_linux_admin::getInstance();
$admin->print_modules();

xoops_cp_footer();
exit();
// --- end of main ---

?>