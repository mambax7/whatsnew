<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-10 K.OHWADA
// category, counter

// 2005-09-28 K.OHWADA
// undefined constant WFS_ARTICLE_DB

// 2005-07-14 K.OHWADA
// add PDA
// add atom items
// check the showing property

//================================================================
// What's New Module
// get aritciles from module
// for WFsection 2.07 <http://www.wf-projects.com/>
// 2005-06-28 Ayou42 <http://ayou42.free.fr/>
//================================================================

function wfsection_new($limit=0, $offset=0)
{
    global $xoopsDB, $xoopsUser;

	$URL_MOD = XOOPS_URL."/modules/wfsection";

	$myts =& MyTextSanitizer::getInstance();

    $modhandler2  = &xoops_gethandler('module');
    $xoopsModule2 = &$modhandler2->getByDirname("wfsection");
    $mid = $xoopsModule2->getVar('mid');

    $groups = (is_object($xoopsUser)) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler = &xoops_gethandler('groupperm'); 

// undefined constant WFS_ARTICLE_DB
    $sql = "SELECT a.articleid, a.categoryid, a.uid, a.title as atitle, a.maintext, a.nohtml, a.nosmiley, a.noxcodes, a.nobreaks, a.created, a.changed, a.published, a.counter, c.title as ctitle FROM ". $xoopsDB->prefix('wfs_article') ." a, ". $xoopsDB->prefix('wfs_category') ." c WHERE a.categoryid = c.id AND (a.expired = 0 OR a.expired > ". time() .") AND a.noshowart = 0 AND a.offline = 0 ORDER BY a.published DESC";

// get records 
	$result = $xoopsDB->query($sql, 2*$limit, $offset);

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
 		$articleid = $row['articleid'];

// check permission
//		if ( !$gperm_handler->checkRight('wfs_permissions', $articleid, $groups, $mid) )
//		{	continue;	}

		$ret[$i]['link'] = $URL_MOD."/article.php?articleid=".$articleid;
	    $ret[$i]['pda']  = $URL_MOD."/print.php?articleid=".$articleid;
	    $ret[$i]['cat_link'] = $URL_MOD."/viewarticles.php?category=".$row['categoryid'];

		$ret[$i]['title']    = $row['atitle'];
		$ret[$i]['cat_name'] = $row['ctitle'];

		$ret[$i]['hits'] = $row['counter'];

// atom feed
		$ret[$i]['id']       = $articleid;
	   	$ret[$i]['uid']      = $row['uid'];

// time
		if ($row['changed'] > $row['published'])
		{
			$time = $row['changed'];
		}
		else
		{
			$time = $row['published'];
	   	}

	   	$ret[$i]['time']     = $time;
		$ret[$i]['modified'] = $time;
		$ret[$i]['issued']   = $row['published'];
		$ret[$i]['created']  = $row['created'];

// description
		$html   = 1;
		$smiley = 1;
		$xcodes = 1;
		$image  = 1;
		$br     = 1;

		if ( $row['nohtml'] )	$html   = 0;
		if ( $row['nosmiley'] )	$smiley = 0;
		if ( $row['noxcodes'] )	$xcodes = 0;
		if ( $row['nobreaks'] )	$br     = 0;

		$maintext    = $row['maintext'];
		$maintextarr = explode("[pagebreak]", $maintext);
		$maintext    = $maintextarr[0];

		$maintext = $myts->displayTarea($maintext, $html, $smiley, $xcodes, $image, $br);
		$ret[$i]['description'] = $maintext;

		$i++;

// check limit
		if ( ($limit > 0) && ($i >= $limit) )  break;
	}

	return $ret;
}

?>
