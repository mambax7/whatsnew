<?php
// $Id: whatsnew_rss_builder.php,v 1.9 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// whatsnew_collect_plugins

// 2007-10-10 K.OHWADA
// happy_linux_date
// build_block_handler

// 2007-08-01 K.OHWADA
// media rss

// 2007-05-12 K.OHWADA
// module dupulication
// change filename from whatsnew_build_rss.php

// 2006-06-20 K.OHWADA
// REQ 3873: login user can read RSS.
// add is_permit_show() is_use_cache()

// 2006-01-27 K.OHWADA
// REQ 3509: put into spacing in a summary

// 2005-11-16 K.OHWADA
// BUG 3193: error occur in kernel/user.php, if uid is null

// 2005-09-28 K.OHWADA
// change function to class

//=========================================================
// What's New Module
// class RSS builder
// 2004/08/20 K.OHWADA
//=========================================================

//---------------------------------------------------------
// TODO
// when link is null
//---------------------------------------------------------

// === class begin ===
if( !class_exists('whatsnew_rss_builder') ) 
{

//=========================================================
// class whatsnew_rss_builder
//=========================================================
class whatsnew_rss_builder extends happy_linux_build_rss
{

// class
	var $_collect;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_rss_builder( $dirname )
{
	$DIR_XML = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/templates/xml';

	$this->happy_linux_build_rss();
	$this->set_dirname( $dirname );
	$this->set_template_rdf(   $DIR_XML.'/build_rdf.html' );
	$this->set_template_rss(   $DIR_XML.'/build_rss.html' );
	$this->set_template_atom(  $DIR_XML.'/build_atom.html' );
	$this->set_generator(   'XOOPS Whatsnew' );
	$this->set_category(    'Whatsnew' );
	$this->set_title_rdf(   'Whatsnew: RDF Feeds' );
	$this->set_title_rss(   'Whatsnew: RSS Feeds' );
	$this->set_title_atom(  'Whatsnew: ATOM Feeds' );
	$this->set_flag_default_timezone( true );

// class
	$this->_collect =& whatsnew_collect_plugins::getInstance( $dirname );
	$this->set_cache_time_guest( $this->_get_conf('rss_cache_time') );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_rss_builder( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// plublic
//---------------------------------------------------------
function build( $mode )
{
	$this->set_mode( $mode );
	$this->build_rss();
}

function rebuild( $mode )
{
	$this->set_mode( $mode );
	$this->rebuild_rss();
}

function view( $mode )
{
	$this->set_mode( $mode );
	$this->view_rss();
}

//---------------------------------------------------------
// private
//---------------------------------------------------------
function _init_site_info()
{
	$this->set_site_name(         $this->_get_conf('site_name') );
	$this->set_site_url(          $this->_get_conf('site_url') );
	$this->set_site_desc(         $this->_get_conf('site_desc') );
	$this->set_site_tag(          $this->_get_conf('site_tag') );
	$this->set_site_author_name(  $this->_get_conf('site_author') );
	$this->set_site_author_email( $this->_get_conf('site_email') );

	$copyright = $this->build_site_copyright( $this->_get_conf('site_author') );
	$this->set_site_copyright( $copyright );

	if ( $this->_get_conf('site_image_url') )
	{
		$this->set_site_image_url(    $this->_get_conf('site_image_url') );
		$this->set_site_image_width(  $this->_get_conf('site_image_width') );
		$this->set_site_image_height( $this->_get_conf('site_image_height') );
		$this->set_site_image_title(  $this->_get_conf('site_name') );
		$this->set_site_image_link(   $this->_get_conf('site_url') );
	}
}

//-----------------------------------------------
// use class show block
//-----------------------------------------------
function _get_conf($key)
{
	return $this->_collect->_get_conf($key);
}

function &_get_block()
{
	return $this->_collect->collect_rss();
}

//=========================================================
// override into build_rss
//=========================================================
function _init_option()
{
	$this->_init_site_info();
}

function &_get_items()
{
	return $this->_get_block();
}

function _build_common_item( $item )
{
	$mid = '';
	$aid = '';
	if ( isset($item['mod_id']) )  $mid = $item['mod_id'];
	if ( isset($item['id']) )      $aid = $item['id'];

	$entry_id = $this->build_entry_id( $mid, $aid );

// author
// BUG 3193: occure error in kernel/user.php, if uid is null
	$author_name  = '';
	$author_uri   = '';
	$author_email = '';
	if ( isset($item['uid']) && $item['uid'] )
	{
		$uid = intval( $item['uid'] );

		if ( $uid > 0 )
		{
			$user = new xoopsUser( intval($item['uid']) );
			$author_name  = $user->getvar('uname');
			$author_uri   = $user->getvar('url');
			if ( $user->getvar('user_viewemail') )
			{
				$author_email = $user->getvar('email');
			}
		}
	}

// title content 
	$title_xml    = $this->_build_xml_title(   $item['title'] );
	$content_xml  = $this->_build_xml_content( $item['description'] );
	$sum_xml      = $this->_build_xml_summary( $item['description'], 0, 0 );
	$category_xml = $this->_xml( $item['mod_name'] );

// sanitize
	$author_name_xml = $this->_xml( $author_name );

// link
	if ( $item['link'] )
	{
		$link_xml = $this->_xml_url( $item['link'] );
		$guid_xml = $link_xml;
	}
// when link is null
	else
	{
		$link_xml = $this->_xml_url( XOOPS_URL.'/' );
		$guid_xml = $this->_xml( $entry_id );
	}

// time
	if ( isset($item['modified']) )
	{
		$updated_unix = $item['modified'];
	}
	elseif( isset($item['time']) )
	{
		$updated_unix = $item['time'];
	}
	else
	{
		$updated_unix = time();
	}

	if ( isset($item['issued']) )
	{
		$published_unix = $item['issued'];
	}
	else
	{
		$published_unix = $updated_unix;
	}

	$published_rfc822_xml  = $this->_xml( $this->_date_rfc822(  $published_unix ) );
	$updated_rfc822_xml    = $this->_xml( $this->_date_rfc822(  $updated_unix ) );
	$published_iso8601_xml = $this->_xml( $this->_date_iso8601( $published_unix ) );
	$updated_iso8601_xml   = $this->_xml( $this->_date_iso8601( $updated_unix ) );

	$geo_lat  = '';
	$geo_long = '';

	if ( isset($item['geo_lat']) && isset($item['geo_long']) )
	{
		$geo_lat  = $item['geo_lat'];
		$geo_long = $item['geo_long'];
	}

	$content_url      = '';
	$content_width    = '';
	$content_height   = '';
	$content_type     = '';
	$thumbnail_url    = '';
	$thumbnail_width  = '';
	$thumbnail_height = '';

	if ( isset($item['content_url']) )
	{
		$content_url      = $item['content_url'];
		$content_height   = $item['content_height'];
		$content_width    = $item['content_width'];
		$content_type     = $item['content_type'];
	}

	if ( isset($item['thumbnail_url']) )
	{
		$thumbnail_url    = $item['thumbnail_url'];
		$thumbnail_height = $item['thumbnail_height'];
		$thumbnail_width  = $item['thumbnail_width'];
	}

	$ret = array(
		'id'                => $aid,
		'link'              => $link_xml,
		'guid'              => $guid_xml,
		'entry_id'          => $this->_xml( $entry_id ),
		'author_uri'        => $this->_xml_url( $author_uri ),
		'author_email'      => $this->_xml(     $author_email ),
		'author_name'       => $author_name_xml,
		'title'             => $title_xml,
		'summary'           => $sum_xml,
		'description'       => $sum_xml,
		'content'           => $content_xml,
		'category'          => $category_xml,
		'published_unix'    => $published_unix,    // unixtime
		'updated_unix'      => $updated_unix,  // unixtime
		'published_rfc822'  => $published_rfc822_xml,
		'date_rfc822'       => $published_rfc822_xml,
		'updated_rfc822'    => $updated_rfc822_xml,
		'published_iso8601' => $published_iso8601_xml,
		'date_iso8601'      => $published_iso8601_xml,
		'updated_iso8601'   => $updated_iso8601_xml,
		'dc_subject'        => $category_xml,
		'dc_creator'        => $author_name_xml,
		'dc_date'           => $published_iso8601_xml,
		'content_encoded'   => $content_xml,

// georss
		'geo_lat'  => $geo_lat,
		'geo_long' => $geo_long,

// media rss
		'media_content_url'      => $content_url,
		'media_content_height'   => $content_height,
		'media_content_width'    => $content_width,
		'media_content_type'     => $content_type,
		'media_thumbnail_url'    => $thumbnail_url,
		'media_thumbnail_height' => $thumbnail_height,
		'media_thumbnail_width'  => $thumbnail_width,

	);

	return $ret;
}

// --- class end ---
}

// === class end ===
}

?>