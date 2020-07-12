<?php
// $Id: server.php,v 1.3 2005/10/22 08:15:46 ohwada Exp $

// 2005-10-01 K.OHWADA
// change fucntion to class

// 2005-06-06 K.OHWADA
// English mode

//==========================================================
// weblogUpdates.ping server
// 2004/08/22 K.OHWADA
//==========================================================
// TO DO
// correspond other language code 
//----------------------------------------------------------

$class_server = new Whatsnew_Ping_Server();

// for debug
$class_server->set_flag_log( 1 );
$class_server->set_flag_debug( 0 );

// file name
$class_server->set_file_log(       '../cache/ping.server.log' );
$class_server->set_file_debug_log( '../cache/ping.server.debug.log' );

// for japanese
$class_server->set_encode_user( "EUC-JP" );

// main
$class_server->recieve_response();

exit();
// --- main end ---


//==========================================================
// Whatsnew_Ping_Server
//==========================================================
class Whatsnew_Ping_Server
{
// constant
	var $SERVER_NAME;
	var $FILE_LOG;
	var $FILE_DEBUG_LOG;
	var $ENCODE_USER;

// variable
	var $_flag_log;
	var $_flag_debug;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function Whatsnew_Ping_Server()
{
	$this->set_server_name( 'XOOPS' );
	$this->set_flag_log(0);
	$this->set_flag_debug(0);
	$this->set_file_log('');
	$this->set_file_debug_log('');
	$this->set_encode_user( 'ISO-8859-1' );
}

//---------------------------------------------------------
// main function
//---------------------------------------------------------
function recieve_response()
{
	global $HTTP_RAW_POST_DATA;

	$server = "Server: ". $this->SERVER_NAME;

	header( $server );
	header('Content-Type: text/xml'); // MUST be the 1st line

	if ( $_SERVER["REQUEST_METHOD"] != 'POST' )
	{
		$this->send_fault(1,'request method error');
		return;
	}

	list($ret, $blog_name, $blog_url, $error)
		 = $this->parse_request($HTTP_RAW_POST_DATA);

	if ($ret != 0)
	{
		$this->send_fault(1, $error);
		return;
	}

	$this->send_response(0,'Thanks for the ping.');
	$this->write_log($blog_name, $blog_url);
}

//---------------------------------------------------------
// parse_request
//---------------------------------------------------------
function parse_request($text)
{
	$text = $this->convert_from_utf8($text);

	list ($methodod_name, $blog_name, $blog_url)
		= $this->parse_ping($text);

	if ($methodod_name != 'weblogUpdates.ping')
	{
		return array(1,$blog_name,$blog_url,'unknown method');
	}

	if (empty($blog_name))
	{
		return array(1,$blog_name,$blog_url,'no blog name');
	}

	if (empty($blog_url))
	{
		return array(1,$blog_name,$blog_url,'no blog url');
	}

	return array(0,$blog_name,$blog_url,'');	// OK
}

//---------------------------------------------------------
// ping format
// http://www.xmlrpc.com/weblogsCom
//---------------------------------------------------------
// <methodCall>
//   <methodName>weblogUpdates.ping</methodName>
//   <params>
//     <param>
//       <value>blog_name</value>
//     </param>
//     <param>
//       <value>blog_url</value>
//     </param>
//   </params>
// </methodCall>
//
// some builder add string tag
// <methodCall>
//   <methodName>weblogUpdates.ping</methodName>
//   <params>
//     <param>
//       <value><string>blog_name</string></value>
//     </param>
//     <param>
//       <value><string>blog_url</string></value>
//     </param>
//   </params>
// </methodCall>
//
//---------------------------------------------------------
//   parse ping
//---------------------------------------------------------
function parse_ping($text)
{
	if (preg_match('/<methodName>(.*)<\/methodName>/is', $text, $match1))
	{
		$methodod_name = trim( $match1[1] );
	}

	preg_match_all('/<param>.*?<value>(.*?)<\/value>.*?<\/param>/is', $text, $match2);
	$arr = $match2[1];

	$param_arr = array();

	foreach ($arr as $param)
	{
		$value = trim( $param );
	
		if (preg_match('/<string>(.*)<\/string>/is', $param, $match3))
		{
			$value = trim( $match3[1] );
		}

		$param_arr[] = $value;
	}

	return array($methodod_name, $param_arr[0], $param_arr[1]);
}

//---------------------------------------------------------
//   send_response
//---------------------------------------------------------
function send_response($flerror,$message)
{
	$payload = <<<END_OF_TEXT
<?xml version="1.0" encoding="UTF-8"?>
<methodResponse>
<params>
<param>
<value><struct>
<member><name>flerror</name>
<value><boolean>$flerror</boolean></value>
</member>
<member><name>message</name>
<value><string>$message</string></value>
</member>
</struct></value>
</param>
</params>
</methodResponse>
END_OF_TEXT;

	header('Content-Length: '.strlen($payload));
	echo $payload;

	$this->write_debug($payload);
}

//---------------------------------------------------------
//   send fault response
//---------------------------------------------------------
function send_fault($fault_code,$fault_string)
{
	$payload = <<<END_OF_TEXT
<?xml version="1.0" encoding="UTF-8"?>
<methodResponse>
<fault>
<value>
<struct>
<member>
<name>faultCode</name>
<value><int>$fault_code</int></value>
</member>
<member>
<name>faultString</name>
<value><string>$fault_string</string></value>
</member>
</struct>
</value>
</fault>
</methodResponse>
END_OF_TEXT;

	header('Content-Length: '.strlen($payload));
	echo $payload;

	$this->write_debug($payload);
}

//---------------------------------------------------------
//   write_log
//---------------------------------------------------------
function write_log($blog_name,$blog_url)
{
	if ( !$this->_flag_log ) return;

	$time = time();
	$data = "$time\t$blog_name\t$blog_url\n";

	$fp = fopen($this->FILE_LOG, "a");
	fwrite($fp, $data);
	fclose($fp);
}

//---------------------------------------------------------
//   write debug log
//---------------------------------------------------------
function write_debug($payload)
{
	global $HTTP_RAW_POST_DATA;

	if ( !$this->_flag_debug ) return;

	$today = date("Y/m/d H:i:s");

	$data = '';
	$data .= "\n";
	$data .= "=====\n";
	$data .= "$today \n";
	$data .= "REMOTE_ADDR:    {$_SERVER["SERVER_ADDR"]} \n";
	$data .= "REQUEST_METHOD: {$_SERVER["REQUEST_METHOD"]} \n";
	$data .= "--- ping ---\n";
	$data .= "$HTTP_RAW_POST_DATA\n";
	$data .= "--- response ---\n";
	$data .= "$payload\n";

	$fp = fopen($this->FILE_DEBUG_LOG, "a");
	fwrite($fp, $data);
	fclose($fp);
}

//---------------------------------------------------------
// convert from utf8
//---------------------------------------------------------
function convert_from_utf8($text)
{
	if ( function_exists('mb_convert_encoding') )
	{
		$text = mb_convert_encoding( $text, $this->ENCODE_USER, "UTF-8" );
	}
	else
	{
		$text = utf8_decode($text);
	}

	return $text;
}


//---------------------------------------------------------
// set parameter
//---------------------------------------------------------
function set_server_name($value)
{
	$this->SERVER_NAME = $value;
}

function set_flag_log($value)
{
	$this->_flag_log = intval($value);
}

function set_flag_debug($value)
{
	$this->_flag_debug = intval($value);
}

function set_file_log($value)
{
	$this->FILE_LOG = $value;
}

function set_file_debug_log($value)
{
	$this->FILE_DEBUG_LOG = $value;
}

function set_encode_user($value)
{
	$this->ENCODE_USER = $value;
}

// --- class end ---
}

?>