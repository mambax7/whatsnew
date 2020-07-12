<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// simpleblog 0.21 <http://sourceforge.jp/projects/xoops-modules/>
// 2005.03.02 Hodaka <http://www.kuri3.net>
//================================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
include_once XOOPS_ROOT_PATH.'/modules/simpleblog/SimpleBlogUtils.php';
include_once XOOPS_ROOT_PATH.'/modules/simpleblog/simpleblog.php';

function simpleblog_new($limit=0, $offset=0) {

	global $xoopsUser, $xoopsDB;
	$result = array();
	SimpleBlogUtils::assign_message($result);
	$result['simpleblog'] = SimpleBlogUtils::get_blog_list();

	$i = 0;
	$ret = array();
	for( $j=$offset;$j<$limit;$j++ ) {
		if( $j >= count($result['simpleblog']) ) break;
		$ret[$i]['title'] = $result['simpleblog'][$j]['title'];
		$ret[$i]['link']  = $result['simpleblog'][$j]['url'];
		$ret[$i]['time']  = $result['simpleblog'][$j]['last_update'];
		// atom feed
		$ret[$i]['id'] = $result['simpleblog'][$j]['uid'];

		// get post_text
		$sql = "SELECT blog_date FROM ".$xoopsDB->prefix('simpleblog')." where uid = ".$result['simpleblog'][$j]['uid']." ORDER BY blog_date DESC LIMIT 1";
		if(!$res = $xoopsDB->query($sql)) break;
		list( $blog_date ) = $xoopsDB->fetchRow($res);
		list( $year, $month, $day ) = explode( "-", $blog_date );
		$dates['year'] = $year;
		$dates['month'] = $month;
		$dates['date'] = $day;

		$blog1 = new SimpleBlog( $result['simpleblog'][$j]['uid'] );
		$blog = $blog1->getBlog1($dates);
		$ret[$i]['description']  = $blog['text'];
		$i++;
	}

	return $ret;
}

function simple_num()
{

	global $xoopsUser;
	$result = array();
	SimpleBlogUtils::assign_message($result);
	$result['simpleblog'] = SimpleBlogUtils::get_blog_list();

	return count($result['simpleblog']);
}

function simplelog_data($limit=0, $offset=0)
{

	global $xoopsUser;
	$result = array();
	SimpleBlogUtils::assign_message($result);
	$result['simpleblog'] = SimpleBlogUtils::get_blog_list();

	$i = 0;
	$ret = array();
	for( $j=$offset; $j<$limit; $j++ ) {
		if( $j >= count($result['simpleblog']) ) break;
		$ret[$i]['id']  = $result['simpleblog'][$j]['uid'];
		$ret[$i]['title'] = $result['simpleblog'][$j]['title'];
		$ret[$i]['link']  = $result['simpleblog'][$j]['url'];
		$ret[$i]['time']  = $result['simpleblog'][$j]['last_update_m'];
		$i++;
	}
	return $ret;
}

?>
