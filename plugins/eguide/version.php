<?php
// $Id: version.php,v 1.1 2007/12/09 00:22:56 ohwada Exp $

//================================================================
// What's New Module
// 2007-12-09 K.OHWADA
//================================================================

function eguide_new_version() 
{
	$ver = array();

	$ver[1]['version']      = '1.72';
	$ver[1]['file']         = 'eguide_172.inc.php';
	$ver[1]['description']  = 'eguide v1.7.2';

	$ver[2]['version']      = '2.30';
	$ver[2]['file']         = 'eguide_230.inc.php';
	$ver[2]['description']  = 'eguide v2.3.0';

	return $ver;
}

?>