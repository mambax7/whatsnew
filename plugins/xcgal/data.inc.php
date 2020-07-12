<?php 
// $Id: data.inc.php,v 1.1 2007/05/10 08:06:44 ohwada Exp $

// 2007-05-06 K.OHWADA
// add description image

//================================================================
// What's New Module
// get aritciles from module
// for xcgal 2.03 <http://dev.xoops.org/modules/xfmod/project/?xcgal>
// plugin by irmtfan  <http://jadoogaran.org>
//================================================================

function xcgal_new($limit=0, $offset=0)
{
	global $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();

 	$sql = "SELECT p.*, a.aid , a.title as atitle FROM ".$xoopsDB->prefix("xcgal_pictures")." p, ".$xoopsDB->prefix("xcgal_albums")." a WHERE p.aid=a.aid AND p.approved = 1 ORDER BY p.ctime DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$URL_MOD = XOOPS_URL.'/modules/xcgal';
	$DIR_MOD = XOOPS_ROOT_PATH.'/modules/xcgal';

	$ret = array();
	while($row = $xoopsDB->fetchArray($result))
	{
		$pid = $row['pid'];

// description
		$caption  = $row['caption'];
		$dohtml   = 0;
		$dosmiley = 1;
		$doxcode  = 1;
		$doimage  = 1;
		$dobr     = 1;
		$description = 
			$myts->displayTarea($caption, $dohtml, $dosmiley, $doxcode, $doimage, $dobr);

// image
		$file_image = '';
		$url_image  = '';
		$file_path  = $DIR_MOD.'/albums/'.$row['filepath'];
		$url_path   = $URL_MOD.'/albums/'.$row['filepath'];
		$filename   = $row['filename'];
		$file_thumb = $file_path . 'thumb_'.$filename;
		$url_thumb  = $url_path  . 'thumb_'.$filename;
		$file_full  = $file_path . $filename;
		$url_full   = $url_path  . $filename;

		if ( file_exists($file_thumb) )
		{
			$file_image = $file_thumb;
			$url_image  = $url_thumb;
		}
		elseif ( file_exists($file_full) )
		{
			$file_image = $file_full;
			$url_image  = $url_full;
		}

// get image width, height
		$size = getimagesize( $file_image );
		if ($size)
		{
			$width  = intval( $size[0] );
			$height = intval( $size[1] );
		}

		$ret[] = array(
			'link'     => $URL_MOD.'/displayimage.php?pid='.$pid ,
			'cat_link' => $URL_MOD.'/thumbnails.php?album='.$row['aid'] ,
			'title'    => $row['title'] ,
			'cat_name' => $row['atitle'] ,
			'hits'   => $row['hits'] ,
			'time'   => $row['ctime'] ,
			'id'  => $pid ,
			'uid' => $row['owner_id'] ,
			'description' => $description,
			'image'    => $url_image,
			'width'    => $width,
			'height'   => $height,
		) ;
	}
	return $ret;
}

?>