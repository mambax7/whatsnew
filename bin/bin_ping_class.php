<?php
// $Id: bin_ping_class.php,v 1.3 2007/10/26 02:59:28 ohwada Exp $

//=========================================================
// What's New Module
// 2007-10-10 K.OHWADA
//=========================================================
class bin_ping extends happy_linux_bin_base
{
// class Instant
	var $_block_handler;
	var $_ping_handler;

// constant
	var $_MAILER = 'XOOPS whatsnew';
	var $_TITLE  = 'ping send';

// send ping, even when it overlaps with modify article. 
	var $_TIME_OVERLAP = 60;	// 60 sec

// debug
	var $_flag_force = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function bin_ping( $dirname )
{
	$this->happy_linux_bin_base( $dirname );

// class Instant
	$this->_block_handler =& whatsnew_get_handler( 'build_block', $dirname );
	$this->_ping_handler  =& whatsnew_get_handler( 'ping',        $dirname );

}

//=========================================================
// public
//=========================================================
function send()
{
	$msg_1 = 'password unmatch';
	$msg_2 = 'ping sended';
	$msg_3 = 'ping not sended: no new article';

	$config_data = $this->_block_handler->get_config_data();
	$ping_pass   = $config_data['ping_pass'];
	$ping_time   = $config_data['ping_time'];

	$this->set_mailer(     $this->_MAILER );
	$this->set_mail_title( $this->_TITLE );
	$this->set_mail_to(    $config_data['bin_mailto'] );
	$this->set_mail_level( $config_data['bin_send'] );

	$this->set_env_param();

	if ( !$this->check_pass($ping_pass) )
	{
		$this->_print_data( $msg_1 );
		$this->_send_mail_content_by_level( $msg_1, 2 );
	}
	else
	{
		$time = $this->_block_handler->get_time_latest_after_collect();

		if ( $this->_flag_force ||( ($time + $this->_TIME_OVERLAP) > $ping_time ) )
		{
			$this->_ping_handler->send_pings();

			$this->_print_data( $msg_2 );
			$this->_send_mail_content_by_level( $msg_2, 1 );
		}
		else
		{
			$this->_print_data( $msg_3 );
			$this->_send_mail_content_by_level( $msg_3, 2 );
		}
	}

	return true;
}

// --- class end ---
}

?>