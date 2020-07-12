<?php
// $Id: functions.php,v 1.1 2007/05/15 05:27:24 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication

//=========================================================
// What's New Module
// 2007-05-12 K.OHWADA
//=========================================================

// --- whatsnew_functions begin ---
if( !function_exists( 'whatsnew_get_handler' ) ) 
{

function &whatsnew_get_handler($name=null, $module_dir=null)
{
	$ret =& happy_linux_get_handler($name, $module_dir, 'whatsnew');
	return $ret;
}

}
// --- whatsnew_functions end ---

?>