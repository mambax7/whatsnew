<?php
// $Id: data.inc.php,v 1.10 2008/05/24 17:37:19 ohwada Exp $

// 2008-05-24 K.OHWADA
// check file_exists

// 2006-11-18 K.OHWADA
// BUG 4377: bbcode is showing without rendering

// 2005-12-30 K.OHWADA
// REQ 3383: module duplication
// REQ 3384: check repeat rule & public/private class

// 2005-11-23 K.OHWADA
// 2005-11-01 K.OHWADA
// BUG 3152: show twice of limit

// 2005-10-23 K.OHWADA
// categoy, uid, permission

// 2005-09-28 K.OHWADA
// BUG 3037: XML format error

// 2005-09-15 K.OHWADA
// use UNIX_TIMESTAMP

// 2005-07-14 K.OHWADA
// change description in french style to universal style

//================================================================
// What's New Module
// get aritciles from module
// for piCal 0.8 <http://www.peak.ne.jp/xoops/>
// 2005-06-28 Ayou42 <http://ayou42.free.fr/>
//================================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// REQ 3383: module duplication
$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( 'invalid dirname: ' . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// --- eval begin ---
eval( '

function piCal'.$mydirnumber.'_new($limit=0, $offset=0)
{
	return piCal_new_base( "'.$mydirname.'" , "'.$mydirnumber.'" , $limit, $offset );
}

' ) ;
// --- eval end ---

// --- piCal_new_base begin ---
if( ! function_exists( 'piCal_new_base' ) ) 
{

function piCal_new_base($mydirname, $mydirnumber, $limit=0, $offset=0)
{
    global $xoopsDB, $xoopsConfig, $xoopsUser;

// setting physical & virtual paths
	$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;
	$MOD_URL  = XOOPS_URL       .'/modules/'. $mydirname;

	$table_event = $xoopsDB->prefix("pical{$mydirnumber}_event");
	$table_cat   = $xoopsDB->prefix("pical{$mydirnumber}_cat");

	$myts =& MyTextSanitizer::getInstance();

// use piCal class
// defining class of piCal
	if( ! class_exists( 'piCal_xoops' ) ) 
	{

// check file_exists
		if ( file_exists( $MOD_PATH .'/class/piCal.php' ) ) {
			require_once( $MOD_PATH .'/class/piCal.php' ) ;
			require_once( $MOD_PATH .'/class/piCal_xoops.php' ) ;
		} else {
			return false;
		}
	}

// creating an instance of piCal 
	$cal = new piCal_xoops( '' , $xoopsConfig['language'] , true ) ;
	$cal->use_server_TZ = true ;

// setting properties of piCal
	$cal->conn = $xoopsDB->conn ;

// set $isadmin & others
	include( $MOD_PATH .'/include/read_configs.php' ) ;

	$cal->images_url  = $MOD_URL  .'/images/'. $skin_folder;
	$cal->images_path = $MOD_PATH .'/images/'. $skin_folder;

	$whr_categories = $cal->get_where_about_categories() ;
	$whr_class      = $cal->get_where_about_class() ;
	$categories     = $cal->categories;

// use UNIX_TIMESTAMP
// REQ 3384: check repeat rule & public/private class
	$sql1 = "SELECT id, uid, summary, location, description, categories, start, end, UNIX_TIMESTAMP(dtstamp) as dtstamp FROM ".$table_event." WHERE admission>0 AND (rrule_pid=0 OR rrule_pid=id) AND ($whr_categories) AND ($whr_class) ORDER BY dtstamp DESC";

// get twice records 
	$res1 = $xoopsDB->query($sql1, 2*$limit, $offset);

	$i = 0;
	$ret = array();

	while( $row1 = $xoopsDB->fetchArray($res1) )
	{
		$ret[$i] = array();

		$id = $row1['id'];
		$cid_arr_1 = split(',', $row1['categories']);

// remove garbage 
		$cid_arr_2 = array();
		foreach ($cid_arr_1 as $cid)
		{
			$cid = intval($cid);

			if ($cid)
			{
				$cid_arr_2[] = $cid;
			}
		}

		if ( count($cid_arr_2) )
		{

			$flag_perm = false;
			asort($cid_arr_2);

// category permission
			foreach( $cid_arr_2 as $cid ) 
			{
				$cid = intval( $cid ) ;
			
				if( isset( $categories[ $cid ] ) )
				{
					$cat_title = $categories[ $cid ]->cat_title;
	 				$flag_perm = true;
	 				break;
				}
			}

// check OK
			if ( $flag_perm )
			{
				$ret[$i]['cat_link'] = $MOD_URL .'/index.php?cid='. $cid;
				$ret[$i]['cat_name'] = $cat_title;
			}
		}

// BUG 3037: XML format error
		$ret[$i]['link'] = $MOD_URL .'/index.php?action=View&amp;event_id='. $id;

		$ret[$i]['title'] = $row1['summary'];

// time
// use UNIX_TIMESTAMP
		$ret[$i]['time'] = $row1['dtstamp'];

// description
		$desc = '';

		if ( $row1['description'] )
		{
// BUG 4377: bbcode is showing without rendering
			$desc .= $myts->displayTarea($row1['description'], 0, 1, 1, 1, 1) .': ';
		}

		if ( $row1['location'] )
		{
			$desc .= $row1['location'].': ';
		}

		if ( $row1['start'] )
		{
			$desc .= date("Y-m-d H:i", $row1['start']);
		}

		if ( $row1['end'] )
		{
			$desc .= ' - '. date("Y-m-d Y H:i", $row1['end']);
		}

		$ret[$i]['description'] = $desc;

// atom feed
		$ret[$i]['uid'] = $row1['uid'];
		$ret[$i]['id']  = intval($id);

		$i++;

// BUG 3152: show twice of limit
		if (($limit > 0) && ($i >= $limit))  break;
	}

	return $ret;
}

}
// --- piCal_new_base end ---

?>