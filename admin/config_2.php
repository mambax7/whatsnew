<?php
// $Id: config_2.php,v 1.9 2007/12/02 02:48:03 ohwada Exp $

// 2007-12-01 K.OHWADA
// _AM_WHATSNEW_CONFIG_VIEW

// 2007-11-01 K.OHWADA
// conf bin
// print_footer()

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// REQ 3873: login user can read RSS.

// 2005-10-01 K.OHWADA
// change index.php to class

//=========================================================
// What's New Module
// admin config
// 2005-10-01 K.OHWADA
//=========================================================

include_once 'admin_header_config.php';

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
		redirect_header("config_2.php", 1, _HAPPY_LINUX_UPDATED);
	}
}
elseif ($op == 'template_compiled_clear')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->template_compiled_clear();
		redirect_header("config_2.php", 1, _HAPPY_LINUX_CLEARED );
	}
}
else
{
	xoops_cp_header();
}

print_header();
print_menu();
echo "<h4>"._MI_WHATSNEW_ADMENU_CONFIG2."</h4>\n";
$config_form->set_submit_value( _HAPPY_LINUX_UPDATE );

echo "<h4>"._AM_WHATSNEW_CONFIG_VIEW."</h4>\n";
$config_form->set_form_title( _AM_WHATSNEW_CONFIG_VIEW );
$config_form->show_by_catid( 2 );

echo "<h4>"._AM_WHATSNEW_CONFIG_MAIN_BLOCK."</h4>\n";
$config_form->show_form_main_block();

echo "<h4>"._AM_WHATSNEW_CONFIG_PERM."</h4>\n";
echo _AM_WHATSNEW_CONFIG_PERM_DSC."<br /><br />\n";
$config_form->set_form_title( _AM_WHATSNEW_CONFIG_PERM );
$config_form->show_by_catid( 12 );

echo "<h4>"._HAPPY_LINUX_CONF_TPL_COMPILED_CLEAR."</h4>\n";
$config_form->show_form_template_compiled_clear( _HAPPY_LINUX_CONF_TPL_COMPILED_CLEAR );

print_footer();
xoops_cp_footer();
exit();
// --- main end ---

?>