<?php
// $Id: wfdownloads205_data.inc.php,v 1.1 2006/08/07 11:40:40 ohwada Exp $

// 2005-10-10 K.OHWADA
// category, counter

//================================================================
// What's New Module
// get aritciles from module
// for WFdownloads 2.05 <http://www.wf-projects.com/>
// 2005-06-20 K.OHWADA
//================================================================

function wfdownloads_new($limit=0, $offset=0)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;

	$URL_MOD = XOOPS_URL."/modules/wfdownloads";

	$myts =& MyTextSanitizer::getInstance();

    $modhandler = &xoops_gethandler('module');
    $xoopsModule = &$modhandler->getByDirname("wfdownloads");
    $mid = $xoopsModule->getVar('mid');
    
    $config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));

    $groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler = &xoops_gethandler('groupperm'); 

//	$sql = "SELECT lid, title, date, description FROM " . $xoopsDB->prefix('wfdownloads_downloads')." WHERE status > 0 AND offline = 0 ORDER BY date DESC";

	$sql = "SELECT d.lid, d.title as dtitle, d.date, d.updated, d.published, d.description, d.hits, d.submitter, d.cid, c.title as ctitle  FROM " . $xoopsDB->prefix('wfdownloads_downloads')." d, ".$xoopsDB->prefix("wfdownloads_cat")." c WHERE d.cid=c.cid AND d.status > 0 AND d.offline = 0 ORDER BY d.date DESC";

// get twice records 
	$result = $xoopsDB->query($sql, 2*$limit,$offset);

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
// check permission
		if ( !$gperm_handler->checkRight('WFDownFilePerm', $row['lid'], $groups, $mid) )
		{	continue;	}

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
		if ($row['updated'] > $row['date'])
		{
			$time = $row['updated'];
		}
		else
		{
			$time = $row['date'];
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
