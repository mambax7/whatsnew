<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-06-06 K.OHWADA
// full path

//================================================================
// What's New Module
// get aritciles from module
// yybbs 0.57 <http://exmodules.sourceforge.jp/>
// 2005.02.21 Hodaka <http://www.kuri3.net>
//================================================================

define('_YYBBS_DIRNAME', 'yybbs');
require_once XOOPS_ROOT_PATH."/modules/exFrame/frameloader.php";

// full path
require_once XOOPS_ROOT_PATH."/modules/"._YYBBS_DIRNAME."/class/global.php";
require_once XOOPS_ROOT_PATH."/modules/"._YYBBS_DIRNAME."/class/user.php";
require_once XOOPS_ROOT_PATH."/modules/"._YYBBS_DIRNAME."/include/MessageFilter.php";

function yybbs_new($limit=0, $offset=0) {
	$block = array ();

	$filter=new MessagePostFilter();

	$handler=&YYBBS::getHandler('message');
	$criteria=$filter->getCriteria();
	$criteria->setStart($offset);
	$criteria->setLimit($limit);
	$objs=&$handler->getObjects($criteria);

	$bHandler=&YYBBS::getHandler('bbs');

	foreach($objs as $obj) {
		$array = $obj->getStructure();
		$bbs=&$bHandler->get($obj->getVar('bbs_id'));
		$array['bbs']=&$bbs->getStructure();
		$block['messages'][]=&$array;
		unset($array);
	}

	$i = 0;
	$ret = array();

	foreach($block['messages'] as $message) {
		$ret[$i]['title'] = $message['title'];
		$ret[$i]['link'] = XOOPS_URL."/modules/"._YYBBS_DIRNAME."/message.php?id=".$message['id'];
		$ret[$i]['time'] = $message['inputdate'];
		$ret[$i]['description'] = $message['message'];
		$i++;
	}
	return $ret;
}

function yybbs_num() {
	global $xoopsDB;

	$sql = "SELECT count(id) FROM ".$xoopsDB->prefix(_YYBBS_DIRNAME);
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function yybbs_data($limit=0, $offset=0) {
	$block = array ();

	$filter=new MessagePostFilter();

	$handler=&YYBBS::getHandler('message');
	$criteria=$filter->getCriteria();
	$criteria->setStart($offset);
	$criteria->setLimit($limit);
	$objs=&$handler->getObjects($criteria);

	$bHandler=&YYBBS::getHandler('bbs');

	foreach($objs as $obj) {
		$array = $obj->getStructure();
		$bbs=&$bHandler->get($obj->getVar('bbs_id'));
		$array['bbs']=&$bbs->getStructure();
		$block['messages'][]=&$array;
		unset($array);
	}

	$i = 0;
	$ret = array();
	foreach($block['messages'] as $message) {
		$ret[$i]['title'] = $message['title'];
		$ret[$i]['id'] = $message['id'];
		$ret[$i]['link'] = XOOPS_URL."/modules/"._YYBSBS_DIRNAME."/message.php?id=".$message['id'];
		$ret[$i]['time'] = $message['inputdate'];
		$i++;
	}
	return $ret;
}
?>
