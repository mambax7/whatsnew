<?php
// $Id: version.php,v 1.3 2007/08/08 09:59:11 ohwada Exp $

// 2007-02-17 K.OHWADA
// multi module

//================================================================
// What's New Module
// 2007-02-12 K.OHWADA
//================================================================

$dirname = basename( dirname( __FILE__ ) ) ;

// --- eval begin ---
eval( '

function '.$dirname.'_new_version()
{
	return weblinks_base_new_version( "'.$dirname.'" );
}

' ) ;
// --- eval end ---

// === weblinks_base_new ===
if( ! function_exists( 'weblinks_base_new_version' ) ) 
{

function weblinks_base_new_version( $dirname ) 
{
	$ver = array();

	$ver[1]['version']      = '1.00';
	$ver[1]['file']         = 'weblinks_100.inc.php';
	$ver[1]['description']  = 'weblinks v0.94 - v1.20';

	$ver[2]['version']      = '1.30';
	$ver[2]['file']         = 'weblinks_130.inc.php';
	$ver[2]['description']  = 'weblinks v1.30';

	$ver[3]['version']      = '1.60';
	$ver[3]['file']         = 'weblinks_160.inc.php';
	$ver[3]['description']  = 'weblinks v1.60';

	return $ver;
}

// === weblinks_base_new ===
}

?>