<?php
// $Id: index.php,v 1.12 2007/12/02 02:48:03 ohwada Exp $

// 2007-12-01 K.OHWADA
// _AM_WHATSNEW_PERM_DSC

// 2007-11-01 K.OHWADA
// BUG: typo init -> upgrade

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH
// REQ 3873: login user can read RSS.

// 2005-10-01 K.OHWADA
// change index.php to class

//=========================================================
// What's New Module
// admin config
// 2005-10-01 K.OHWADA
//=========================================================

include_once 'admin_header_config.php';

$DIR_CONFIG = WHATSNEW_ROOT_PATH."/cache";

// class
$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();

$op = $config_form->get_post_get_op();

if ($op == 'save')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->save();
		redirect_header("index.php", 2, _HAPPY_LINUX_UPDATED);
	}
}
elseif ($op == 'init')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->init();
		redirect_header("index.php", 2, _HAPPY_LINUX_UPDATED);
	}
}
elseif ($op == 'upgrade')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->upgrade();
		redirect_header("index.php", 2, _HAPPY_LINUX_UPDATED);
	}
}
else
{
	xoops_cp_header();
}

print_header();

if ( !$config_store->check_init() )
{
	$config_form->print_lib_box_init_config();
}
elseif ( !$config_store->check_version() )
{
// BUG: typo init -> upgrade
	$config_form->print_lib_box_upgrade_config( _WHATSNEW_VERSION );
}
else
{
	if ( !is_writable($DIR_CONFIG) )
	{
		xoops_error( _HAPPY_LINUX_CONF_NOT_WRITABLE );
		echo "<br />\n";
		echo "$DIR_CONFIG <br /><br />\n";
	}

	print_menu();
	echo "<h4>"._MI_WHATSNEW_ADMENU1."</h4>\n";
	echo "<h4>"._WHATSNEW_CONFIG_BLOCK."</h4>\n";
	$config_form->show_form();

	echo _AM_WHATSNEW_PERM_DSC."<br />\n";

	echo "<h4>"._WHATSNEW_ICON_LIST."</h4>\n";
	$config_form->show_icon_list();
}

print_footer();
print_powerdby();
xoops_cp_footer();
exit();
// --- main end ---


?>