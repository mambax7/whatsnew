<?php
// $Id: whatsnew_ping_handler.php,v 1.2 2008/02/16 14:30:51 ohwada Exp $

// 2008-02-16 K.OHWADA
// $_TIMEOUT_CONNECT 

// 2007-10-10 K.OHWADA
// rename whatsnew_ping to whatsnew_ping_handler
// remove send_ping_cache()

// 2007-05-12 K.OHWADA
// module dupulication
// divid to whatsnew_config_basic_handler

// 2005-09-28 K.OHWADA
// change func.ping.php to class

//=========================================================
// What's New Module
// class send weblog update ping
// 2004/08/20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_ping_handler') ) 
{

//=========================================================
// class whatsnew_ping_handler
//=========================================================
class whatsnew_ping_handler
{
// constant
	var $_DIRNAME;
	var $_FILE_PING;

// class
	var $_weblog;
	var $_config_handler;
	var $_rss_builder;

	var $_conf = array();
	var $_print_level = 0;

	var $_TIMEOUT_CONNECT = 0;	// 30 sec  ( snoopy default )
	var $_TIMEOUT_READ    = 0;	// disable ( snoopy default )

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_ping_handler( $dirname )
{
	$this->_DIRNAME   = $dirname;
	$this->_FILE_PING = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/cache/ping.send.log';

// class
	$this->_weblog         =& happy_linux_weblog_updates::getInstance();
	$this->_config_handler =& whatsnew_config_basic_handler::getInstance( $dirname );
	$this->_rss_builder    =& whatsnew_rss_builder::getInstance( $dirname );

	$this->_conf =& $this->_config_handler->get_conf();
}

//---------------------------------------------------------
// main function
//---------------------------------------------------------
function send_pings()
{
	$this->_rss_builder->clear_all_guest_cache();

	$param = array(
		'site_name'       => $this->_conf['site_name'],
		'site_url'        => $this->_conf['site_url'],
		'ping_servers'    => $this->_conf['ping_servers'],
		'log_level'       => $this->_conf['ping_log'],
		'log_file'        => $this->_FILE_PING,
		'print_level'     => $this->_print_level,
		'timeout_connect' => $this->_TIMEOUT_CONNECT,
		'timeout_read'    => $this->_TIMEOUT_READ,
	);

	$this->_weblog->send_pings_by_param( $param );

	$this->_config_handler->update_config_by_name( 'ping_time', time(), true );
}

function set_print_level($val)
{
	$this->_print_level = intval($val);
}

function get_config_pass()
{
	return $this->_conf['ping_pass'];
}

// --- class end ---
}

// === class end ===
}

?>