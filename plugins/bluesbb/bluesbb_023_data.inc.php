<?php
// $Id: bluesbb_023_data.inc.php,v 1.1 2005/11/16 11:10:43 ohwada Exp $

// 2005-10-01 K.OHWADA
// category

//================================================================
// What's New Module
// get aritciles from module
// for BluesBB 0.23 <http://www.bluish.jp/>
// 2005-09-15 K.OHWADA
//================================================================

function bluesbb_new($limit=0, $offset=0)
{
	global $xoopsUser, $member_handler;

	$OPT_CAT   = 0;
	$OPT_TOPIC = 0;
	$OPT_SREAD = 0;

	$URL_MOD = XOOPS_URL."/modules/bluesbb";

	$db =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();

// recent data
	$i = 0;
	$block = array();

	$query='SELECT b.post_id, b.topic_id, b.sread_id, b.res_id, b.name, b.title, b.post_time, b.uid, b.message, t.topic_name FROM '.$db->prefix('bluesbb').' b LEFT JOIN '.$db->prefix('bluesbb_topic').' t ON t.topic_id = b.topic_id WHERE';

	if ( is_object($xoopsUser) ) 
	{
		$query .= ' (t.topic_access = 1 OR t.topic_access = 2 OR t.topic_access = 3 OR t.topic_access = 4 OR t.topic_access = 5';
		$groups =& $member_handler->getGroupsByUser($xoopsUser->getVar('uid'),true);

		foreach ($groups as $group)
		{
			$query .= ' OR t.topic_group = '.$group->getVar('groupid');
		}
		if ( $xoopsUser->isAdmin() ) 
		{
			$query .= ' OR t.topic_access = 6';
		}
	}
	else 
	{
		$query .= ' (t.topic_access = 1 OR t.topic_access = 2 OR t.topic_access = 5';
	}

	if ($OPT_CAT=="0") 
	{
		$catop='';
	}
	elseif ($OPT_CAT!="0" && $OPT_TOPIC!="0") 
	{
		$catop=' AND (t.cat_id = '.$OPT_CAT;
	}
	else 
	{
		$catop=' AND t.cat_id = '.$OPT_CAT;
	}

	if ($OPT_TOPIC=="0") 
	{
		$topop='';
	}
	elseif ($OPT_CAT!="0" && $OPT_TOPIC!="0") 
	{
		$topop=' OR t.topic_id = '.$OPT_TOPIC.')';
	}
	else 
	{
		$topop=' AND t.topic_id = '.$OPT_TOPIC;
	}

	$query .= ')'.$catop.''.$topop;;

	if ($OPT_SREAD)
	{
		$query .= " AND b.res_id = 0";
	}

	$query .= " ORDER BY b.post_time DESC";

	if (!$result = $db->query($query, $limit, $offset) )
	{
		return false;
	}

	while ($row1 = $db->fetchArray($result)) 
	{
		if ($OPT_SREAD)
		{
			$sql2='SELECT post_id, name, post_time, uid, message FROM '.$db->prefix('bluesbb').' WHERE sread_id = '.$row1['sread_id'].' ORDER BY post_time DESC LIMIT 0, 1';

			if (!$result2 = $db->query($sql2)) 
			{
				continue;
			}

			while ($row2 = $db->fetchArray($result2)) 
			{
				$post_id   = $row2['post_id'];
				$post_time = $row2['post_time'];
				$uid       = $row2['uid'];
				$desc      = $row2['message'];
			}
		}
		else
		{
			$post_id   = $row1['post_id'];
			$post_time = $row1['post_time'];
			$uid       = $row1['uid'];
			$desc      = $row1['message'];
		}

		$topic_id  = $row1['topic_id'];
		$sread_id  = $row1['sread_id'];
		$block[$i]['cat_link'] = $URL_MOD."/viewtopic.php?topic=".$topic_id;
		$block[$i]['link'] = $URL_MOD."/viewsread.php?topic=".$topic_id."&amp;sread_id=".$sread_id."&amp;number=l50#postid".$post_id;

		$block[$i]['title']    = $row1['title'];
		$block[$i]['cat_name'] = $row1['topic_name'];

	   	$block[$i]['time']  = $post_time;
		$block[$i]['id']    = $post_id;
		$block[$i]['uid']   = $uid;
		$block[$i]['description'] = $myts->makeTareaData4Show( $desc, 0 );

		$i ++;
	}

	return $block;
}

?>
