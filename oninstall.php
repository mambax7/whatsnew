<?php
// $Id: oninstall.php,v 1.4 2008/02/16 14:30:13 ohwada Exp $

// 2008-02-16 K.OHWADA
// BUG: Fatal error, if not exist happy_linux

//=========================================================
// What's New Module
// 2007-11-11 K.OHWADA
//=========================================================

$WHATSNEW_DIRNAME = basename( dirname( __FILE__ ) );

global $xoopsConfig;
$XOOPS_LANGUAGE = $xoopsConfig['language'];

// === xoops_module_install_whatsnew ===
// BUG: Fatal error, if not exist happy_linux
// no action here, if not exist
// same process in admin/index.php
if ( file_exists( XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php' ) ) 
{

include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/locate.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/rss_default.php';

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_config_define.php';
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/class/whatsnew_install.php';

// admin.php
if (file_exists( XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/admin.php' )) 
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/language/'.$XOOPS_LANGUAGE.'/admin.php';
}
else
{
	include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/language/english/admin.php';
}

// --- eval begin ---
eval( '

function xoops_module_install_'. $WHATSNEW_DIRNAME .'( $module )
{
	return whatsnew_install_base( "'. $WHATSNEW_DIRNAME .'" ,  $module );
}

function xoops_module_update_'. $WHATSNEW_DIRNAME .'( $module, $prev_version )
{
	return whatsnew_update_base( "'. $WHATSNEW_DIRNAME .'" ,  $module, $prev_version );
}

' );
// --- eval end ---

}
// === xoops_module_install_whatsnew end ===

// === whatsnew_oninstall_base ===
if( ! function_exists( 'whatsnew_install_base' ) ) 
{

function whatsnew_install_base( $DIRNAME, $module )
{

// prepare for message
	global $ret ; // TODO :-D

// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) 
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleInstall.' . ucfirst($DIRNAME) . '.Success' , 'whatsnew_message_append_oninstall' ) ;
		$ret = array() ;
	}
	else 
	{
		if( ! is_array( $ret ) ) $ret = array() ;
	}

// main
	$whatsnew =& whatsnew_install::getInstance( $DIRNAME );
	$code = $whatsnew->install();
	$ret[] = $whatsnew->get_message();

	return $code;
}

function whatsnew_update_base( $DIRNAME, $module, $prev_version )
{
	if ( !file_exists( XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php' ) ) 
	{
		xoops_error('require happy_linux module');
		return false;
	}

// prepare for message
	global $msgs ; // TODO :-D

// for Cube 2.1
	if( defined( 'XOOPS_CUBE_LEGACY' ) ) 
	{
		$root =& XCube_Root::getSingleton();
		$root->mDelegateManager->add( 'Legacy.Admin.Event.ModuleUpdate.' . ucfirst($DIRNAME) . '.Success', 'whatsnew_message_append_onupdate' ) ;
		$msgs = array() ;
	}
	else 
	{
		if( ! is_array( $msgs ) ) $msgs = array() ;
	}

// main
	$whatsnew =& whatsnew_install::getInstance( $DIRNAME );
	$code = $whatsnew->update();
	$msgs[] = $whatsnew->get_message();

	return $code;
}

// for Cube 2.1
function whatsnew_message_append_oninstall( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['ret'] ) ) {
		foreach( $GLOBALS['ret'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

// for Cube 2.1
function whatsnew_message_append_onupdate( &$module_obj , &$log )
{
	if( is_array( @$GLOBALS['msgs'] ) ) {
		foreach( $GLOBALS['msgs'] as $message ) {
			$log->add( strip_tags( $message ) ) ;
		}
	}

	// use mLog->addWarning() or mLog->addError() if necessary
}

// === whatsnew_oninstall_base end ===
}

?>