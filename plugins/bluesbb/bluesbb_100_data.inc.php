<?php
// $Id: bluesbb_100_data.inc.php,v 1.1 2005/11/16 11:10:43 ohwada Exp $

// 2005-11-13 K.OHWADA
// add category

//================================================================
// What's New Module
// get aritciles from module
// for BluesBB 1.00 <http://www.bluish.jp/>
// 2005-09-15 K.OHWADA
// 2005-10-11 Sting_Band
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

	$sql1='SELECT b.post_id, b.topic_id, b.thread_id, b.res_id, b.name, b.title, b.post_time, b.uid, b.message, t.topic_name, t.topic_style FROM '.$db->prefix('bluesbb').' b LEFT JOIN '.$db->prefix('bluesbb_topic').' t ON t.topic_id = b.topic_id WHERE';

	if (is_object($xoopsUser)) 
	{
		$sql1 .= ' (t.topic_access = 1 OR t.topic_access = 2 OR t.topic_access = 3 OR t.topic_access = 4 OR t.topic_access = 5';
		$groups =& $member_handler->getGroupsByUser($xoopsUser->getVar('uid'),true);

		foreach ($groups as $group)
		{
			$sql1 .= ' OR t.topic_group = '.$group->getVar('groupid');
		}
		if ( $xoopsUser->isAdmin() ) 
		{
			$sql1 .= ' OR t.topic_access = 6';
		}
	}
	else 
	{
		$sql1 .= ' (t.topic_access = 1 OR t.topic_access = 2 OR t.topic_access = 5';
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

	$sql1 .= ')'.$catop.''.$topop;;

	if ($OPT_SREAD)
	{
		$sql1 .= " AND b.res_id = 0";
	}

	$sql1 .= " ORDER BY b.post_time DESC";

	if (!$res1 = $db->query($sql1, $limit, $offset) )
	{
		return false;
	}

	while ($row1 = $db->fetchArray($res1)) 
	{
		if ($OPT_SREAD)
		{
			$sql2='SELECT post_id, res_id, name, post_time, uid, message FROM '.$db->prefix('bluesbb').' WHERE thread_id = '.$row1['thread_id'].' ORDER BY post_time DESC LIMIT 0, 1';

			if (!$res2 = $db->query($sql2)) 
			{
				continue;
			}

			while ($row2 = $db->fetchArray($res2)) 
			{
				$post_id   = $row2['post_id'];
				$res_id    = $row2['res_id'];
				$post_time = $row2['post_time'];
				$uid       = $row2['uid'];
				$desc      = $row2['message'];
			}
		}
		else
		{
			$post_id   = $row1['post_id'];
			$res_id    = $row1['res_id'];
			$post_time = $row1['post_time'];
			$uid       = $row1['uid'];
			$desc      = $row1['message'];
		}

		$title       = $row1['title'];
		$topic_name  = $row1['topic_name'];
		$topic_id    = $row1['topic_id'];
		$thread_id   = $row1['thread_id'];
		$topic_style = $row1['topic_style'];

		switch($topic_style) 
		{
		case "1":
			$lt='l50#p'.$post_id;
			break;
		case "2":
			$lt=++$res_id;
			break;
		case "3":
			$lt=$post_id;
			break;
		}

		$url_topic  = $URL_MOD."/topic.php?top=".$topic_id;
		$url_thread = $URL_MOD."/thread.php?top=".$topic_id."&amp;thr=".$thread_id."&amp;sty=".$topic_style."&amp;num=".$lt;
		$url_cat = $URL_MOD."/topic.php?top=".$topic_id;

		$block[$i]['title']    = $title;
		$block[$i]['cat_name'] = $topic_name;
		$block[$i]['link']     = $url_thread;
		$block[$i]['cat_link'] = $url_cat;
		$block[$i]['time']     = $post_time;
		$block[$i]['id']       = $post_id;
		$block[$i]['uid']      = $uid;
		$block[$i]['description'] = $myts->makeTareaData4Show( $desc, 0 );

		$i ++;
	}

	return $block;
}

?>