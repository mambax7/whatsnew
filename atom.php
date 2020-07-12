<?php
// $Id: atom.php,v 1.5 2007/05/15 05:24:25 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-11-23 K.OHWADA
// BUG 3222: forget to set cache time

// 2005-09-28 K.OHWADA
// change func.atom.php to class

//=========================================================
// What's New Module
// build and view ATOM 
// 2004/08/20 K.OHWADA
//=========================================================

include '../../mainfile.php';
define('WHATSNEW_DIRNAME', $xoopsModule->dirname() );
include_once XOOPS_ROOT_PATH . '/modules/' . WHATSNEW_DIRNAME . '/include/atom.inc.php';
exit();

?>