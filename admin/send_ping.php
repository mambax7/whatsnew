<?php
// $Id: send_ping.php,v 1.9 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// change a bit

// 2007-11-01 K.OHWADA
// api_ping.php
// rebuild_pda.php

// 2007-05-12 K.OHWADA
// module dupulication

// 2006-06-20 K.OHWADA
// use constant WHATSNEW_ROOT_PATH

// 2005-09-28 K.OHWADA
// change func.ping.php to class

//=========================================================
// What's New Module
// admin send weblog ping manually 
// 2004/08/20 K.OHWADA
//=========================================================

include_once 'admin_header_config.php';
include_once WHATSNEW_ROOT_PATH.'/api/api_ping.php';

// class
$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();
$ping_handler =& whatsnew_get_handler( 'ping', WHATSNEW_DIRNAME );
$post         =& happy_linux_post::getInstance();

$op    = $post->get_post_text('op');
$print = $post->get_post_int('print', 1);

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
		redirect_header("send_ping.php", 1, _HAPPY_LINUX_UPDATED);
	}
}
else
{
	xoops_cp_header();
}

print_header();
print_menu();
echo "<h4>"._MI_WHATSNEW_ADMENU_PING."</h4>\n";

if ($op == 'ping')
{
	$ping_handler->set_print_level($print);
	$ping_handler->send_pings();

	echo "<h4>"._WHATSNEW_PING_SENDED."</h4>\n";
	echo "<a href='send_ping.php'>"._WHATSNEW_GOTO_MENU_PING."</a><br />\n";
}
else
{
	print_form( $ping_handler->get_config_pass() );

	echo "<h4>"._WHATSNEW_CONFIG_PING."</h4>\n";
	$config_form->set_form_title( _WHATSNEW_CONFIG_PING );
	$config_form->show_by_catid( 10 );

	echo "<h4>"._HAPPY_LINUX_CONF_BIN."</h4>\n";
	echo _HAPPY_LINUX_CONF_BIN_DESC."<br /><br />\n";
	$config_form->set_form_title( _HAPPY_LINUX_CONF_BIN );
	$config_form->show_by_catid( 11 );
}

print_footer();
xoops_cp_footer();
exit();
// --- main end ---


function print_form( $pass )
{

?>
<form action='send_ping.php' method='post'>
<input type='hidden' name='op' value='ping'>
<table class='outer' width='80%' >
<tr class='even' ><td>
<input type='checkbox' name='print' value='2'> <?php echo _WHATSNEW_PING_DETAIL; ?>
</td></tr>
<tr class='foot' ><td>
<input type='submit' value='<?php echo _WHATSNEW_PING; ?>'>
</td></tr></table>
</form>
<br />
<table class='outer' width='80%' >
<tr class='foot' ><td align="left">
<?php echo _HAPPY_LINUX_CONF_TEST_BIN; ?><br />
<a href="<?php echo WHATSNEW_URL; ?>/bin/update_ping.php?pass=<?php echo $pass; ?>" target="_blank">
bin/update_ping.php
</a><br />
</td></tr></table>

<?php

}

?>