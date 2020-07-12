<?php
// $Id: version.php,v 1.1 2007/11/06 14:52:05 ohwada Exp $

//================================================================
// What's New Module
// 2007-11-05 K.OHWADA
//================================================================

function yomi_new_version() 
{
	$ver = array();

	$ver[1]['version']      = '0.84';
	$ver[1]['file']         = 'yomi_084.inc.php';
	$ver[1]['description']  = 'yomi v0.84';

	$ver[2]['version']      = '0.87';
	$ver[2]['file']         = 'yomi_087.inc.php';
	$ver[2]['description']  = 'yomi v0.87';

	return $ver;
}

?>