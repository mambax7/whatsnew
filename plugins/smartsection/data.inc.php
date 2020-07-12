<?php
// $Id: data.inc.php,v 1.2 2007/05/15 05:24:26 ohwada Exp $

// 2007-05-12
// check file_exists

//================================================================
// What's New Module
// get aritciles from module
// for SmartSection 1.05 <http://www.smartfactory.ca/>
// 2006-01-27 K.OHWADA
//================================================================

//---------------------------------------------------------
// base smartsection_items_recent_show
//---------------------------------------------------------
function smartsection_new($limit=0, $offset=0)
{
// check file_exists, if missed to remove files
	if ( file_exists(XOOPS_ROOT_PATH.'/modules/smartsection/include/common.php') ) 
	{
		include_once(XOOPS_ROOT_PATH."/modules/smartsection/include/common.php");
	}
	else
	{
		return false;
	}

	$URL_MOD = XOOPS_URL.'/modules/smartsection';
	$CATEGORYID = -1;
	$SORT       = 'datesub';

	$myts = &MyTextSanitizer::getInstance();

	$smartModule =& smartsection_getModuleInfo();

	$ret = array();

	$order = smartsection_getOrderBy($SORT);	
	$smartsection_item_handler =& smartsection_gethandler('item');
	$itemsObj = $smartsection_item_handler->getAllPublished($limit, $offset, $CATEGORYID, $SORT, $order);
	$totalItems = count($itemsObj);

	if (!$itemsObj || ($totalItems <= 0) )
	{
		return $ret;
	}

	for ( $i = 0; $i < $totalItems; $i++ ) 
	{
		$itemid       = $itemsObj[$i]->itemid();
		$title        = $itemsObj[$i]->title();
		$categoryname = $itemsObj[$i]->getCategoryName();
		$categoryid   = $itemsObj[$i]->categoryid();
		$uid          = $itemsObj[$i]->uid();
		$itemlink     = $itemsObj[$i]->getItemLink();
		$categorylink = $itemsObj[$i]->getCategoryLink();
		$body         = $itemsObj[$i]->body();
		$counter      = $itemsObj[$i]->counter();
		$date         = $itemsObj[$i]->getVar('datesub', 'n');

		$ret[$i]['link'] = $URL_MOD.'/item.php?itemid='.$itemid;
		$ret[$i]['pda']  = $URL_MOD.'/print.php?itemid='.$itemid;
		$ret[$i]['cat_link'] = $URL_MOD.'/category.php?categoryid='.$categoryid;
		$ret[$i]['title']    = $title;
		$ret[$i]['cat_name'] = $categoryname;
		$ret[$i]['id']       = $itemid;
		$ret[$i]['uid']      = $uid;
		$ret[$i]['time']     = $date;
		$ret[$i]['hits']     = $counter;
		$ret[$i]['description'] = $body;

// check limit
		if ( ($limit > 0) && ($i >= $limit) )  break;
	}

	return $ret;
}

?>