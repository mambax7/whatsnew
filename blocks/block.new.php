<?php
// $Id: block.new.php,v 1.10 2007/10/25 15:48:46 ohwada Exp $

// 2007-10-10 K.OHWADA
// api_block.php
// b_whatsnew_show_common()

// 2007-08-01 K.OHWADA
// happy_linux/include/sanitize.php

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-25 K.OHWADA
// use whatsnew_constant.php

// 2005-09-28 K.OHWADA
// use class Whatsnew_Show_Block

//=========================================================
// What's New Module
// show new atrcile list 
// 2004/08/20 K.OHWADA
//=========================================================

$WHATSNEW_DIRNAME = basename( dirname( dirname( __FILE__ ) ) );

include_once XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME.'/api/api_block.php';

// === b_whatsnew_show_date_base begin ===
if( !function_exists( 'b_whatsnew_show_date' ) ) 
{

//---------------------------------------------------------
// sort by date
//---------------------------------------------------------
function b_whatsnew_show_date( &$options )
{
	return b_whatsnew_show_common( 'date', $options );
}

function b_whatsnew_show_bop( &$options )
{
	return b_whatsnew_show_common( 'bop', $options );
}

function b_whatsnew_show_module( &$options )
{
	return b_whatsnew_show_common( 'module', $options );
}

function &b_whatsnew_show_common( $mode, &$options )
{
	$DIRNAME = empty( $options[0] ) ? basename( dirname( dirname( __FILE__ ) ) ) : $options[0];
	$show_block_handler =& whatsnew_get_handler('show_block', $DIRNAME);
	return $show_block_handler->show_block( $mode );
}

// === b_whatsnew_show_date_base end ===
}

?>