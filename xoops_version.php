<?php
// $Id: xoops_version.php,v 1.8 2007/11/14 11:42:40 ohwada Exp $

// 2007-11-11 K.OHWADA
// onInstall, onUpdate
// remove template: pda, bop, icon
// change block template

// 2007-05-12 K.OHWADA
// module dupulication
// remove templates 1-6

// 2005-10-01 K.OHWADA
// add sqlfile tables

// 2005-06-20 K.OHWADA
// add template whatsnew_pda.html
// use version.php

// 2005-06-06 K.OHWADA
// add block b_whatsnew_show_2
// add template whatsnew_rdf.html

//=========================================================
// What's New Module
// 2004/08/20 K.OHWADA
//=========================================================

$WHATSNEW_DIRNAME   = basename( dirname( __FILE__ ) );
$WHATSNEW_ROOT_PATH = XOOPS_ROOT_PATH.'/modules/'.$WHATSNEW_DIRNAME;
$WHATSNEW_URL       = XOOPS_URL.'/modules/'.$WHATSNEW_DIRNAME;

if( ! preg_match( '/^(\D+)(\d*)$/' , $WHATSNEW_DIRNAME , $regs ) )
{	echo ( 'invalid dirname: ' . htmlspecialchars( $WHATSNEW_DIRNAME ) );	}
$WHATSNEW_NUMBER = $regs[2] === '' ? '' : intval( $regs[2] ) ;

if ( $regs[1] == 'whatsnew' )
{
	$name_ext = ' '.$WHATSNEW_NUMBER;
}
else
{
	$name_ext = ':'.$WHATSNEW_DIRNAME;
}

include_once $WHATSNEW_ROOT_PATH.'/include/whatsnew_version.php';

$modversion['name']    = _MI_WHATSNEW_NAME.$name_ext;
$modversion['version'] = _WHATSNEW_VERSION;
$modversion['description'] = _MI_WHATSNEW_DESC;
$modversion['credits']  = '';
$modversion['author']   = 'K.OHWADA';
$modversion['help']     = '';
$modversion['license']  = 'GPL see LICENSE';
$modversion['official'] = 1;
$modversion['image']    = 'images/'.$WHATSNEW_DIRNAME.'_slogo.png';
$modversion['dirname']  = $WHATSNEW_DIRNAME;

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/'.$WHATSNEW_DIRNAME.'.sql';

// -- Tables created by sql file (without prefix!) ---
$modversion['tables'][0] = $WHATSNEW_DIRNAME.'_module';
$modversion['tables'][1] = $WHATSNEW_DIRNAME.'_config';

//Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

// Blocks 
$modversion['blocks'][1]['file'] = 'block.new.php';
$modversion['blocks'][1]['name'] = _MI_WHATSNEW_BNAME1.$name_ext;
$modversion['blocks'][1]['description'] = 'Shows recently articles';
$modversion['blocks'][1]['show_func'] = 'b_whatsnew_show_date';
$modversion['blocks'][1]['edit_func'] = '';
$modversion['blocks'][1]['template']  = $WHATSNEW_DIRNAME.'_block_date.html';
$modversion['blocks'][1]['options']   = $WHATSNEW_DIRNAME;

// sort by date, group by module
$modversion['blocks'][2]['file'] = 'block.new.php';
$modversion['blocks'][2]['name'] = _MI_WHATSNEW_BNAME2.$name_ext;
$modversion['blocks'][2]['description'] = 'Shows recently articles';
$modversion['blocks'][2]['show_func'] = 'b_whatsnew_show_module';
$modversion['blocks'][2]['edit_func'] = '';
$modversion['blocks'][2]['template']  = $WHATSNEW_DIRNAME.'_block_mod.html';
$modversion['blocks'][2]['options']   = $WHATSNEW_DIRNAME;

// BopComments like
$modversion['blocks'][3]['file'] = 'block.new.php';
$modversion['blocks'][3]['name'] = _MI_WHATSNEW_BNAME_BOP.$name_ext;
$modversion['blocks'][3]['description'] = 'Shows recently articles';
$modversion['blocks'][3]['show_func'] = 'b_whatsnew_show_bop';
$modversion['blocks'][3]['edit_func'] = '';
$modversion['blocks'][3]['template']  = $WHATSNEW_DIRNAME.'_block_bop.html';
$modversion['blocks'][3]['options']   = $WHATSNEW_DIRNAME;

// Templates
$modversion['templates'][1]['file'] = $WHATSNEW_DIRNAME.'_index.html';
$modversion['templates'][1]['description'] = '';

// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'oninstall.php';
$modversion['onUpdate']  = 'oninstall.php';

?>