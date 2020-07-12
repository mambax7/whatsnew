<?php
// $Id: blocks.php,v 1.4 2007/05/15 05:24:26 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-10-10 K.OHWADA
// for block_bop.html

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_BL_LOADED') ) 
{

define('WHATSNEW_LANG_BL_LOADED', 1);

// not use config file
//define("_WHATSNEW_WARNING_NOT_EXIST","Not exist of config file");

// 2005-10-10
define("_WHATSNEW_BLOCK_MODULE","Module");
define('_WHATSNEW_BLOCK_CATEGORY', 'Category');
define("_WHATSNEW_BLOCK_TITLE","Title");
define("_WHATSNEW_BLOCK_USER","Poster");
define("_WHATSNEW_BLOCK_HITS","Hits");
define("_WHATSNEW_BLOCK_REPLIES","Replies");
define("_WHATSNEW_BLOCK_DATE","Date");
define("_WHATSNEW_BLOCK_ETC","etc");
define("_WHATSNEW_BLOCK_MORE","More...");

}
// --- define language end ---

?>