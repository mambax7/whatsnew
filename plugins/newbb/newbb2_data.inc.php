<?php
// $Id: newbb2_data.inc.php,v 1.6 2007/07/04 12:00:35 ohwada Exp $

// 2007-07-01 K.OHWADA
// small change for v3.08
// Undefined index: allow_moderator_html

// 2006-06-25 K.OHWADA
// this plugin dont work in newbb 1.0 module

//================================================================
// What's New Module
// get aritciles from module
// for NewBB 2.02 <http://dev.xoops.org/modules/xfmod/project/?newbb>
// 2005-10-13 K.OHWADA
//================================================================

// === newbb 2 plugin start ===
if ( file_exists(XOOPS_ROOT_PATH . '/modules/newbb/include/functions.php') )
{

include_once XOOPS_ROOT_PATH . '/modules/newbb/include/functions.php';

function newbb_new($limit=0, $offset=0) 
{
	global $xoopsConfig;
	static $newbbConfig, $access_forums;

	$db = &Database::getInstance();
	$myts = &MyTextSanitizer::getInstance();
	$block = array();
	$i = 0;

    $forum_handler = &xoops_getmodulehandler('forum', 'newbb');
	$module_handler = &xoops_gethandler('module');
	$newbb = $module_handler->getByDirname('newbb');

	if( !isset($newbbConfig) )
	{
		$config_handler = &xoops_gethandler('config');
		$newbbConfig = &$config_handler->getConfigsByCat(0, $newbb->getVar('mid'));
	}

	if( !isset($access_forums) )
	{
		$access_forums = $forum_handler->getForums(0, 'access'); // get all accessible forums
	}

	$valid_forums = array_keys($access_forums);

	if ( !empty($allowed_forums) && count($allowed_forums) > 0)
	{
		$valid_forums = array_intersect($allowed_forums, $valid_forums);
	}

	if ( count($valid_forums) == 0 )  return false;

	$forum_criteria = ' AND t.forum_id IN (' . implode(',', $valid_forums) . ')';
	unset($access_forums);
	$approve_criteria = ' AND t.approved = 1 AND p.approved = 1';

	$sql = 'SELECT t.*, f.forum_name, f.allow_subject_prefix, p.post_id, p.icon, p.uid, p.poster_name, p.forum_id, p.subject, p.dohtml, p.dosmiley, p.doxcode, p.dobr, p.doimage, p.post_time, pt.post_text FROM ' . $db->prefix('bb_topics') . ' t, ' . $db->prefix('bb_forums') . ' f, ' . $db->prefix('bb_posts') .' p, '. $db->prefix('bb_posts_text') . ' pt WHERE f.forum_id=t.forum_id ' . $forum_criteria . $approve_criteria . ' AND t.topic_last_post_id=p.post_id AND p.post_id=pt.post_id ORDER BY t.topic_time DESC';

	$result = $db->query($sql, $limit, $offset);
	if ( !$result ) return false;

	$URL_MOD = XOOPS_URL."/modules/newbb";

	while ($row = $db->fetchArray($result)) 
	{
// uid, text
		$forum_id = $row['forum_id'];
		$topic_id = $row['topic_id'];
		$post_id  = $row['post_id'];

		$ret[$i]['link'] = $URL_MOD."/viewtopic.php?forum=".$forum_id."&amp;topic_id=".$topic_id."&amp;post_id=".$post_id."#forumpost".$post_id;
		$ret[$i]['cat_link'] = $URL_MOD."/viewforum.php?forum=".$forum_id;

		$ret[$i]['title']    = $row['subject'];
		$ret[$i]['cat_name'] = $row['forum_name'];
		$ret[$i]['time']     = $row['post_time'];
		$ret[$i]['hits']     = $row['topic_views'];
		$ret[$i]['replies']  = $row['topic_replies'];
		$ret[$i]['uid']      = $row['uid'];
		$ret[$i]['id']       = $post_id;

// description
		$myts =& MyTextSanitizer::getInstance();

		$html   = 0;
		$smiley = 0;
		$xcode  = 0;
		$br     = 0;
		$image  = 0;

		if ( $row['dohtml'] )   $html   = 1;
		if ( $row['dosmiley'] ) $smiley = 1;
		if ( $row['doxcode'] )  $xcode  = 1;
		if ( $row['dobr'] )     $br     = 1;
		if ( $row['doimage'] )  $image  = 1;

		$ret[$i]['description'] = 
			$myts->displayTarea($row['post_text'], $html, $smiley, $xcode, $image, $br);

		$i++;
	}

	return $ret;
}

// ==== newbb 2 plugin end ===
}

?>