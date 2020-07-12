<?php
// $Id: x_movie_170a.inc.php,v 1.2 2007/10/22 02:52:43 ohwada Exp $

// 2007-10-10 K.OHWADA
// banner_url

// 2007-10-07 K.OHWADA
// x_movie v1.70a
// singlemovie.php -> x_movie_view.php

//================================================================
// What's New Module
// get aritciles from module
// for x_movie 1.70 <http://www.rc-net.jp/xoops/>
// 2006-02-03 forum_master <http://www.rc-net.jp/xoops/>
//================================================================

function x_movie_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$sql  = "SELECT l.*, l.title as ltitle, c.title as ctitle , t.description ";
	$sql .= "FROM ".$xoopsDB->prefix("x_movie")." l, ";
	$sql .= $xoopsDB->prefix("x_movie_text")." t, ";
	$sql .= $xoopsDB->prefix("x_movie_cat")." c ";
	$sql .= "WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ";
	$sql .= "ORDER BY l.date DESC";

	$URL_MOD = XOOPS_URL.'/modules/x_movie';

	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
		$ret[$i]['link']     = $URL_MOD."/x_movie_view.php?lid=".$row['lid'];
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];

		$ret[$i]['title'] = $row['ltitle'];
		$ret[$i]['time']  = $row['date'];

// atom feed
		$ret[$i]['id'] = $row['lid'];
		$ret[$i]['description'] = $myts->makeTareaData4Show( $row['description'], 0 );	//no html

// category
		$ret[$i]['cat_name'] = $row['ctitle'];

// counter
		$ret[$i]['hits'] = $row['hits'];

		$ret[$i]['uid'] = $row['submitter'];

// banner
		$logourl = trim($row['logourl']);
		if ( $logourl != '' )
		{
			$file   = XOOPS_ROOT_PATH . str_replace( XOOPS_URL, '', $logourl );
			$width  = 0;
			$height = 0;

			if ( is_file($file) )
			{
				$size = getimagesize( $file ) ;
				if ($size)
				{
					$width  = intval( $size[0] );
					$height = intval( $size[1] );
				}
			}

			$ret[$i]['banner_url']    = $logourl;
			$ret[$i]['banner_width']  = $width;
			$ret[$i]['banner_height'] = $height;
		}

		$i++;
	}

	return $ret;
}

function x_movie_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("x_movie")." WHERE status>0 ORDER BY lid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function x_movie_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT lid, title, date FROM ".$xoopsDB->prefix("x_movie")." WHERE status>0 ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
	    $id = $row['lid'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/x_movie/x_movie_view.php?lid=".$id."";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['date'];
		$i++;
	}

	return $ret;
}

?>