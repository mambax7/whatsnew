<?php
// $Id: version.php,v 1.2 2008/10/18 09:11:38 ohwada Exp $

//================================================================
// What's New Module
// 2007-12-21 K.OHWADA
//================================================================

$dirname = basename( dirname( __FILE__ ) ) ;

// --- eval begin ---
eval( '

function '.$dirname.'_new_version()
{
	return d3forum_base_new_version( "'.$dirname.'" );
}

' ) ;
// --- eval end ---

// === d3forum_base_new ===
if( ! function_exists( 'd3forum_base_new_version' ) ) 
{

function d3forum_base_new_version( $dirname ) 
{
	$ver = array();

	$ver[1]['version']      = '0.701';
	$ver[1]['file']         = 'd3forum_070_1.inc.php';
	$ver[1]['description']  = 'd3forum v0.70';

	$ver[2]['version']      = '0.702';
	$ver[2]['file']         = 'd3forum_070_2.inc.php';
	$ver[2]['description']  = 'd3forum v0.70 with permission check';

	$ver[3]['version']      = '0.801';
	$ver[3]['file']         = 'd3forum_080_1.inc.php';
	$ver[3]['description']  = 'd3forum v0.80';

	$ver[4]['version']      = '0.802';
	$ver[4]['file']         = 'd3forum_080_2.inc.php';
	$ver[4]['description']  = 'd3forum v0.80 with permission check';

	return $ver;
}

// === d3forum_base_new ===
}

?>