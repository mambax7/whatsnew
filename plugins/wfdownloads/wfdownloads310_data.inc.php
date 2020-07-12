<?php
// $Id: wfdownloads310_data.inc.php,v 1.4 2007/11/03 07:18:26 ohwada Exp $

// 2007-10-30 K.OHWADA
// support published expired
// reference WfdownloadsDownloadHandler::getActiveCriteria()

// 2007-05-12 K.OHWADA
// date is null when import from mydownloads

// 2006-09-18 K.OHWADA
// BUG 4260: forget to remove debug print

//================================================================
// What's New Module
// get aritciles from module
// for WFdownloads 3.10 <http://www.smartfactory.ca/>
// 2006-08-07 K.OHWADA
//================================================================

function wfdownloads_new($limit=0, $offset=0)
{
	global $xoopsDB, $xoopsModule, $xoopsUser;

	$URL_MOD = XOOPS_URL."/modules/wfdownloads";

	$myts =& MyTextSanitizer::getInstance();

	$table_downloads = $xoopsDB->prefix('wfdownloads_downloads');
	$table_cat       = $xoopsDB->prefix('wfdownloads_cat');

	$modhandler = &xoops_gethandler('module');
	$xoopsModule = &$modhandler->getByDirname("wfdownloads");
	$mid = $xoopsModule->getVar('mid');

	$config_handler = &xoops_gethandler('config');
	$xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

	$groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
	$gperm_handler = &xoops_gethandler('groupperm'); 

// WFD 3.1
	$allowed_cats = $gperm_handler->getItemIds("WFDownCatPerm", $groups, $mid);
	$active_cid   = "d.cid IN (". implode(',', $allowed_cats) .")";

// date is null when import from mydownloads
	$time = time();
	$sql  = "SELECT d.*, d.title as dtitle, c.title as ctitle ";
	$sql .= "FROM " . $table_downloads . " d, ";
	$sql .= $table_cat . " c ";
	$sql .= "WHERE d.cid = c.cid AND ";
	$sql .= "d.status > 0 AND ";
	$sql .= "d.offline = 0  AND ";
	$sql .= "d.published > 0 AND d.published <= " . $time . " AND ";
	$sql .= "( d.expired = 0 OR d.expired >= " . $time . " ) AND ";
	$sql .= $active_cid." ";
	$sql .= "ORDER BY d.date DESC, d.updated DESC, d.published DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
 		$lid = $row['lid'];
		$ret[$i]['link']     = $URL_MOD."/singlefile.php?lid=".$lid;
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];

		$ret[$i]['title']    = $row['dtitle'];
		$ret[$i]['cat_name'] = $row['ctitle'];

		$ret[$i]['hits'] = $row['hits'];

// atom feed
		$ret[$i]['id'] = $lid;
		$ret[$i]['description'] = $myts->makeTareaData4Show( $row['description'], 0 );	//no html

// time
		$time = $row['date'];
		if ($row['updated'] > $time)
		{
			$time = $row['updated'];
		}
		if ($row['published'] > $time)
		{
			$time = $row['published'];
	   	}

	   	$ret[$i]['time']     = $time;
		$ret[$i]['modified'] = $time;
		$ret[$i]['issued']   = $row['published'];

		$ret[$i]['uid'] = $row['submitter'];

		$i++;

// check limit
		if ( ($limit > 0) && ($i >= $limit) )  break;
	}

	return $ret;
}

?>
