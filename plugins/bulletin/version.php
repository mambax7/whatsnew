<?php
// $Id: version.php,v 1.3 2008/08/22 19:54:34 ohwada Exp $

// 2008-08-14 9darts
// bulletin 2.15

// 2007-10-10 K.OHWADA
// module dupulication

//================================================================
// What's New Module
// 2006-12-20 K.OHWADA
//================================================================

$dirname = basename( dirname( __FILE__ ) ) ;

// --- eval begin ---
eval( '

function '.$dirname.'_new_version()
{
	return bulletin_base_new_version( "'.$dirname.'" );
}

' ) ;
// --- eval end ---

// === bulletin_base_new ===
if( ! function_exists( 'bulletin_base_new_version' ) ) 
{

function bulletin_base_new_version( $dirname ) 
{
	$ver = array();

	$ver[1]['version']      = '1.05';
	$ver[1]['file']         = 'bulletin_105.inc.php';
	$ver[1]['description']  = 'bulletin v1.05';

	$ver[2]['version']      = '2.02';
	$ver[2]['file']         = 'bulletin_202.inc.php';
	$ver[2]['description']  = 'bulletin v2.02';

	$ver[3]['version']      = '2.15';
	$ver[3]['file']         = 'bulletin_215.inc.php';
	$ver[3]['description']  = 'bulletin v2.15';

	return $ver;
}

// === bulletin_base_new ===
}

?>