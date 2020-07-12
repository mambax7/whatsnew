<?php
// $Id: data.inc.php,v 1.1 2006/06/21 05:20:30 ohwada Exp $

// 2006-06-18 K.OHWADA
// this new file

//================================================================
// What's New Module
// get aritciles from module
// for xoopsPoll 1.00 <http://www.xoops.org/>
// 2006-06-18 K.OHWADA
//================================================================

function xoopspoll_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$VALID_TIME_AFTER_END = 604800;	// 7 days

	$end_time = time() - $VALID_TIME_AFTER_END;
	$sql = "SELECT * FROM ".$xoopsDB->prefix("xoopspoll_desc")." WHERE display=1 AND end_time > ".$end_time." ORDER BY start_time DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$URL_MOD = XOOPS_URL."/modules/xoopspoll";

	$i = 0;
	$ret = array();

	while( $row = $xoopsDB->fetchArray($result))
	{
		$id     = $row['poll_id'];
		$ret[$i]['link']  = $URL_MOD."/pollresults.php?poll_id=".$id;
		$ret[$i]['title'] = $row['question'];
		$ret[$i]['time']  = $row['start_time'];
		$ret[$i]['id']    = $id;

// description
		$html   = 0;
		$smiley = 1;
		$xcode  = 1;
		$image  = 1;
		$br     = 1;

		$desc = $row['description'];
		$desc = $myts->displayTarea($desc, $html, $smiley, $xcode, $image, $br);
		$ret[$i]['description'] = $desc;

		$i++;
	}

	return $ret;
}

?>