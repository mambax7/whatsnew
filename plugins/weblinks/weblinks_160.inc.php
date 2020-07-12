<?php
// $Id: weblinks_160.inc.php,v 1.2 2007/10/22 02:52:43 ohwada Exp $

// 2007-10-10 K.OHWADA
// banner

// 2007-08-01 K.OHWADA
// weblinks 1.60
// georss

// 2007-02-12 K.OHWADA
// weblinks 1.30
// time_publish time_expire

// 2006-01-27 K.OHWADA
// weblinks 1.00
// module depulication

// 2005-10-01 K.OHWADA
// category, counter

// 2004/08/20 K.OHWADA
// atom feed

// 2004/08/10 K.OHWADA
// enable to install this module two or more. 
// not use class weblinksLink

//================================================================
// What's New Module
// get aritciles from module
// WebLinks 0.94 <http://linux2.ohwada.net/>
// 2004/01/03 K.OHWADA
//================================================================

$dirname = basename( dirname( __FILE__ ) ) ;

// --- eval begin ---
eval( '

function '.$dirname.'_new( $limit=0 , $offset=0 )
{
	return weblinks_base_new( "'.$dirname.'", $limit , $offset );
}

function '.$dirname.'_num()
{
	return weblinks_base_num( "'.$dirname.'" );
}

function '.$dirname.'_data( $limit=0 , $offset=0 )
{
	return weblinks_base_data( "'.$dirname.'", $limit , $offset );
}

' ) ;
// --- eval end ---

// === weblinks_base_new ===
if( ! function_exists( 'weblinks_base_new' ) ) 
{

function weblinks_base_new($dirname, $limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$BROKEN = 5;

	$weblinks_url = XOOPS_URL.'/modules/'.$dirname;
	$table_link     = $xoopsDB->prefix( $dirname.'_link' );
	$table_category = $xoopsDB->prefix( $dirname.'_category' );
	$table_catlink  = $xoopsDB->prefix( $dirname.'_catlink' );

	$i = 0;
	$ret = array();

// v1.30
	$time   = time();
	$where  =    ' ( broken = 0 OR broken < '. $BROKEN .' ) ';
	$where .= 'AND ( time_publish = 0 OR time_publish < '. $time .' ) ';
	$where .= 'AND ( time_expire = 0 OR time_expire > '. $time .' ) ';

	$sql1  = 'SELECT * FROM '. $table_link;
	$sql1 .= ' WHERE '. $where;
	$sql1 .= ' ORDER BY time_update DESC';

	$res1 = $xoopsDB->query($sql1, $limit, $offset);

	while( $row1 = $xoopsDB->fetchArray($res1) )
	{
		$lid = $row1['lid'];
	
		$sql2 = "SELECT c1.cid, c1.title as cattitle FROM ".$table_category." c1, ".$table_catlink." c2 WHERE c1.cid=c2.cid AND c2.lid=".$lid;
		$row2 = $xoopsDB->fetchArray( $xoopsDB->query($sql2) );

		$link     = $weblinks_url."/singlelink.php?lid=".$lid;
		$cat_link = $weblinks_url."/viewcat.php?cid=".$row2['cid'];
		$desc     = $myts->makeTareaData4Show( $row1['description'], 0 );	// no html

		$arr = array(
			'link'     => $link,
			'cat_link' => $cat_link,
			'title'    => $row1['title'],
			'time'     => $row1['time_update'],
			'cat_name' => $row2['cattitle'],
			'hits'     => $row1['hits'],

// atom feed
			'id'          => $lid,
			'modified'    => $row1['time_update'],
			'issued'      => $row1['time_create'],
			'created'     => $row1['time_create'],
			'description' => $desc,

// banner
			'banner_url'    => $row1['banner'],
			'banner_width'  => $row1['width'],
			'banner_height' => $row1['height'],
		);

// geo rss
		if (( $row1['gm_latitude'] != 0 )||( $row1['gm_longitude'] != 0 )||( $row1['gm_zoom'] != 0 ))
		{
			$arr['geo_lat']  = floatval( $row1['gm_latitude'] );
			$arr['geo_long'] = floatval( $row1['gm_longitude'] );
		}

		$ret[$i] = $arr;
		$i++;
	}

	return $ret;
}

function weblinks_base_num( $dirname )
{
	global $xoopsDB;
	$table_link = $xoopsDB->prefix( $dirname.'_link' );

	$sql    = "SELECT count(*) FROM $table_link";
	$result = $xoopsDB->query($sql, 0, 0);
	$array  = $xoopsDB->fetchRow($result);
	$num    = $array[0];
	if (empty($num)) $num = 0;

	return $num;
}

function weblinks_base_data($dirname, $limit=0, $offset=0)
{
	global $xoopsDB;

	$weblinks_url = XOOPS_URL.'/modules/'.$dirname;
	$table_link   = $xoopsDB->prefix( $dirname.'_link' );

	$i = 0;
	$ret = array();

	$sql = "SELECT * FROM $table_link ORDER BY lid";
	$result = $xoopsDB->query($sql, $limit, $offset);

	while( $row = $xoopsDB->fetchArray($result) )
	{
		$id = $row['lid'];
		$ret[$i]['id']   = $id;
		$ret[$i]['link'] = $weblinks_url."/singlelink.php?lid=$id";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['time_update'];
		$i++;
	}

	return $ret;
}

// === weblinks_base_new ===
}

?>