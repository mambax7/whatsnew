<?php
// $Id: data.inc.php,v 1.4 2005/11/23 05:58:28 ohwada Exp $

// 2005-11-23 K.OHWADA
// BUG 3221: show twice of limit

// 2005-10-19 K.OHWADA
// description with xcodes
// category, counter
// permission check

// 2005-07-14 K.OHWADA
// change name to answer

//================================================================
// What's New Module
// get aritciles from module
// for smartFAQ 1.04 <http://www.smartfactory.ca/>
// 2005-06-28 Ayou42 <http://ayou42.free.fr/>
//================================================================

function smartfaq_new($limit=0, $offset=0)
{
    global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$URL_MOD = XOOPS_URL."/modules/smartfaq";

//   $sql = "SELECT T1.faqid , T1.question , T1.datesub , T1.status , T1.counter , T2.name FROM " . $xoopsDB->prefix('smartfaq_faq')." T1 , " . $xoopsDB->prefix('smartfaq_categories')." T2 WHERE T1.categoryid = T2.categoryid  ORDER BY T1.datesub DESC";

   $sql = "SELECT f.faqid, f.categoryid, f.question, f.datesub, f.status, f.counter, f.html, f.smiley, f.xcodes, f.image, f.linebreak, a.answer, a.uid, c.name FROM " . $xoopsDB->prefix('smartfaq_faq')." f , " . $xoopsDB->prefix('smartfaq_answers')." a, ".$xoopsDB->prefix('smartfaq_categories')." c WHERE f.faqid = a.faqid AND f.categoryid = c.categoryid AND ( f.status = 5 OR f.status = 6 ) ORDER BY f.datesub DESC";

// get twice records 
	$result = $xoopsDB->query($sql, 2*$limit, $offset);

	$module_handler = &xoops_gethandler('module');
	$module = $module_handler->getByDirname('smartfaq');
	$mid    = $module->getVar('mid');

	$gperm_handler = &xoops_gethandler('groupperm');

	global $xoopsUser;
	if ( is_object($xoopsUser) )
	{
		$groups = $xoopsUser->getGroups();
	}
	else
	{
		$groups = XOOPS_GROUP_ANONYMOUS;
	}

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
		$faqid = $row['faqid'];
		$catid = $row['categoryid'];

// permission
 		if ( !$gperm_handler->checkRight('category_read', $catid, $groups, $mid) )
 		{
 			continue;
 		}

 		if ( !$gperm_handler->checkRight('item_read', $faqid, $groups, $mid) )
 		{
 			continue;
 		}

 		$faqid = $row['faqid'];
		$ret[$i]['link']     = $URL_MOD."/faq.php?faqid=".$faqid;
		$ret[$i]['cat_link'] = $URL_MOD."/category.php?categoryid=".$catid;
		$ret[$i]['title']    = $row['question'];
		$ret[$i]['cat_name'] = $row['name'];
		$ret[$i]['time']     = $row['datesub'];
	   	$ret[$i]['hits']     = $row['counter'];
	   	$ret[$i]['uid']      = $row['uid'];
		$ret[$i]['id']       = $faqid;

// description
		$html   = 0;
		$smiley = 0;
		$xcodes = 0;
		$image  = 0;
		$br     = 0;

		if ( $row['html'] )       $html   = 1;
		if ( $row['smiley'] )     $smiley = 1;
		if ( $row['xcodes'] )     $xcodes = 1;
		if ( $row['image'] )      $image  = 1;
		if ( $row['linebreak'] )  $br     = 1;

		$ret[$i]['description'] = 
			$myts->displayTarea($row['answer'], $html, $smiley, $xcodes, $image, $br);

		$i++;

// BUG 3221: show twice of limit
		if (($limit > 0) && ($i >= $limit))  break;
	}

	return $ret;
}

?>
