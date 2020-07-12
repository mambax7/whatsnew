<?php
// $Id: data.inc.php,v 1.7 2007/12/22 10:07:41 ohwada Exp $

// 2007-12-21 K.OHWADA
// show substitute icon

// 2007-08-01 K.OHWADA
// media rss

// 2006-11-18 K.OHWADA
// add myalbum_new_base()
// BUG 4377: bbcode is showing without rendering

// 2005-10-01 K.OHWADA
// category, counter

// 2005-06-20 K.OHWADA
// get and set image width, height

// 2005-06-06 K.OHWADA
// small change for plugin.

//================================================================
// What's New Module
// get aritciles from module
// for myAlbum-P 2.84  <http://www.peak.ne.jp/xoops/>
// 2004-11-26 cinnamons <http://www.cinnamons.jp>
//================================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( 'invalid dirname: ' . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// --- eval begin ---
eval( '

function myalbum'.$mydirnumber.'_new( $limit=0, $offset=0)
{
	return myalbum_new_base( "'.$mydirname.'" , "'.$mydirnumber.'" , $limit, $offset );
}

' ) ;
// --- eval end ---

// --- myalbum_new_base begin ---
if( ! function_exists( 'myalbum_new_base' ) ) 
{

function myalbum_new_base($mydirname, $mydirnumber, $limit=0, $offset=0)
{
	$SHOW_SUBSTITUTE = false;

	global $xoopsDB ;
	$myts =& MyTextSanitizer::getInstance();

	$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;
	$MOD_URL  = XOOPS_URL       .'/modules/'. $mydirname;

//	setting $table_photos, $table_cat, $thumbs_dir
	include $MOD_PATH .'/include/read_configs.php';

	$sql = "SELECT p.lid, p.cid, p.title as ptitle, p.ext, p.hits, p.submitter, p.date, t.description, c.title as ctitle FROM $table_photos p, $table_text t, $table_cat c WHERE t.lid=p.lid AND p.cid=c.cid AND p.status>0 ORDER BY p.date DESC";

	$result = $xoopsDB->query( $sql , $limit , $offset ) ;
	$ret = array() ;

	while( $row = $xoopsDB->fetchArray($result) ) 
	{
		$lid  = $row['lid'];
		$ext  = $row['ext'];
		$file = $lid.'.'.$ext;

		$photo_path      = $photos_dir.'/'.$file;
		$photo_url       = $photos_url.'/'.$file;
		$thumb_path      = $thumbs_dir.'/'.$file;
		$thumb_url       = $thumbs_url.'/'.$file;
		$substitute_url  = $MOD_URL  .'/icons/'. $ext .'.gif';
		$substitute_path = $MOD_PATH .'/icons/'. $ext .'.gif';

		$image            = '';
		$width            = '';
		$height           = '';

// media rss
		$content_url      = '';
		$content_width    = 0;
		$content_height   = 0;
		$content_type     = '';
		$thumbnail_url    = '';
		$thumbnail_width  = 0;
		$thumbnail_height = 0;

		if ( file_exists( $photo_path ) )
		{
			$content_url = $photo_url;

			$size = getimagesize( $photo_path ) ;
			if ($size)
			{
				$content_width  = intval( $size[0] );
				$content_height = intval( $size[1] );
				$content_type   = $size['mime'];
			}
		}

		if ( file_exists( $thumb_path ) )
		{
			$thumbnail_url = $thumb_url;

			$size = getimagesize( $thumb_path ) ;
			if ($size)
			{
				$thumbnail_width  = intval( $size[0] );
				$thumbnail_height = intval( $size[1] );
			}

			$image  = $thumbnail_url;
			$width  = $thumbnail_width;
			$height = $thumbnail_height;

		}

// show substitute icon
		elseif ( $SHOW_SUBSTITUTE && file_exists( $substitute_path ) )
		{
			$image = $substitute_url;

			$size = getimagesize( $substitute_path ) ;
			if ($size)
			{
				$width  = intval( $size[0] );
				$height = intval( $size[1] );
			}
		}

// BUG 4377: bbcode is showing without rendering
		$desc = $myts->displayTarea($row['description'], 0, 1, 1, 1, 1);

		$ret[] = array(
			'link'     => $MOD_URL .'/photo.php?lid='. $lid ,
			'cat_link' => $MOD_URL .'/viewcat.php?cid='. $row['cid'] ,
			'title'    => $row['ptitle'] ,
			'cat_name' => $row['ctitle'] ,
			'hits'     => $row['hits'] ,
			'time'     => $row['date'] ,
			'id'       => $lid ,
			'uid'      => $row['submitter'] ,
			'description' => $desc,

			'image'    => $image,
			'width'    => $width,
			'height'   => $height,

// media rss
			'content_url'      => $content_url,
			'content_width'    => $content_width,
			'content_height'   => $content_height,
			'content_type'     => $content_type,
			'thumbnail_url'    => $thumbnail_url,
			'thumbnail_width'  => $thumbnail_width,
			'thumbnail_height' => $thumbnail_height,
		) ;
	}

	return $ret;
}

}
// --- myalbum_new_base end ---

?>