<?php
// $Id: data.inc.php,v 1.4 2005/11/01 13:11:39 ohwada Exp $

// 2005-11-01 K.OHWADA
// BUG 3151: q of link is required 

// 2005-10-01 K.OHWADA
// category

//================================================================
// What's New Module
// get aritciles from module
// for xoopsFaq 1.10 <http://www.xoops.org/>
// 2005-08-13 K.OHWADA
//================================================================

function xoopsfaq_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

//	$sql = "SELECT * FROM ".$xoopsDB->prefix("xoopsfaq_contents")." WHERE contents_visible=1 ORDER BY contents_time DESC";

	$sql = "SELECT c.contents_id, c.category_id, c.contents_title, c.contents_contents, c.contents_nohtml, c.contents_nosmiley, c.contents_noxcode, c.contents_time, cat.category_title FROM ".$xoopsDB->prefix("xoopsfaq_contents")." c, ".$xoopsDB->prefix("xoopsfaq_categories")." cat WHERE c.category_id=cat.category_id AND c.contents_visible=1 ORDER BY c.contents_time DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$URL_MOD = XOOPS_URL."/modules/xoopsfaq";

	$i = 0;
	$ret = array();

	while( $row = $xoopsDB->fetchArray($result))
	{
		$id     = $row['contents_id'];
		$cat_id = $row['category_id'];

// BUG 3151: q of link is required 
		$ret[$i]['link']     = $URL_MOD."/index.php?cat_id=".$cat_id."#q".$id;

		$ret[$i]['cat_link'] = $URL_MOD."/index.php?cat_id=".$cat_id;

		$ret[$i]['title'] = $row['contents_title'];
		$ret[$i]['time']  = $row['contents_time'];
		$ret[$i]['id']    = $id;

// category
		$ret[$i]['cat_name'] = $row['category_title'];

// description
		$html   = 1;
		$smiley = 1;
		$xcode  = 1;
		$image  = 1;
		$br     = 1;

		if ( $row['contents_nohtml'] )		$html   = 0;
		if ( $row['contents_nosmiley'] )	$smiley = 0;
		if ( $row['contents_noxcode'] ) 	$xcode  = 0;

		$desc = $row['contents_contents'];
		$desc = $myts->displayTarea($desc, $html, $smiley, $xcode, $image, $br);
		$ret[$i]['description'] = $desc;

		$i++;
	}

	return $ret;
}

?>
