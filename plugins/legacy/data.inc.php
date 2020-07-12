<?php
// $Id: data.inc.php,v 1.1 2007/05/15 05:29:14 ohwada Exp $

// 2007-05-12 K.OHWADA
// same as system/data.inc.php

//================================================================
// What's New Module
// get aritciles from module
// for XC 2.1 comment<http://xoopscube.org/>
// 2005-06-06 K.OHWADA
//================================================================

include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';

function legacy_new($limit=0, $offset=0)
{
	$comment_handler =& xoops_gethandler('comment');
	$criteria = new CriteriaCompo(new Criteria('com_status', XOOPS_COMMENT_ACTIVE));
	$criteria->setLimit( 2*$limit );	// get twice records 
	$criteria->setSort('com_created');
	$criteria->setOrder('DESC');
	$comments =& $comment_handler->getObjects($criteria, true);

	$member_handler =& xoops_gethandler('member');

	$module_handler =& xoops_gethandler('module');
	$modules =& $module_handler->getObjects(new Criteria('hascomments', 1), true);

	$moduleperm_handler =& xoops_gethandler('groupperm');

// registerd user
	global $xoopsUser;
	if ( is_object($xoopsUser) )
	{
		$groups = $xoopsUser->getGroups();
	}
// guest
	else
	{
		$groups = XOOPS_GROUP_ANONYMOUS;
	}

	$comment_config = array();

	$j = 0;
	$ret = array();

	foreach (array_keys($comments) as $i) 
	{
		$mid = $comments[$i]->getVar('com_modid');

// check user permission
		if ( !$moduleperm_handler->checkRight('module_read', $mid, $groups) )
		{	continue;	}

		$itemid   = $comments[$i]->getVar('com_itemid');
		$rootid   = $comments[$i]->getVar('com_rootid');
		$exparams = $comments[$i]->getVar('com_exparams');
		$title    = $comments[$i]->getVar('com_title');
		$created  = $comments[$i]->getVar('com_created');
		$text     = $comments[$i]->getVar('com_text');
	   	$uid      = $comments[$i]->getVar('com_uid');

		if (!isset($comment_config[$mid])) 
		{
			$comment_config[$mid] = $modules[$mid]->getInfo('comments');
		}

		$pageName = $comment_config[$mid]['pageName'];
		$itemName = $comment_config[$mid]['itemName'];

		$dirname  = $modules[$mid]->getVar('dirname');
		$mod_name = $modules[$mid]->getVar('name');

		$dir_mod = XOOPS_URL."/modules/".$dirname;

		$ret[$j]['link'] = $dir_mod.'/'.$pageName.'?'.$itemName.'='.$itemid.'&amp;com_id='.$i.'&amp;com_rootid='.$rootid.'&amp;'.$exparams.'#comment'.$i;
		$ret[$j]['cat_link'] = $dir_mod.'/';

		$ret[$j]['title'] = $title;
		$ret[$j]['time']  = $created;
		$ret[$j]['id']    = $i;
	   	$ret[$j]['uid']   = $uid;
		$ret[$j]['cat_name'] = $mod_name;
		$ret[$j]['description'] = $text;

		$j++;

		if (($limit > 0) && ($j >= $limit))  break;
	}

	return $ret;
}

?>