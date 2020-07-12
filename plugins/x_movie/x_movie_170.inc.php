<?php
// $Id: x_movie_170.inc.php,v 1.1 2007/10/06 23:09:05 ohwada Exp $

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

	$sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title as ctitle FROM ".$xoopsDB->prefix("x_movie")." l, ".$xoopsDB->prefix("x_movie_text")." t, ".$xoopsDB->prefix("x_movie_cat")." c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";

	$URL_MOD = XOOPS_URL."/modules/x_movie";

	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
		$ret[$i]['link']     = $URL_MOD."/singlemovie.php?lid=".$row['lid'];
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
		$ret[$i]['link'] = XOOPS_URL."/modules/x_movie/singlemovie.php?lid=".$id."";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['date'];
		$i++;
	}

	return $ret;
}

?>