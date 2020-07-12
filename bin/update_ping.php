<?php
// $Id: update_ping.php,v 1.5 2007/10/22 02:46:15 ohwada Exp $

// 2007-10-10 K.OHWADA
// bin_ping

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-09-28 K.OHWADA
// change function to class

//=========================================================
// What's New Module
// send weblog ping, when new article comes
// this program must be run by Command Line Interface mode
// 2004/08/20 K.OHWADA
//=========================================================

//---------------------------------------------------------
// php -q -f   XOOPS/modules/whatsnew/bin/update_ping.php ???
// wget http://XOOPS/modules/whatsnew/bin/update_ping.php?pass=???
//---------------------------------------------------------

//error_reporting(E_ALL);

// suppress Notice in XOOPS/include/common.php
if ( !isset($_SERVER['REQUEST_METHOD']) )
{
	$_SERVER['REQUEST_METHOD'] = '';
}

include '../../../mainfile.php';

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
$WHATSNEW_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );

global $xoopsConfig;
$xoops_language = $xoopsConfig['language'];

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/api/api_ping.php';

//---------------------------------------------------------
// happy_linux
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/file.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/bin_file.php';
include_once XOOPS_ROOT_PATH.'/modules/happy_linux/class/bin_base.php';

// global.php
if ( file_exists( XOOPS_ROOT_PATH.'/modules/happy_linux/language/'.$xoops_language.'/global.php' ) ) 
{
	include_once XOOPS_ROOT_PATH.'/modules/happy_linux/language/'.$xoops_language.'/global.php';
}
else 
{
	include_once XOOPS_ROOT_PATH.'/modules/happy_linux/language/english/global.php';
}

//---------------------------------------------------------
// whatsnew
//---------------------------------------------------------
include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/bin/bin_ping_class.php';

$ping = new bin_ping( $WHATSNEW_DIRNAME );
$ping->send();

exit();

?>