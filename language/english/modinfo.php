<?php
// $Id: modinfo.php,v 1.5 2007/10/22 02:46:16 ohwada Exp $

// 2007-10-10 K.OHWADA
// change slightly

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-10-01 K.OHWADA
// _MI_WHATSNEW_BNAME_BOP

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_MI_LOADED') ) 
{

define('WHATSNEW_LANG_MI_LOADED', 1);

// The name of this module
define("_MI_WHATSNEW_NAME","What's New");

// A brief description of this module
define("_MI_WHATSNEW_DESC","This module collecte all latest reports from two or more modules, and show it in one block");

// Names of blocks for this module (Not all module has blocks)
define("_MI_WHATSNEW_BNAME1","What's New");
define("_MI_WHATSNEW_BNAME2","What's New (Each Module)");

// Admin menu
define("_MI_WHATSNEW_ADMENU1","Configration 1");

// 2005-10-01
define("_MI_WHATSNEW_BNAME_BOP","What's New (BopComments like)");
define("_MI_WHATSNEW_ADMENU_CONFIG2","Configration 2");
define("_MI_WHATSNEW_ADMENU_RSS","RDF/RSS/ATOM Managemant");
define("_MI_WHATSNEW_ADMENU_PING","Ping Managemant");

}
// --- define language end ---

?>