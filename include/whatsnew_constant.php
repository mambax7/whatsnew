<?php
// $Id: whatsnew_constant.php,v 1.3 2007/05/15 05:24:25 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication
// add WHATSNEW_DEBUG_SQL
// remove WHATSNEW_FIELD_PLUGIN

// 2006-06-25 K.OHWADA
// add WHATSNEW_FIELD_PLUGIN

// 2006-06-20 K.OHWADA
// this is new file

//=========================================================
// What's New Module
// 2006-06-20 K.OHWADA
//=========================================================

// --- define begin ---
if( !defined('WHATSNEW_CONSTANT_LOADED') ) 
{

define('WHATSNEW_CONSTANT_LOADED', 1);

// for debug
define('WHATSNEW_DEBUG_SQL',   0 );
define('WHATSNEW_DEBUG_ERROR', 0 );
define('WHATSNEW_DEBUG_TIME',  0 );

}
// --- define end ---

?>