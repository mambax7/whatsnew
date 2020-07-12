<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// category, counter

// 2004/08/20 K.OHWADA
// atom feed

//================================================================
// What's New Module
// get aritciles from module
// for mydownloads 1.10 <http://www.xoops.org/>
// 2004.01.03 K.OHWADA
//================================================================

function mydownloads_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$URL_MOD = XOOPS_URL."/modules/mydownloads";

//	$sql = "SELECT d.lid, d.title, d.date, t.description FROM ".$xoopsDB->prefix("mydownloads_downloads")." d LEFT JOIN ".$xoopsDB->prefix("mydownloads_text")." t ON t.lid=d.lid WHERE status>0 ORDER BY d.date DESC";

	$sql = "SELECT d.lid, d.title as dtitle, d.date, d.cid, d.submitter, d.hits, t.description, c.title as ctitle FROM ".$xoopsDB->prefix("mydownloads_downloads")." d, ".$xoopsDB->prefix("mydownloads_text")." t, ".$xoopsDB->prefix("mydownloads_cat")." c WHERE t.lid=d.lid AND d.cid=c.cid AND d.status>0 ORDER BY d.date DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);



	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
 		$lid = $row['lid'];
		$ret[$i]['link']     = $URL_MOD."/singlefile.php?lid=".$lid;
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];

		$ret[$i]['title'] = $row['dtitle'];
		$ret[$i]['time']  = $row['date'];

// atom feed
		$ret[$i]['id'] = $lid;
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

function mydownloads_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("mydownloads_downloads")." WHERE status>0 ORDER BY lid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function mydownloads_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT lid, title, date FROM ".$xoopsDB->prefix("mydownloads_downloads")." WHERE status>0 ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($myrow = $xoopsDB->fetchArray($result))
 	{
	    $id = $myrow['lid'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/mydownloads/singlefile.php?lid=".$id."";
		$ret[$i]['title'] = $myrow['title'];
		$ret[$i]['time']  = $myrow['date'];
		$i++;
	}

	return $ret;
}
?>
