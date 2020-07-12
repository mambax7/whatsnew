<?php
// $Id: data.inc.php,v 1.2 2008/11/16 14:05:39 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for newbbex 1.60 <http://xoops.instant-zero.com/>
// 2008-10-31 lansnode <http://d8q.net/>
//================================================================

// include_once XOOPS_ROOT_PATH.'/modules/newbbex/functions.php';

function newbbex_new($limit=0, $offset=0)
{
	$file_functions = XOOPS_ROOT_PATH.'/modules/newbbex/functions.php';
	if ( file_exists( $file_functions ) ) {
		include_once  $file_functions ;
	} else {
		return false;
	}

	global $xoopsDB, $xoopsUser, $xoopsModule,$queryarray, $andor,  $userid;
	$searchparam='';
	// Hack for viewing only authorized forums
	if (is_object($xoopsUser)) {
		$where=private_forums_list_cant_access($xoopsUser->getVar('uid'),'f.');
		if(strlen(trim($where))>0) {
			$where = " WHERE (".$where.') ';
		} else {
			$where = " WHERE 1=1 ";
		}
	} else {	// Don't give any access to private forums for anonymous users
		$where=' WHERE f.forum_type=0 ';
	}

	$sql = "SELECT p.post_id,p.topic_id,p.forum_id,p.post_time,p.uid,p.subject FROM ".$xoopsDB->prefix("bbex_posts")." p LEFT JOIN ".$xoopsDB->prefix("bbex_posts_text")." t ON t.post_id=p.post_id LEFT JOIN ".$xoopsDB->prefix("bbex_forums")." f ON f.forum_id=p.forum_id  $where";
	if ( $userid != 0 ) {
		$sql .= " AND (p.uid=".$userid.") ";
	}
	if(is_array($queryarray) && count($queryarray)>0) {
		$searchparam='&keywords='.urlencode(trim(implode(' ',$queryarray)));
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((p.subject LIKE '%$queryarray[0]%' OR t.post_text LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++) {
			$sql .= " $andor ";
			$sql .= "(p.subject LIKE '%$queryarray[$i]%' OR t.post_text LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY p.post_time DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$i = 0;
	
 	$URL_MOD = XOOPS_URL."/modules/newbbex";
 	
 	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$i]['link'] = $URL_MOD."/viewtopic.php?topic_id=".$myrow['topic_id']."&amp;forum=".$myrow['forum_id'].$searchparam."#forumpost".$myrow['post_id'];
		$ret[$i]['title'] = $myrow['subject'];
		$ret[$i]['time'] = $myrow['post_time'];
		$ret[$i]['uid'] = $myrow['uid'];
		$i++;
	}
	return $ret;
}
?>