<?php
// $Id: data.inc.php,v 1.2 2006/01/27 11:27:21 ohwada Exp $

// 2006-01-27 K.OHWADA
// some changes

//================================================================
// What's New Module plugin
// get aritciles from module
// for xoops newmembers 1.00
// 2006-01-21 aotake <http://www.bmath.org/>
//================================================================

function xoopsmembers_new($limit=0, $offset=0)
{
	$criteria = new CriteriaCompo(new Criteria('level', 0, '>'));
	$criteria->setOrder('DESC');
	$criteria->setSort('user_regdate');
	$criteria->setLimit($limit);
	$member_handler =& xoops_gethandler('member');
	$newmembers =& $member_handler->getUsers($criteria);
	$count = count($newmembers);
	$ret = array();

	for ($i = 0; $i < $count; $i++) 
	{
		$uid     = intval( $newmembers[$i]->getVar('uid') );
		$uname   = $newmembers[$i]->getVar('uname');
		$name    = $newmembers[$i]->getVar('name');
		$posts   = $newmembers[$i]->getVar('posts');
		$bio     = $newmembers[$i]->getVar('bio');
		$regdate = $newmembers[$i]->getVar('user_regdate');

		if ($name)
		{
			$title = $name;
		}
		else
		{
			$title = $uname;
		}

		$desc = $bio;

		$ret[$i]['title'] = $title;
		$ret[$i]['link']  = XOOPS_URL."/userinfo.php?uid=".$uid;
		$ret[$i]['id']    = $uid;
		$ret[$i]['uid']   = $uid;
		$ret[$i]['time']  = $regdate;
		$ret[$i]['hits']  = $posts;
		$ret[$i]['description'] = $desc;

		if (($limit > 0) && ($i >= $limit))  break;
	}

	return $ret;
}

?>