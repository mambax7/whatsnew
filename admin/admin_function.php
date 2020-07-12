<?php
// $Id: admin_function.php,v 1.11 2007/11/26 03:21:05 ohwada Exp $

// 2007-11-24 K.OHWADA
// table_manage.php
// print_bread()

// 2007-11-11 K.OHWADA
// happy_linux_admin_menu
// show dirname

// 2007-06-01 K.OHWADA
// blocks.php

// 2007-05-12 K.OHWADA
// module dupulication
// XC2.1 legacy module

// 2006-06-25 K.OHWADA
// add get_get()

//=========================================================
// What's New Module
// admin fucntion
// 2005-10-01 K.OHWADA
//=========================================================

function print_header()
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_header( WHATSNEW_DIRNAME, _MI_WHATSNEW_DESC );
}

function print_footer()
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_footer();
}

function print_powerdby()
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_powerdby();
}

function print_bread( $name1, $url1='', $name2='' )
{
	$menu =& happy_linux_admin_menu::getInstance();
	echo $menu->build_admin_bread_crumb( $name1, $url1, $name2 );
}

function print_menu()
{
	$MAX_COL = 4;

	$menu =& happy_linux_admin_menu::getInstance();

	$file_docs = '/docs/' . $menu->get_xoops_language() . '/index.html';
	if ( file_exists( WHATSNEW_ROOT_PATH.$file_docs ) ) 
	{
		$url_docs = WHATSNEW_URL.$file_docs;
	}
	else
	{
		$url_docs = WHATSNEW_URL.'/docs/english/index.html';
	}

	$menu_arr = array(
		_MI_WHATSNEW_ADMENU1        => 'index.php',
		_MI_WHATSNEW_ADMENU_CONFIG2 => 'config_2.php',
		_MI_WHATSNEW_ADMENU_RSS     => 'manage_rss.php',
		_MI_WHATSNEW_ADMENU_PING    => 'send_ping.php',

		_HAPPY_LINUX_CONF_TABLE_MANAGE => 'table_manage.php',
		_HAPPY_LINUX_AM_MODULE         => 'modules.php',
		_HAPPY_LINUX_AM_BLOCK          => 'blocks.php',
		_WHATSNEW_VIEW_DOCS            => $url_docs,

		_HAPPY_LINUX_GOTO_MODULE       => '../index.php',
	);

	echo $menu->build_menu_table($menu_arr, $MAX_COL);

}

?>