<?php
// $Id: data.inc.php,v 1.4 2005/10/22 08:37:48 ohwada Exp $

// 2005-06-20 K.OHWADA
// get and set image width & height

//================================================================
// What's New Module
// get aritciles from module
// XoopsGallery 1.252J <http://www.adslnet.org/>
// 2003.12.20 K.OHWADA
//================================================================

function xoopsgallery_new($limit=0, $offset=0)
{
	$GALLERY_BASEDIR = XOOPS_ROOT_PATH.'/modules/xoopsgallery/';
	require_once($GALLERY_BASEDIR . "classes/Album.php");
	require_once($GALLERY_BASEDIR . "classes/Image.php");
	require_once($GALLERY_BASEDIR . "classes/AlbumItem.php");
	require_once($GALLERY_BASEDIR . "classes/AlbumDB.php");

	$image_handler =& xoops_getmodulehandler('image', 'xoopsgallery');
	$criteria = new Criteria('image_type', 'original');
	$criteria->setSort('image_created');
	$criteria->setOrder('DESC'); 
	$criteria->setLimit($limit);
	$images =& $image_handler->getObjects($criteria, true);

	$i = 0;
	$ret = array();

	foreach (array_keys($images) as $j) 
	{
		$ret[$i]['link'] = XOOPS_URL.'/modules/xoopsgallery/view_photo.php?xoops_imageid='.$images[$j]->getVar('image_id').'&amp;set_albumName='.$images[$j]->getVar('image_albumdir').'&amp;id='.$images[$j]->getVar('image_name');
		$ret[$i]['title'] = $images[$j]->getVar('image_name');
		$ret[$i]['time']  = $images[$j]->getVar('image_created');
		$ret[$i]['image'] = $images[$j]->getFullThumbUrl();
		$ret[$i]['description'] = '';

		$file_image = $images[$j]->getFullThumbPath();
		$url_image = '';
		$width     = '';
		$height    = '';

		if( is_file($file_image) )
		{
			$url_image = $images[$j]->getFullThumbUrl();

// get image width, height
			$size = getimagesize( $file_image );

			if ($size)
			{
				$width  = intval( $size[0] );
				$height = intval( $size[1] );
			}

		}

// set image width, height
		$ret[$i]['image']  = $url_image;
		$ret[$i]['width']  = $width;
		$ret[$i]['height'] = $height;

		$i++;
	}

	return $ret;
}

?>