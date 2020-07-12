<?php
// $Id: version.php,v 1.1 2008/11/16 05:34:58 ohwada Exp $

// 2006-06-25 K.OHWADA
// this is new file

//================================================================
// What's New Module
// 2006-06-25 K.OHWADA
//================================================================

function xigg_new_version() 
{
	$ver = array();

	$ver[1]['version']      = '1.00';
	$ver[1]['file']         = 'xigg_100.inc.php';
	$ver[1]['description']  = 'Xigg v1.00';

	$ver[2]['version']      = '1.21';
	$ver[2]['file']         = 'xigg_121.inc.php';
	$ver[2]['description']  = 'Xigg v1.21';

	return $ver;
}

?>