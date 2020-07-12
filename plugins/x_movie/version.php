<?php
// $Id: version.php,v 1.1 2007/10/06 23:09:05 ohwada Exp $

//================================================================
// What's New Module
// 2007-10-07 K.OHWADA
//================================================================

function x_movie_new_version() 
{
	$ver = array();

	$ver[1]['version']      = '1.70';
	$ver[1]['file']         = 'x_movie_170.inc.php';
	$ver[1]['description']  = 'x_movie v1.70';

	$ver[2]['version']      = '1.70a';
	$ver[2]['file']         = 'x_movie_170a.inc.php';
	$ver[2]['description']  = 'x_movie v1.70a';

	return $ver;
}

?>