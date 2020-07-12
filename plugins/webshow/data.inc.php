<?php
// $Id: data.inc.php,v 1.1 2008/11/16 14:07:43 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for webshow <http://wikiwebshow.com/>
// 2007-08-02 TCNet
// http://wikiwebshow.com/modules/wfdownloads/viewcat.php?cid=13
//================================================================

function webshow_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, t.description, c.cattitle as cattitle FROM ".$xoopsDB->prefix("webshow_links")." l, ".$xoopsDB->prefix("webshow_text")." t, ".$xoopsDB->prefix("webshow_cat")." c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.date DESC";

	$URL_MOD = XOOPS_URL."/modules/webshow";

	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
		$ret[$i]['link']     = $URL_MOD."/singlelink.php?lid=".$row['lid'];
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];

		$ret[$i]['title'] = $row['ltitle'];
		$ret[$i]['time']  = $row['date'];

// atom feed
		$ret[$i]['id'] = $row['lid'];
		$ret[$i]['description'] = $myts->makeTareaData4Show( $row['description'], 0 );	//no html

// category
		$ret[$i]['cat_name'] = $row['cattitle'];

// counter
		$ret[$i]['hits'] = $row['hits'];

// this module dont show user name
		$ret[$i]['uid'] = $row['submitter'];

		$i++;
	}

	return $ret;
}

function webshow_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("webshow_links")." WHERE status>0 ORDER BY lid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function webshow_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT lid, title, date FROM ".$xoopsDB->prefix("webshow_links")." WHERE status>0 ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
	    $id = $row['lid'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/webshow/singlelink.php?lid=".$id."";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['date'];
		$i++;
	}

	return $ret;
}
?>