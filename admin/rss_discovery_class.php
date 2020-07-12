<?php
// $Id: rss_discovery_class.php,v 1.2 2007/06/08 20:07:15 ohwada Exp $

// 2007-06-01 K.OHWADA
// happy_linux_rss_viewer

// 2007-05-12 K.OHWADA
// move from class/whatsnew_auto_rss.php

// 2005-09-29 K.OHWADA
// change rss_auto.php to class

//=========================================================
// What's New Module
// class RSS auto discovery
// 2005-09-29 K.OHWADA
//=========================================================

//=========================================================
// class whatsnew_rss_discovery
//=========================================================
class whatsnew_rss_discovery
{
	var $_system;
	var $_post;
	var $_remote;
	var $_parser;
	var $_utility;
	var $_viewer;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_rss_discovery()
{
	$TEMPLATE_RDF  = WHATSNEW_ROOT_PATH.'/templates/xml/view_rdf.html';
	$TEMPLATE_RSS  = WHATSNEW_ROOT_PATH.'/templates/xml/view_rss.html';
	$TEMPLATE_ATOM = WHATSNEW_ROOT_PATH.'/templates/xml/view_atom.html';

	$this->MSG_ERR_AUTO = _WHATSNEW_ERROR_RSS_AUTO;
	$this->MSG_ERR_GET  = _WHATSNEW_ERROR_RSS_GET;

	$this->_system  =& happy_linux_system::getInstance();
	$this->_post    =& happy_linux_post::getInstance();
	$this->_remote  =& happy_linux_remote_file::getInstance();
	$this->_parser  =& happy_linux_rss_parser::getInstance();
	$this->_utility =& happy_linux_rss_utility::getInstance();
	$this->_viewer  =& happy_linux_rss_viewer::getInstance();;

	$this->_utility->set_template_rdf(  $TEMPLATE_RDF );
	$this->_utility->set_template_rss(  $TEMPLATE_RSS );
	$this->_utility->set_template_atom( $TEMPLATE_ATOM );
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_rss_discovery();
	}
	return $instance;
}

//---------------------------------------------------------
// init
//---------------------------------------------------------
function init( $mode )
{
	$this->_utility->set_sel_mode( $mode );
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function show()
{
	echo "<hr />\n";

	list($op, $url_html, $url_rss) = $this->get_param();
	$xml_url = $url_rss;

	$this->show_form_html($url_html);

	if ( $op != 'rss' )
	{
// correspondence to allow_url_fopen = off
		$html_data = $this->_remote->read_file($url_html);

		if ($html_data == false)
		{
			$this->show_error_connect($url_html);
			return;
		}

		$xml_url = $this->_utility->get_sel_find_link($html_data, $url_html);
	}

	$this->show_form_rss($xml_url);

	if (empty($xml_url))
	{
		$this->show_error( $this->MSG_ERR_AUTO );
		return;
	}

// correspondence to allow_url_fopen = off
	$xml_data = $this->_remote->read_file($xml_url);

	if ($xml_data == false)
	{
		$this->show_error_connect($xml_url);
		return;
	}

	if (empty($xml_data))
	{
		$this->show_error( $this->MSG_ERR_GET );
		return;
	}

// parse
	$encoding_orig = $this->_utility->find_encoding($xml_data);

	list($xml_converted, $encoding_converted)
		= $this->_utility->convert_to_parse($xml_data, $encoding_orig);

	$parser_obj =& $this->_parser->parse($xml_converted, $encoding_converted, $xml_url);
	if ( !is_object($parser_obj) )
	{
		$msg_arr = $this->_parser->getErrors(false);
		$this->show_error_parse($msg_arr, $xml_data);
		return;
	}

// format
	$this->_viewer->set_content_html( true );
	$this->_viewer->set_max_content(  -1 );
	$data =& $this->_viewer->view_format_sanitize( $parser_obj->get_vars() );

	$this->show_feeds( $data );
}

//---------------------------------------------------------
// function
//---------------------------------------------------------
function get_param()
{
	$op       = $this->_post->get_post('op');
	$url_html = $this->_post->get_post('url_html');
	$url_rss  = $this->_post->get_post('url_rss');

	if ( empty($url_html) && ($op != 'rss') )
	{
		$url_html = XOOPS_URL."/";
	}

	return array($op, $url_html, $url_rss);
}

function get_parse_error()
{
	return $this->class_parser->getErrors(false);
}

//---------------------------------------------------------
// print
//---------------------------------------------------------
function show_form_html($url_html)
{

// BUG 3169: need to sanitaize $_SERVER[PHP_SELF]
// BUG 3402: parse error in whatsnew_auto_base.php
	$self = xoops_getenv("PHP_SELF");

?>
<form action="<?php echo $self; ?>" method="post">
<input type="hidden" name="op" value="html">
HTML URL: <input type="text" name="url_html" value="<?php echo $url_html; ?>" size="100">
<input type="submit" value="<?php echo _WHATSNEW_AUTO; ?>">
</form>
HTML URL: <a href="<?php echo $url_html; ?>" target="_blank"><?php echo $url_html; ?></a><br>
<hr>
<?php

}

function show_form_rss($url_rss)
{
// BUG 3169: need to sanitaize $_SERVER[PHP_SELF]
// BUG 3402: parse error in whatsnew_auto_base.php
	$self = xoops_getenv("PHP_SELF");

?>
<form action="<?php echo $self; ?>" method="post">
<input type="hidden" name="op" value="rss">
RSS URL: <input type="text" name="url_rss" value="<?php echo $url_rss; ?>" size="100">
<input type="submit" value="<?php echo _WHATSNEW_SET; ?>">
</form>
RSS URL: <a href="<?php echo $url_rss; ?>" target="_blank"><?php echo $url_rss; ?></a><br>
<hr>
<?php

}

function show_feeds( &$data )
{
	$tpl = new XoopsTpl();

	$tpl->assign('lang_more', _MORE );
	$tpl->assign( $this->_utility->get_lang_items() );
	$tpl->assign('channel', $data['channel'] );
	$tpl->assign('image',   $data['image'] );

	$items =& $data['items'];
	$count =  count($items);
	for ($i = 0; $i < $count; $i++)
	{
		$tpl->append('items', $items[$i]);
	}

	echo $tpl->fetch( $this->_utility->get_sel_template() );
}


//---------------------------------------------------------
// error
//---------------------------------------------------------
function show_error_connect($url)
{
	$this->show_error(_WHATSNEW_ERROR_CONNCET, $url);
}

function show_error_parse($msg_arr, $data)
{
	$this->show_error(_WHATSNEW_ERROR_PARSE, $msg_arr);

	echo "<pre>-----\n";
	echo htmlspecialchars($data);
	echo "-----</pre>\n";
}

function show_error($title, $msg_arr='')
{
	echo "<h4><font color='red'>$title</font></h4>\n";

	if ( is_array($msg_arr) )
	{
		foreach ($msg_arr as $msg)
		{
			echo "$msg <br />\n";
		}
	}
	elseif ($msg_arr)
	{
		echo "$msg_arr <br />\n";
	}

}

// --- class end ---
}

?>