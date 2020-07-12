<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// category, counter

// 2005-03-28 K.OHWADA
// bug fix: forget to declare $myts

// 2004/08/20 K.OHWADA
// atom feed

//================================================================
// What's New Module
// get aritciles from module
// for mylinks 1.10 <http://www.xoops.org/>
// 2003.12.20 K.OHWADA
//================================================================

function mylinks_new($limit=0, $offset=0)
{
	global $xoopsDB;

// bug fix: forget to declare $myts
	$myts =& MyTextSanitizer::getInstance();

//	$sql = "SELECT l.lid, l.title, l.date, t.description FROM ".$xoopsDB->prefix("mylinks_links")." l LEFT JOIN ".$xoopsDB->prefix("mylinks_text")." t ON t.lid=l.lid WHERE status>0 ORDER BY l.date DESC";

	$sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.title as ctitle FROM ".$xoopsDB->prefix("mylinks_links")." l, ".$xoopsDB->prefix("mylinks_text")." t, ".$xoopsDB->prefix("mylinks_cat")." c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";

	$URL_MOD = XOOPS_URL."/modules/mylinks";

	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
		$ret[$i]['link']     = $URL_MOD."/singlelink.php?lid=".$row['lid'];
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];

		$ret[$i]['title'] = $row['ltitle'];
		$ret[$i]['time']  = $row['date'];
//		$ret[$i]['description'] = $row['description'];

// atom feed
		$ret[$i]['id'] = $row['lid'];
		$ret[$i]['description'] = $myts->makeTareaData4Show( $row['description'], 0 );	//no html

// category
		$ret[$i]['cat_name'] = $row['ctitle'];

// counter
		$ret[$i]['hits'] = $row['hits'];

// this module dont show user name
//		$ret[$i]['uid'] = $row['submitter'];

		$i++;
	}

	return $ret;
}

function mylinks_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("mylinks_links")." WHERE status>0 ORDER BY lid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function mylinks_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT lid, title, date FROM ".$xoopsDB->prefix("mylinks_links")." WHERE status>0 ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
	    $id = $row['lid'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/mylinks/singlelink.php?lid=".$id."";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['date'];
		$i++;
	}

	return $ret;
}
?>
