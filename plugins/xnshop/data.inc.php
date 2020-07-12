<?php
// $Id: data.inc.php,v 1.1 2005/11/16 11:07:03 ohwada Exp $

// 2005-11-13 K.OHEADA
// small change

//================================================================
// What's New Module
// get aritciles from module
// for xnshop 0.86 <http://www.xoopsnote.com/>
// 2005-10-31 yono <info@yonosan.com>
//================================================================

function xnshop_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$sql = "SELECT l.lid, l.cid, l.name as lname, l.submitter, l.updated, l.hits, t.description1 as tdescription1, c.title as cname FROM ".$xoopsDB->prefix("xnshop_links")." l, ".$xoopsDB->prefix("xnshop_options")." t, ".$xoopsDB->prefix("xnshop_cat")." c WHERE t.lid=l.lid AND l.cid=c.cid AND l.status>0 ORDER BY l.updated DESC";

	$URL_MOD = XOOPS_URL."/modules/xnshop";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$i = 0;
	$ret = array();

	while($row = $xoopsDB->fetchArray($result))
	{
		$lid = $row['lid'];
		$cid = $row['cid'];

		$link     = $URL_MOD."/singlelink.php?cid=".$cid."&lid=".$lid;
		$cat_link = $URL_MOD."/viewcat.php?cid=".$cid;
		$desc     = $myts->makeTareaData4Show( $row['tdescription1'], 0 );

		$ret[$i]['link']     = $link;
		$ret[$i]['cat_link'] = $cat_link;
		$ret[$i]['title']    = $row['lname'];
		$ret[$i]['cat_name'] = $row['cname'];
		$ret[$i]['id']    = $lid;
		$ret[$i]['time']  = $row['updated'];
		$ret[$i]['uid']   = $row['submitter'];
		$ret[$i]['hits']  = $row['hits'];
		$ret[$i]['description'] = $desc;

		$i++;
	}

	return $ret;
}

function xnshop_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("xnshop_links")." WHERE status>0 ORDER BY lid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function xnshop_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT lid, name, updated FROM ".$xoopsDB->prefix("xnshop_links")." WHERE status>0 ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($row = $xoopsDB->fetchArray($result))
 	{
	    $id = $row['lid'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/xnshop/singlelink.php?lid=".$id."";
		$ret[$i]['title'] = $row['name'];
		$ret[$i]['time']  = $row['updated'];
		$i++;
	}

	return $ret;
}
?>
