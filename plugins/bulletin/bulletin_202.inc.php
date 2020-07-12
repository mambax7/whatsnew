<?php
// $Id: bulletin_202.inc.php,v 1.1 2006/12/25 04:27:27 ohwada Exp $

// 2006-12-20 K.OHWADA
// bulletin 2.02

// 2006-06-18 K.OHWADA
// this new file

//================================================================
// What's New Module
// get aritciles from module
// for bulletin 1.05 <http://www.suin.jp/>
// 2006-06-18 K.OHWADA
//================================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( __FILE__ ) ) ;
if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// --- eval begin ---
eval( '

function bulletin'.$mydirnumber.'_new($limit=0, $offset=0)
{
	return bulletin_new_base( "'.$mydirname.'" , "'.$mydirnumber.'" , $limit, $offset );
}

' ) ;
// --- eval end ---

// --- bulletin_new_base begin ---
if( ! function_exists( 'bulletin_new_base' ) ) 
{

function bulletin_new_base($mydirname, $mydirnumber, $limit=0, $offset=0)
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

// DB table name
	$table_stories  = $xoopsDB->prefix( "bulletin{$mydirnumber}_stories" ) ;
	$table_topics   = $xoopsDB->prefix( "bulletin{$mydirnumber}_topics" ) ;

	$sql  = sprintf('SELECT s.storyid, s.topicid, s.title, s.hometext, s.bodytext, s.published, s.expired, s.counter, s.comments, s.uid, s.topicimg, s.html, s.smiley, s.br, s.xcode, t.topic_title, t. topic_imgurl FROM %s s, %s t WHERE s.published < %u AND s.published > 0 AND (s.expired = 0 OR s.expired > %3$u) AND s.topicid = t.topic_id AND s.ihome = 1 ORDER BY %s DESC', $table_stories, $table_topics, time(), 'published' );

	$result = $xoopsDB->query($sql, $limit, $offset);

	$URL_MOD = XOOPS_URL."/modules/".$mydirname;

	$i = 0;
	$ret = array();

	while( $row = $xoopsDB->fetchArray($result))
	{
		$id     = $row['storyid'];
		$catid  = $row['topicid'];

// bulletin 2.02
		$ret[$i]['link']     = $URL_MOD."/index.php?page=article&storyid=".$id;
	    $ret[$i]['pda']      = $URL_MOD."/index.php?page=print&storyid=1=".$id;

		$ret[$i]['cat_link'] = $URL_MOD."/index.php?storytopic=".$catid;
		$ret[$i]['title']    = $row['title'];
		$ret[$i]['cat_name'] = $row['topic_title'];
		$ret[$i]['time'] = $row['published'];
		$ret[$i]['uid']  = $row['uid'];
		$ret[$i]['hits'] = $row['counter'];
		$ret[$i]['id']   = $id;

// description
		$html   = $row['html'];
		$smiley = $row['smiley'];
		$xcode  = $row['xcode'];
		$image  = 1;
		$br     = $row['br'];

		$desc = $row['hometext'];
		$desc = $myts->displayTarea($desc, $html, $smiley, $xcode, $image, $br);
		$ret[$i]['description'] = $desc;

		$i++;
	}

	return $ret;
}

}
// --- piCal_new_base end ---

?>