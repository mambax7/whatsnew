<?php
// $Id: version.php,v 1.1 2006/08/07 11:40:40 ohwada Exp $

//================================================================
// What's New Module
// 2006-08-07 K.OHWADA
//================================================================

function wfdownloads_new_version() 
{
	$ver = array();

	$ver[1]['version']      = '3.10';
	$ver[1]['file']         = 'wfdownloads310_data.inc.php';
	$ver[1]['description']  = 'wfdownloads v3.10';

	$ver[2]['version']      = '2.05';
	$ver[2]['file']         = 'wfdownloads205_data.inc.php';
	$ver[2]['description']  = 'wfdownloads v2.05';

	return $ver;
}

?>