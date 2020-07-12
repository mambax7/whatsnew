<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// popnupblog 2.1 <http://www.bluemooninc.biz/~xoops2/>
// 2005.05.12 hoshiyan <http://www.hoshiba-farm.com/>
//================================================================

function popnupblog_new($limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();
	$popnupblogDirname = 'popnupblog';
	$module_url = XOOPS_URL."/modules/".$popnupblogDirname;

	$sql = "SELECT m.uid, m.cat_id, m.blogid, l.title, l.blog_date, l.post_text FROM "
			.$xoopsDB->prefix("popnupblog_info")." m, ".$xoopsDB->prefix("popnupblog")
			." l  WHERE (m.blog_permission & 0x07)=0 and m.blogid=l.blogid ORDER BY l.blog_date DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($myrow = $xoopsDB->fetchArray($result))
 	{
		$ret[$i]['title'] = $myrow['title'];
		$uts = strtotime($myrow['blog_date']);
		if ($uts == -1) $uts = date('U');
		$ret[$i]['time']  = $uts;
		$user_time = xoops_getUserTimestamp($uts);
		$link_param = sprintf("%04u%02u%02u%02u%02u%02u", strftime("%Y", $user_time),strftime("%m", $user_time),
			strftime("%d", $user_time),strftime("%H", $user_time),strftime("%M", $user_time),strftime("%S", $user_time));
		$ret[$i]['link'] = $module_url.'/index.php?param='.$myrow['blogid'].'-'.$link_param;

//		$ret[$i]['description'] = $myrow['description'];

// atom feed
		$ret[$i]['id'] = $myrow['uid'].$myrow['cat_id'].$myrow['blogid'].$myrow['blog_date'];
		$ret[$i]['description'] = $myts->makeTareaData4Show( $myrow['post_text'], 0 );

		$i++;
	}

	return $ret;
}

function popnupblog_num()
{
	global $xoopsDB;
	$sql = "SELECT m.uid, m.cat_id, m.blogid, l.title, l.blog_date, l.post_text FROM "
			.$xoopsDB->prefix("popnupblog_info")." m, ".$xoopsDB->prefix("popnupblog")
			." l  WHERE (m.blog_permission & 0x07)=0 and m.blogid=l.blogid ORDER BY l.blog_date DESC";
	$result = $xoopsDB->query($sql);
	$array = $xoopsDB->fetchRow( $result );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function popnupblog_data($limit=0, $offset=0)
{
	global $xoopsDB;
	$popnupblogDirname = 'popnupblog';
	$module_url = XOOPS_URL."/modules/".$popnupblogDirname;

	$sql = "SELECT m.uid, m.cat_id, m.blogid, l.title, l.blog_date, l.post_text FROM "
			.$xoopsDB->prefix("popnupblog_info")." m, ".$xoopsDB->prefix("popnupblog")
			." l  WHERE (m.blog_permission & 0x07)=0 and m.blogid=l.blogid ORDER BY l.blog_date DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while($myrow = $xoopsDB->fetchArray($result))
 	{
	    $id = $myrow['uid'].$myrow['cat_id'].$myrow['blogid'].$myrow['blog_date'];
	    $ret[$i]['id']   = $id;
		$ret[$i]['title'] = $myrow['title'];
		$uts = strtotime($myrow['blog_date']);
		if ($uts == -1) $uts = date('U');
		$ret[$i]['time']  = $uts;
		$user_time = xoops_getUserTimestamp($uts);
		$link_param = sprintf("%04u%02u%02u%02u%02u%02u", strftime("%Y", $user_time),strftime("%m", $user_time),
			strftime("%d", $user_time),strftime("%H", $user_time),strftime("%M", $user_time),strftime("%S", $user_time));
		$ret[$i]['link'] = $module_url.'/index.php?param='.$myrow['blogid'].'-'.$link_param;
		$i++;
	}

	return $ret;
}
?>
