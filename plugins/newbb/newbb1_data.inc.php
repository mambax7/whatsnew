<?php
// $Id: newbb1_data.inc.php,v 1.4 2005/10/24 05:47:35 ohwada Exp $

// 2005-10-23 K.OHWADA
// topic_title -> subject

// 2005-10-10 K.OHWADA
// category, counter

// 2004/08/20 K.OHWADA
// atom feed

//================================================================
// What's New Module
// get aritciles from module
// for NewBB 1.00 <http://www.xoops.org/>
// 2004.01.03 K.OHWADA
//================================================================

function newbb_new($limit=0, $offset=0) 
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$i = 0;
	$ret = array();

	$sql = 'SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.topic_time, t.topic_views, t.topic_replies, t.forum_id, f.forum_name, p.post_id, p.uid, p.subject, p.nohtml, p.nosmiley, pt.post_text  FROM '.$xoopsDB->prefix('bb_topics').' t, '.$xoopsDB->prefix('bb_forums').' f, '.$xoopsDB->prefix('bb_posts').' p, '.$xoopsDB->prefix('bb_posts_text').' pt WHERE f.forum_id=t.forum_id AND t.topic_last_post_id=p.post_id AND p.post_id=pt.post_id AND f.forum_type=0 ORDER BY t.topic_time DESC';

	$URL_MOD = XOOPS_URL."/modules/newbb";

	$result = $xoopsDB->query($sql, $limit, $offset);
	while ($row = $xoopsDB->fetchArray($result)) 
	{
		$forum_id = $row['forum_id'];
		$topic_id = $row['topic_id'];
		$post_id  = $row['post_id'];

		$ret[$i]['link'] = $URL_MOD."/viewtopic.php?forum=".$forum_id."&amp;topic_id=".$topic_id."&amp;post_id=".$post_id."#forumpost".$post_id;
		$ret[$i]['cat_link'] = $URL_MOD."/viewforum.php?forum=".$forum_id;

		$ret[$i]['title']    = $row['subject'];
		$ret[$i]['cat_name'] = $row['forum_name'];
		$ret[$i]['time']     = $row['topic_time'];
		$ret[$i]['hits']     = $row['topic_views'];
		$ret[$i]['replies']  = $row['topic_replies'];
		$ret[$i]['uid']      = $row['uid'];
		$ret[$i]['id']       = $post_id;

// description
		$html   = 1;
		$smiley = 1;
		$xcodes = 1;

		if ( $row['nohtml'] )   $html   = 0;
		if ( $row['nosmiley'] ) $smiley = 0;

		$ret[$i]['description'] = 
			$myts->makeTareaData4Show($row['post_text'], $html, $smiley, $xcodes);

		$i++;
	}

	return $ret;
}

function newbb_num() 
{
	global $xoopsDB;

    $sql = 'SELECT count(*) FROM '.$xoopsDB->prefix('bb_topics').' t, '.$xoopsDB->prefix('bb_forums').' f WHERE f.forum_id=t.forum_id AND f.forum_type=0 ORDER BY t.topic_id';
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function newbb_data($limit=0, $offset=0) 
{
	global $xoopsDB;

	$i = 0;
	$ret = array();

    $sql = 'SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.topic_time,  t.forum_id FROM '.$xoopsDB->prefix('bb_topics').' t, '.$xoopsDB->prefix('bb_forums').' f WHERE f.forum_id=t.forum_id AND f.forum_type=0 ORDER BY t.topic_id';

	$result = $xoopsDB->query($sql,$limit,$offset);
	while ($arr = $xoopsDB->fetchArray($result)) 
	{
	    $id = $arr['topic_id'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/newbb/viewtopic.php?topic_id=".$id."&amp;forum=".$arr['forum_id']."&amp;post_id=".$arr['topic_last_post_id'];
		$ret[$i]['title'] = $arr['topic_title'];
		$ret[$i]['time']  = $arr['topic_time'];
		$i++;
	}

	return $ret;
}

?>
