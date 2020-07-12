<?php
// $Id: rdf.php,v 1.4 2007/05/15 05:24:25 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-09-28 K.OHWADA
// change func.rdf.php to class

//=========================================================
// What's New Module
// build and view RDF 
// http://www.hoshiba-farm.com/
// 2005.05.12 hoshiyan
//=========================================================

include '../../mainfile.php';
define('WHATSNEW_DIRNAME', $xoopsModule->dirname() );
include_once XOOPS_ROOT_PATH . '/modules/' . WHATSNEW_DIRNAME . '/include/rdf.inc.php';
exit();

?>