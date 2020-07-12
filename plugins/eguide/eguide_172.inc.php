<?php
// $Id: eguide_172.inc.php,v 1.1 2007/12/09 00:22:56 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for eguide 1.7.2 <http://mysite.ddo.jp/>
// 2005-11-13 K.OHWADA
//================================================================

function eguide_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$URL_MOD = XOOPS_URL."/modules/eguide";

	$sql = "SELECT * FROM ".$xoopsDB->prefix("eguide")." WHERE expire>".time()." AND status=0 ORDER BY cdate DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$i = 0;
	$block = array();

	while ( $row = $xoopsDB->fetchArray($result) ) 
	{
		$eid   = $row['eid'];
		$title = htmlspecialchars($row["title"]);
		$link  = $URL_MOD."/event.php?eid=".$eid;

		if ( $row['counter'] )
		{
			$counter = $row['counter'];
		}
		else
		{
			$counter = 0;
		}

// desc
		$date = formatTimestamp($row['edate'], 's');

		if ( isset($row['body']) && $row['body'] )
		{
			$desc1 = $row['body'];
		}
		else
		{
			$desc1 = $row['summary'];
		}

		switch ($row['style']) 
		{
			case 2:
				$desc1 = htmlspecialchars($desc1);
			case 1:
				$desc1 = nl2br($desc1);
		}

		$desc1 = $myts->xoopsCodeDecode($desc1);
		$desc  = $date.": <br />".$desc1;

		$block[$i]['title'] = $title;
		$block[$i]['link']  = $link;
		$block[$i]['id']    = $eid;
		$block[$i]['uid']   = $row['uid'];
		$block[$i]['time']  = $row['cdate'];
		$block[$i]['hits']  = $counter;
		$block[$i]['description'] = $desc;

		$i ++;
	}

	return $block;
}

?>