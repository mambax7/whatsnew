<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// category, counter

// 2005-06-20 K.OHWADA
// for PDA

// 2004/08/20 K.OHWADA
// add atom items
// check the showing property

//================================================================
// What's New Module
// get aritciles from module
// 2004.01.03 K.OHWADA
//================================================================

function xfsection_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$i = 0;
	$ret  = array();
	$time = time();

// check the showing property
//	$sql = "SELECT * FROM ".$xoopsDB->prefix("xfs_article")." WHERE (published > 0 AND published <= $time ) AND noshowart = 0 AND offline = '0' AND (expired = 0 OR expired > $time ) ORDER BY published DESC";

	$sql = "SELECT a.articleid, a.uid, a.title as atitle, a.maintext, a.nohtml, a.nosmiley, a.nobr, a.enaamp, a.created, a.changed, a.published, a.uid, a.counter, cat.id as catid, cat.title as cattitle FROM ".$xoopsDB->prefix("xfs_article")." a, ".$xoopsDB->prefix("xfs_category")." cat WHERE a.categoryid=cat.id AND a.published > 0 AND a.published <= $time AND a.noshowart = 0 AND a.offline = '0' AND (a.expired = 0 OR a.expired > $time ) ORDER BY a.published DESC";

	$URL_MOD = XOOPS_URL."/modules/xfsection";

	$result = $xoopsDB->query($sql, $limit, $offset);
	while( $row = $xoopsDB->fetchArray($result) )
	{
	   	$id = $row['articleid'];

// link
	    $ret[$i]['link']     = $URL_MOD."/article.php?articleid=".$id;
	    $ret[$i]['pda']      = $URL_MOD."/print.php?articleid=".$id;
	   	$ret[$i]['cat_link'] = $URL_MOD."/index.php?category=".$row['catid'];

// title
	    $ret[$i]['title']    = $row['atitle'];
		$ret[$i]['cat_name'] = $row['cattitle'];

// counter
	   	$ret[$i]['hits'] = $row['counter'];

// atom
	   	$ret[$i]['id']       = $id;
	   	$ret[$i]['uid']      = $row['uid'];
	   	$ret[$i]['time']     = $row['changed'];
		$ret[$i]['modified'] = $row['changed'];
		$ret[$i]['issued']   = $row['published'];
		$ret[$i]['created']  = $row['created'];

		$html   = 1;
		$smiley = 1;
		$xcodes = 1;
		$image  = 1;
		$br     = 1;
		$amp    = 0;

		if ( $row['nohtml'] )	$html   = 0;
		if ( $row['nosmiley'] )	$smiley = 0;
		if ( $row['nobr'] )		$br     = 0;
		if ( $row['enaamp'] )	$amp    = 1;

		$maintext    = $row['maintext'];
		$maintextarr = explode("[pagebreak]", $maintext);
		$maintext    = $maintextarr[0];

		$maintext = $myts->displayTarea($maintext, $html, $smiley, $xcodes, $image, $br);
		$ret[$i]['description'] = $maintext;

		$i++;
	}

	return $ret;
}

function xfsection_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("xfs_article")." ORDER BY articleid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function xfsection_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$i = 0;
	$ret = array();

	$sql = "SELECT * FROM ".$xoopsDB->prefix("xfs_article")." ORDER BY articleid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	while($myrow = $xoopsDB->fetchArray($result))
	{
	    $id = $myrow['articleid'];
	    $ret[$i]['id']    = $id;
	    $ret[$i]['link']  = XOOPS_URL."/modules/xfsection/article.php?articleid=$id";
	    $ret[$i]['title'] = $myrow['title']." ".$myrow['summary'];
	   	$ret[$i]['time']  = $myrow['published'];
		$i++;
	}

	return $ret;
}
?>
