<?php
// $Id: eguide_230.inc.php,v 1.1 2007/12/09 00:22:56 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for eguide 2.3 <http://mysite.ddo.jp/>
// 2007-12-09 K.OHWADA
//================================================================

function eguide_new( $limit=0, $offset=0 )
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$URL_MOD = XOOPS_URL."/modules/eguide";

	$ONLY = 0;
	$CAT  = '';

    $now = time();
    $cond = "";
    $ids = array();
    if ($CAT) {
	$labs = array();
	foreach (explode(',',$CAT) as $val) {
	    $nval = intval($val);
	    if ($nval) {
		$ids[] = $nval;
	    } else {
		$labs[] = $xoopsDB->quoteString($val);
	    }
	}
	if ($ids) {
	    $cond = "catid IN (".join(',',$ids).")";
	}
	if ($labs) {
	    if ($cond) $cond .= " OR ";
	    $cond .= "catname IN (".join(',',$labs).")";
	}
	if ($cond) {
	    $res = $xoopsDB->query("SELECT catid,catname,catimg FROM ".$xoopsDB->prefix("eguide_category")." WHERE ".$cond);
	    $ids = array();
	    while (list($id,$name,$img) = $xoopsDB->fetchRow($res)) {
		$ids[$id] = array('name'=>htmlspecialchars($name),'img'=>$img);
	    }
	    $cond = $ids?" AND topicid IN (".join(',',array_keys($ids)).")":"";
	}
    }
    if ($ONLY) {
	$sql = "SELECT eid, title, MIN(IF(exdate,exdate,edate)) edate, cdate, uid FROM ".$xoopsDB->prefix("eguide")." LEFT JOIN ".$xoopsDB->prefix("eguide_extent")." ON eid=eidref AND exdate>$now WHERE (edate>$now OR exdate) $cond AND status=0 GROUP BY eid ORDER BY cdate DESC";
    } else {
	$sql = "SELECT e.*, IF(exdate,exdate,edate) edate, 
exid, IF(x.reserved,x.reserved,o.reserved)/persons*100 as full, closetime,
c.catname
FROM ".$xoopsDB->prefix("eguide").' e
  LEFT JOIN '.$xoopsDB->prefix("eguide_opt").' o ON e.eid=o.eid
  LEFT JOIN '.$xoopsDB->prefix("eguide_extent").' x ON e.eid=eidref
  LEFT JOIN '.$xoopsDB->prefix("eguide_category")." c ON e.topicid=catid
WHERE ((expire>=edate AND expire>$now)
       OR (expire<edate AND IF(exdate,exdate,edate)+expire>$now)) $cond
  AND status=0 ORDER BY cdate DESC";
    }

	$result = $xoopsDB->query($sql, $limit, $offset);
	if ( !$result )
	{	return false;	}

	$i = 0;
	$block = array();

	while ( $row = $xoopsDB->fetchArray($result) ) 
	{
		$eid   = intval( $row['eid'] );

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

		$arr = array(
			'id'          => $eid,
			'title'       => htmlspecialchars( $row['title'] ),
			'cat_name'    => htmlspecialchars( $row['catname'] ),
			'link'        => $URL_MOD .'/event.php?eid='. $eid,
			'cat_link'    => $URL_MOD. '/index.php?cat='. intval( $row['topicid'] ),
			'uid'         => intval( $row['uid'] ),
			'time'        => intval( $row['cdate'] ),
			'hits'        => intval( $row['counter'] ),
			'description' => $desc,
		);

		$block[ $i++ ] = $arr;
	}

	return $block;
}

?>