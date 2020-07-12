<?php
// $Id: data.inc.php,v 1.1 2005/11/16 11:08:01 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for xhnewbb 1.13 <http://sourceforge.jp/projects/xoopshackers/>
// 2005-11-13 K.OHWADA
//================================================================

function xhnewbb_new($limit=0, $offset=0)
{
	global $xoopsUser ;

	$NOW_ORDER = 'time';
	$NOW_CLASS = 'public';
	$IS_MARKUP =  false;

	$URL_MOD = XOOPS_URL."/modules/xhnewbb";

	$db   =& Database::getInstance();
	$myts =& MyTextSanitizer::getInstance();
	$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;

	switch( $NOW_ORDER ) 
	{
		case 'views':
			$odr = 't.topic_views DESC';
			break;
		case 'replies':
			$odr = 't.topic_replies DESC';
			break;
		case 'time':
		default:
			$odr = 't.topic_time DESC';
			break;
	}

	switch( $NOW_CLASS ) 
	{
		case 'both' :
			$whr_class = "1" ;
			break ;
		case 'private' :
			$whr_class = "f.forum_type = 1" ;
			break ;
		case 'public' :
		default :
			$whr_class = "f.forum_type <> 1" ;
			break ;
	}

	if( $uid > 0 && $IS_MARKUP ) 
	{
		$query = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.topic_time, t.topic_views, t.topic_replies, t.topic_solved, t.forum_id, f.forum_name, p.post_id, p.uid, p.subject, p.nohtml, p.nosmiley, pt.post_text, u2t.u2t_marked FROM ".$db->prefix("xhnewbb_topics")." t LEFT JOIN ".$db->prefix("xhnewbb_forums")." f ON f.forum_id=t.forum_id LEFT JOIN ".$db->prefix("xhnewbb_posts")." p ON p.topic_id=t.topic_id AND p.post_time >= t.topic_time-2 LEFT JOIN ".$db->prefix("xhnewbb_posts_text")." pt ON  p.post_id=pt.post_id LEFT JOIN ".$db->prefix("xhnewbb_users2topics")." u2t ON  u2t.topic_id=t.topic_id AND u2t.uid=".$uid." WHERE ".$whr_class." ORDER BY u2t.u2t_marked<=>1 DESC , ".$odr;
	}
	else 
	{
		$query = "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.topic_time, t.topic_views, t.topic_replies, t.topic_solved, t.forum_id, f.forum_name, p.post_id, p.uid, p.subject, p.nohtml, p.nosmiley, pt.post_text, 0 AS u2t_marked FROM ".$db->prefix("xhnewbb_topics")." t, ".$db->prefix("xhnewbb_forums")." f, ".$db->prefix("xhnewbb_posts")." p, ".$db->prefix('xhnewbb_posts_text')." pt WHERE f.forum_id=t.forum_id AND p.topic_id=t.topic_id AND p.post_id=pt.post_id AND p.post_time >= t.topic_time-2 AND $whr_class ORDER BY $odr" ;
	}

	if (!$result = $db->query($query, $limit, $offset) )
	{
		return false;
	}

	$i = 0;
	$block = array();

	while ($row = $db->fetchArray($result)) 
	{
		$topic_id = $row['topic_id'];
		$forum_id = $row['forum_id'];
		$post_id  = $row['topic_last_post_id'];

		$title    = $myts->makeTboxData4Show($row['subject']);
		$cat_name = $myts->makeTboxData4Show($row['forum_name']);
		$link     = $URL_MOD."/viewtopic.php?topic_id=".$topic_id."&amp;forum=".$forum_id."&amp;post_id=".$post_id."#forumpost".$post_id;
		$cat_link = $URL_MOD."/viewforum.php?forum=".$forum_id;

// description
		$html   = 1;
		$smiley = 1;
		$xcodes = 1;

		if ( $row['nohtml'] )   $html   = 0;
		if ( $row['nosmiley'] ) $smiley = 0;

		$desc = $myts->makeTareaData4Show($row['post_text'], $html, $smiley, $xcodes);

		$block[$i]['title']    = $title;
		$block[$i]['cat_name'] = $cat_name;
		$block[$i]['link']     = $link;
		$block[$i]['cat_link'] = $cat_link;
		$block[$i]['id']       = $post_id;
		$block[$i]['uid']      = $row['uid'];
		$block[$i]['time']     = $row['topic_time'];
		$block[$i]['hits']     = $row['topic_views'];
		$block[$i]['replies']  = $row['topic_replies'];
		$block[$i]['description'] = $desc;

		$i ++;
	}

	return $block;
}

?>