<?php
// $Id: whatsnew_build_block_handler.php,v 1.4 2008/10/11 12:32:11 ohwada Exp $

// 2008-10-11 nao-pon
// use guest_name
// http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=867&forum=8

// 2007-12-01 K.OHWADA
// happy_linux_date
// permit

// 2007-10-10 K.OHWADA
// divid from whatsnew_show_block.php

// 2007-08-01 K.OHWADA
// BUG: cannot show HTML entity like &auml; &copy;

// 2007-05-12 K.OHWADA
// module dupulication
// XC 2.1 system comment
// divid to whatsnew_config_basic_handler whatsnew_module_basic_handler
// WHATSNEW_FIELD_PLUGIN -> 'plugin'

// 2006-07-17 K.OHWADA
// BUG 3142: include plugin more than one time

// 2006-06-25 K.OHWADA
// add get_plugins()

// 2006-06-20 K.OHWADA
// assign variable into template: date_m, date_l
// add _get_config()

// 2006-01-27 K.OHWADA
// BUG 3508: Undefined index: description
// REQ 3509: put into spacing in a summary 
//   add fucntion _add_space()

// 2006-01-10 K.OHWADA
// BUG: Undefined offset

// 2005-11-16 K.OHWADA
// REQ 3194: output real user name

// 2005-11-06 K.OHWADA
// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']
// add _html_special_chars_url(), _conv_js()

// 2005-09-28 K.OHWADA
// change block.new.php & func.whatsnew.php to class

//=========================================================
// What's New Module
// class show block
// 2004/08/20 K.OHWADA
//=========================================================
// Hacked by hodaka <hodaka@kuri3.net>
// sort by date, group by module
// 2005/03/11
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_build_block_handler') ) 
{

//=========================================================
// class whatsnew_build_block_handler
//=========================================================
class whatsnew_build_block_handler extends whatsnew_collect_plugins
{
	var $_DIRNAME;
	var $_DIR_MODULE;
	var $_URL_MODULE;
	var $_URL_ICON;
	var $_icon_default;

// class
	var $_image_size;

	var $_module_mod;
	var $_article;

	var $_DEFAULT_NULL  = '-';	// user, hits, replies
	var $_FLAG_IMAGE_FORCE   = true;
	var $_FLAG_BANNER_FORCE  = true;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_build_block_handler( $dirname )
{
	$this->whatsnew_collect_plugins( $dirname );

	$this->_image_size =& happy_linux_image_size::getInstance();
	$this->_date       =& happy_linux_date::getInstance();

	$this->_DIRNAME        = $dirname;
	$this->_URL_MODULE     = XOOPS_URL.'/modules/'.$dirname;
	$this->_DIR_MODULE     = XOOPS_ROOT_PATH.'/modules/'.$dirname;
	$this->_URL_ICON       = $this->_URL_MODULE.'/images/icons';
	$this->_icon_default   = $this->_URL_ICON.'/'.$this->_get_conf('icon_default');

}

//=========================================================
// public
//=========================================================
//---------------------------------------------------------
// sort by date
//---------------------------------------------------------
function &build_block_date()
{
	$this->_init_option_block();
	$article_arr =& $this->collect_permit_date();
	$i   = 0;
	$arr = array();
	foreach ( $article_arr as $article )
	{
		$arr[$i] = $this->_make_block_line( $i, $article );
		$i ++;
	}
	return $arr;
}

//---------------------------------------------------------
// sort by date, group by module
//---------------------------------------------------------
function &build_block_module()
{
	$this->_init_option_block();
	$arr = array();
	$module_arr =& $this->collect_permit_block_module_array();
	foreach ( $module_arr as $module )
	{
		$arr[] = $this->_make_block_module( $module );
	}
	return $arr;
}

// --------------------------------------------------------
// build icon list
// --------------------------------------------------------
function &build_icon_list()
{
	$i   = 0;
	$arr = array();
	$module_arr =& $this->get_module_work_array();

	foreach ($module_arr as $mid => $module)
	{
		list( $mid, $dirname, $mod_name, $mod_title, $mod_link, $mod_icon_link ) = 
			$this->_build_mod_param_permit( $module );

		if ( $mod_icon_link )
		{
			$arr[$i]['mod_title'] = $this->sanitize_text( $mod_title );
			$arr[$i]['mod_link']  = $this->sanitize_url(  $mod_link );
			$arr[$i]['icon_link'] = $this->sanitize_url(  $mod_icon_link );

			$i ++;
		}
	}

	$arr[$i]['mod_title'] = $this->sanitize_text( _WHATSNEW_BLOCK_ETC );
	$arr[$i]['icon_link'] = $this->sanitize_url( $this->_icon_default );

	return $arr;
}

//=========================================================
// private
//=========================================================
//--------------------------------------------------------
// make module
//--------------------------------------------------------
function &_make_block_module( &$module )
{
	list( $mid, $dirname, $mod_name, $mod_title, $mod_link, $mod_icon_link ) = 
		$this->_build_mod_param_permit( $module );

	$mod_arr = array(
		'dirname'       => $this->sanitize_text( $dirname ),
		'mod_name'      => $this->sanitize_text( $mod_name ),
		'mod_title'     => $this->sanitize_text( $mod_title ),
		'mod_link'      => $this->sanitize_url(  $mod_link ),
		'mod_icon_link' => $this->sanitize_url(  $mod_icon_link ),
		'mid'           => $mid,
		'permit'        => $this->_get_mod( 'permit' ),
	);

// lines
	$i = 0;
	foreach ( $module['article_arr'] as $article )
	{
		$mod_arr['lines'][$i] = 
			$this->_make_block_line($i, $article);
		$i ++;
	}

	return $mod_arr;
}

//--------------------------------------------------------
// get value from module
//--------------------------------------------------------
function _build_mod_param_permit( &$module )
{
	$this->_module_mod =& $module['mod'];

	$mid           = intval( $this->_get_mod('mid') );
	$dirname       = $this->_get_mod('dirname');
	$mod_name      = $this->_get_mod('mod_name');
	$mod_title     = $this->_build_mod_title( $mod_name, $dirname, $mid );
	$mod_link      = $this->_build_mod_link_permit( $dirname, $this->_get_mod('permit') );
	$mod_icon_link = $this->_build_mod_icon_link( $this->_get_mod('mod_icon') );

	return array( $mid, $dirname, $mod_name, $mod_title, $mod_link, $mod_icon_link );
}
 
function _build_mod_title( $mod_name, $dirname, $mid )
{
	$title = '';
	if ( $mod_name ) {
		$title = $mod_name;
	} elseif ( $dirname ) {
		$title = $dirname;
	} else {
		$title = 'Module '.$mid;
	}
	return $title;
}

function _build_mod_link_permit( $dirname, $permit )
{
	$link = null;
	if ( $dirname && $this->_has_permit( 'mod_link', $permit ) )
	{
		$link = XOOPS_URL ."/modules/". $dirname ."/";
	}
	return $link;
}

function _build_mod_icon_link( $icon )
{
	$link = $this->_icon_default;
	if ( $icon )
	{
		$link = $this->_URL_ICON ."/". $icon;
	}
	return $link;
}

function _get_mod( $key )
{
	if ( isset($this->_module_mod[$key]) )
	{
		return $this->_module_mod[$key];
	}
	return null;
}

// --------------------------------------------------------
// make line
// --------------------------------------------------------
function &_make_block_line( $num, &$article )
{

	$this->_article =& $article;
	$permit         =  $article['permit'];

// module
	$dirname       = $this->_get_article( 'dirname' );
	$mod_link      = $this->_build_mod_link_permit( $dirname, $permit );
	$mod_icon_link = $this->_build_mod_icon_link( $this->_get_article('mod_icon') );

// image
	list($uid, $uname, $rname)    = $this->_build_line_user_name();
	list($image, $width, $height) = $this->_build_line_image();
	list($banner_url, $banner_width, $banner_height) = $this->_build_line_banner();

// date
	$date         = '';
	$date_s       = '';
	$date_m       = '';
	$date_l       = '';
	$date_mysql   = '';
	$show_today   = false;
	$show_newday  = false;

	$time = intval( $this->_get_article('time') );
	if ( $time )
	{
		$date        = $this->_date->format_timestamp( $time,  $this->_get_option('date_strings') );
		$date_s      = formatTimestamp( $time, 's' );
		$date_m      = formatTimestamp( $time, 'm' );
		$date_l      = formatTimestamp( $time, 'l' );
		$date_mysql  = formatTimestamp( $time, 'mysql');

		if ( $this->_get_option('today') )
		{
			$show_today  = $this->_date->judge_today( $time, $this->_get_conf('today_hours') );
		}
		if ( $this->_get_option('newday') && !$show_today )
		{
			$show_newday = $this->_date->judge_newday( $time, $this->_get_conf('newday_days') );
		}
	}

	$arr = array(
		'dirname'        => $this->sanitize_text( $dirname ),
		'mod_link'       => $this->sanitize_url(  $mod_link ),
		'mod_name'       => $this->sanitize_text( $this->_get_article('mod_name') ),
		'mod_icon_link'  => $this->sanitize_url(  $mod_icon_link ),
		'cat_name'       => $this->sanitize_text( $this->_get_article('cat_name') ),
		'cat_link'       => $this->sanitize_url(  $this->_get_article_permit('cat_link') ),
		'link'           => $this->sanitize_url(  $this->_get_article_permit('link') ),
		'title'          => $this->_build_line_title(),
		'summary'        => $this->_build_line_summary( $num ),
		'content'        => $this->_get_article('description'),
		'uid'            => intval($uid),
		'user'           => $this->sanitize_text( $uname ),
		'user_name'      => $this->sanitize_text( $uname ),
		'real_name'      => $this->sanitize_text( $rname ),
		'show_image'     => $this->_get_option('show_image'),
		'image'          => $this->sanitize_url(  $image ),
		'width'          => intval($width),
		'height'         => intval($height),
		'show_banner'    => $this->_get_option('show_banner'),
		'banner_url'     => $this->sanitize_url( $banner_url ),
		'banner_width'   => intval($banner_width),
		'banner_height'  => intval($banner_height),
		'hits'           => $this->_get_line_int_null( 'hits' ),
		'replies'        => $this->_get_line_int_null( 'replies' ),
		'time'           => $time,
		'date'           => $date,
		'date_s'         => $date_s,
		'date_m'         => $date_m,
		'date_l'         => $date_l,
		'date_mysql'     => $date_mysql,
		'show_today'     => $show_today,
		'show_newday'    => $show_newday,
		'today_strings'  => $this->_get_conf('today_strings'),
		'today_style'    => $this->_get_conf('today_style'),
		'newday_strings' => $this->_get_conf('newday_strings'),
		'newday_style'   => $this->_get_conf('newday_style'),
		'permit'         => $this->_get_article( 'permit' ),
	);

	return $arr;
}

//--------------------------------------------------------
// get value from article
//--------------------------------------------------------
function _get_line_int_null( $key )
{
	$val = $this->_get_article( $key );

	if (( $val === null )||( $val === '' ))
	{	return $this->_DEFAULT_NULL;	}

	return intval( $val );
}

function _get_article_permit( $key )
{
	if ( $this->_has_permit( $key, $this->_get_article( 'permit' ) ) )
	{
		return $this->_get_article( $key );
	}
	return null;
}

function _get_article( $key )
{
	if ( isset($this->_article[$key]) )
	{
		return $this->_article[$key];
	}
	return null;
}

//--------------------------------------------------------
// build
//--------------------------------------------------------
function _build_line_title()
{
	$title = $this->_get_article('title');
	if ( empty($title) )  return '';

	return $this->build_summary( 
		$title, $this->_get_option('max_title')
	);
}

function _build_line_summary( $num )
{
	$desc = $this->_get_article('description');
	$max  = $this->_get_option('max_summary');

	if ( $num >= $this->_get_option('limit_summary') )  return '';
	if ( empty($desc) )                                 return '';

	if ( $this->_get_option('summary_html') && ( strlen($desc) < $max ) )
	{	return $desc;	}

	return $this->build_summary( $desc, $max );
}

function _build_line_image()
{
	$url       = $this->_get_article('image');
	$width_in  = $this->_get_article('width');
	$height_in = $this->_get_article('height');

	$ret = array('', '', '');
	if ( !$this->_get_option('show_image') ) return $ret;
	if ( empty($url) )                       return $ret;

	if ( $width_in && $height_in )
	{
		list($width, $height) = $this->_image_size->adjust_size(
				$width_in, 
				$height_in, 
				$this->_get_conf('image_width'), 
				$this->_get_conf('image_height')
			);
	}
	elseif ($this->_FLAG_IMAGE_FORCE)
	{
		$width  = $this->_get_conf('image_width');
		$height = $this->_get_conf('image_height');
	}

	return array( $url, intval($width), intval($height) );
}

function _build_line_banner()
{
	$url       = $this->_get_article('banner_url');
	$width_in  = $this->_get_article('banner_width');
	$height_in = $this->_get_article('banner_height');

	$ret = array('', '', '');
	if ( !$this->_get_option('show_banner') ) return $ret;
	if ( empty($url) )                        return $ret;

	if ( $width_in && $height_in )
	{
		list($width, $height) = $this->_image_size->adjust_size(
				$width_in, 
				$height_in, 
				$this->_get_conf('banner_width'), 
				$this->_get_conf('banner_height')
			);
	}
	elseif ($this->_FLAG_BANNER_FORCE)
	{
		$width  = $this->_get_conf('banner_width');
		$height = $this->_get_conf('banner_height');
	}

	return array( $url, intval($width), intval($height) );
}

//---------------------------------------------------------
// user name
// REQ 3194: output real user name
// use guest_name
//---------------------------------------------------------
function _build_line_user_name()
{
	$uid_def = '';
	$uname   = $this->_DEFAULT_NULL;
	$rname   = $this->_DEFAULT_NULL;
	$ret     = array($uid_def, $uname, $rname);

	$uid = $this->_get_article('uid');
	$guest_name = $this->_get_article('guest_name');

	if (( $uid === null )||( $uid === '' ))
	{
		return $ret;
	}
	elseif ( $uid == 0 )
	{
		$uid   = 0;
		$uname = ($guest_name) ? $guest_name : $this->_system->get_anonymous();
		$rname = $uname;
	}
	elseif ( $uid )
	{
		$user =& $this->_system->get_user_by_uid( $uid );

		if ( $user['isactive'] )
		{
			$uname = $user['uname'];
			$name  = $user['name'];

			if ($name) {
				$rname = $name;
			} else {
				$rname = $uname;
			}
		}
		else
		{
			$uid   = 0;
			$uname = $this->_system->get_anonymous();
			$rname = $uname;
		}
	}

	return array($uid, $uname, $rname);
}

//--------------------------------------------------------
// strings
//--------------------------------------------------------
function sanitize_text($str)
{
	return $this->_strings->sanitize_text($str);
}

function sanitize_url($str)
{
	return $this->_strings->sanitize_url($str);
}

function build_summary($text, $max, $keyword=null, $format='s')
{
	return $this->_strings->build_summary($text, $max, $keyword, $format);
}

// --- class end ---
}

// === class end ===
}

?>