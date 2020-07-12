<?php
// $Id: data.inc.php,v 1.7 2008/11/09 03:05:16 ohwada Exp $

// 2008-11-09 K.OHWADA
// typo

// 2007-10-10 K.OHWADA
// convert bb_code
// give up other text filter

// 2005-10-23 K.OHWADA
// bug: limit dont work

// 2005-10-10 K.OHWADA
// category
// duplicatable module

//================================================================
// What's New Module
// get aritciles from module
// wordpress 0.50 <http://www.kowa.org/>
// 2004-11-19 Hiroshi Uei <http://geomag.tea4you.net/>
//================================================================
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( __FILE__ ) ) ;

eval( '

function '.$mydirname.'_new($limit=0, $offset=0){
	return _wordpress_new("'.$mydirname.'" ,$limit, $offset ) ;
}

' ) ;

if ( !function_exists('_wordpress_new') )
{

// --- function start ---
function _wordpress_new($mydirname, $limit=0, $offset=0) 
{
// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	global $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();

	$url_mod = XOOPS_URL."/modules/".$mydirname;

	$table_options    = $xoopsDB->prefix("wp".$mydirnumber."_options");
	$table_posts      = $xoopsDB->prefix("wp".$mydirnumber."_posts");
	$table_categories = $xoopsDB->prefix("wp".$mydirnumber."_categories");
	$table_post2cat   = $xoopsDB->prefix("wp".$mydirnumber."_post2cat");

// option table
	$options = array();
	$sql0 = "SELECT * FROM ".$table_options;
	$res0 = $xoopsDB->query($sql0);
	while($row0 = $xoopsDB->fetchArray($res0))
	{
		$options[ $row0['option_name'] ] = $row0['option_value'];
	}
	$use_bbcode      = $options['use_bbcode'];
	$time_difference = $options['time_difference'];

	$now = date('Y-m-d H:i:s', (time() + ($time_difference * 3600)) );

// posts table
	$sql1  = "SELECT ID, post_author, post_title, post_content, UNIX_TIMESTAMP(post_date) AS unix_post_date, UNIX_TIMESTAMP(post_modified) AS unix_post_modified, post_status FROM ".$table_posts;
	$sql1 .= " WHERE post_status='publish' AND (post_date <= '". $now . "')";
	$sql1 .= " ORDER BY post_date DESC";

	$res1 = $xoopsDB->query($sql1, $limit, $offset);

	$i = 0;
	$ret = array();

	while($row1 = $xoopsDB->fetchArray($res1))
	{
		$id = $row1['ID'];

		$sql2 = "SELECT c.cat_ID, c.cat_name FROM ".$table_categories." c, ".$table_post2cat." p2c WHERE c.cat_ID = p2c.category_id AND p2c.post_id=".$id;
		$row2 = $xoopsDB->fetchArray( $xoopsDB->query($sql2) );

		$ret[$i]['link']     = $url_mod."/index.php?p=".$id;
		$ret[$i]['cat_link'] = $url_mod."/index.php?cat=".$row2['cat_ID'];

		$ret[$i]['title']    = $row1['post_title'];
		$ret[$i]['cat_name'] = $row2['cat_name'];

		$ret[$i]['uid'] = $row1['post_author'];

// time
		if ($row1['unix_post_modified'] > $row1['unix_post_date']) {
			$time = $row1['unix_post_modified'];
		} else {
			$time = $row1['unix_post_date'];
		}
	   	$ret[$i]['time']     = $time;
		$ret[$i]['modified'] = $time;

		$ret[$i]['issued']   = $row1['unix_post_date'];

// description
		if ( $use_bbcode ) {
			$desc = $myts->makeTareaData4Show( $row1['post_content'], 1 );	// allow html
		} else {
			$desc = $row1['post_content'];
		}
		$ret[$i]['description'] = $desc;

		$i++;
	}

	return $ret;
}

function _wordpress_num($mydirname) 
{
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("wp".$mydirnumber."_posts")." ORDER BY ID";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function _wordpress_data($mydirname,$limit=0, $offset=0) 
{
	// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	global $xoopsDB;

	$sql = "SELECT ID, post_title, UNIX_TIMESTAMP(post_date) AS unix_post_date, post_status FROM ".$xoopsDB->prefix("wp".$mydirnumber."_posts")." WHERE post_status='publish' ORDER BY ID";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($row1 = $xoopsDB->fetchArray($result))
	{
		$id = $row1['ID'];
		$ret[$i]['id'] = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/wordpress/index.php?p=".$id."";
		$ret[$i]['title'] = $row1['post_title'];
		$ret[$i]['time']  = $row1['unix_post_date'];
		$i++;
	}

	return $ret;

}

// --- function end ---

}

?>