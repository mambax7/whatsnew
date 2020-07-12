<?php
// $Id: whatsnew_config_store_handler.php,v 1.2 2007/05/16 09:13:23 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication
// change filename from whatsnew_config_save

// 2006-06-25 K.OHWADA
// small change save()

//================================================================
// What's New Module
// class config save
// 2005-10-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('whatsnew_config_store_handler') ) 
{

//=========================================================
// class whatsnew_config_form
//=========================================================
class whatsnew_config_form extends happy_linux_config_form
{
// class
	var $_build_rss;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_config_form()
{
	$this->happy_linux_config_form();

	$this->_build_rss = happy_linux_build_rss::getInstance();
}

//---------------------------------------------------------
// build config
//---------------------------------------------------------
function build_conf_extra_func( $config )
{
	$formtype  = $config['formtype'];
	$valuetype = $config['valuetype'];
	$name      = $config['name'];
	$value     = $config['value'];
	$options   = $config['options'];
	$value_s   = $this->sanitize_text( $value );

	switch ( $formtype ) 
	{
		case 'extra_site_image_width':
			$ele   = $this->_build_conf_extra_site_image_width( $config );
			break;

		case 'extra_site_image_height':
			$ele   = $this->_build_conf_extra_site_image_height( $config );
			break;

		default:
			$ele   = $this->build_html_input_text( $name, $value_s );
			break;
	}

	return $ele;
}

function _build_conf_extra_site_image_width( $config )
{
	$width = intval( $config['value'] );
	$text  = $width;

	if ( $this->_build_rss->check_site_image_width( $width ) )
	{
		$max   = $this->_build_rss->get_site_image_width_max();
		$text .= $this->_build_conf_extra_site_image_too_big( $max );
	}

	return $text;
}

function _build_conf_extra_site_image_height( $config )
{
	$height = intval( $config['value'] );
	$text   = $height;

	if ( $this->_build_rss->check_site_image_height( $height ) )
	{
		$max   = $this->_build_rss->get_site_image_height_max();
		$text .= $this->_build_conf_extra_site_image_too_big( $max );
	}

	return $text;
}

function _build_conf_extra_site_image_too_big( $max )
{
	$text  =  '<br />'."\n";
	$text .= $this->build_html_red(_HAPPY_LINUX_VIEW_IMAGE_TOO_BIG, '', 'bold');
	$text .=  '<br />'."\n";
	$text .= _HAPPY_LINUX_VIEW_IMAGE_MAX.': '.$max;
	return $text;
}

// --- class end ---
}

//================================================================
// class whatsnew_config_store_handler
//================================================================
class whatsnew_config_store_handler extends happy_linux_config_store_handler
{
// class
	var $_build_rss;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_config_store_handler( $dirname )
{
	$define =& whatsnew_config_define::getInstance( $dirname );
	$this->happy_linux_config_store_handler();
	$this->set_handler('config', $dirname, 'whatsnew');
	$this->set_define( $define );

	$this->_build_rss = happy_linux_build_rss::getInstance();
}

//---------------------------------------------------------
// save config
//---------------------------------------------------------
function save_siteinfo()
{
	$site_url        = $this->_handler->get_value_by_name('site_url');
	$site_image_logo = $this->_handler->get_value_by_name('site_image_logo');

	$site_tag = $this->_build_rss->parse_site_tag( $site_url );
	list($image_url, $image_width, $image_height)
		= $this->_build_rss->get_site_image_size( $site_image_logo );

	$arr = array();
	$arr['site_tag']          = $site_tag;
	$arr['site_image_url']    = $image_url;
	$arr['site_image_width']  = $image_width;
	$arr['site_image_height'] = $image_height;

	foreach ( $arr as $k => $v ) 
	{
		$ret = $this->_handler->update_by_name($k, $v);
		if ( !$ret )
		{
			$this->_set_errors( $this->_handler->getErrors() );
		}
	}

	return $this->returnExistError();
}

// --- class end ---
}

// === class end ===
}

?>