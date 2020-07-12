<?php
// $Id: d3forum_070_2.inc.php,v 1.1 2007/12/22 10:01:47 ohwada Exp $

// === option begin ===
$category_option = '';
//表示するカテゴリー番号をカンマ(,)で区切って記入。空欄なら全カテゴリー表示。

$topic_option = '';
//空欄ならトピック毎の最新投稿を表示。1なら全投稿を表示。
// --- option end ---

//================================================================
// What's New Module
// get aritciles from module
// for d3forum 0.70
// by  photosite, http://www.photositelinks.com/
//================================================================

// 2007-12-19 photosite
// check by validate_id()

// 2007-12-16 photosite
// for whatsnew 2.40(guest permissions)

// 2007-05-19 photosite
// topic option

// 2007-05-19 photosite
// category option

// 2007-05-11 photosite
// check by approval

// 2007-05-10 photosite
// check by category forum permissions

// 2007-05-01 photosite
// bug fix description

$mydirname = basename( dirname( __FILE__ ) ) ;

// === eval begin ===
eval( '

function '.$mydirname.'_new( $limit=0, $offset=0 )
{
	return d3forum_whatsnew_base( "'.$mydirname.'", "'.$category_option.'", "'.$topic_option.'", $limit, $offset ) ;
}

' ) ;
// --- eval end ---

// === d3forum_whatsnew_base begin ===
if (! function_exists('d3forum_whatsnew_base')) {
	function d3forum_whatsnew_base( $mydirname, $category_option, $topic_option, $limit=0, $offset=0 )
	{
		global $xoopsUser ;

		$db =& Database::getInstance();
		$myts =& MyTextSanitizer::getInstance();
		$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname($mydirname);
		$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

		$permit = d3forum_whatsnew_get_permit( $mydirname );
		// forums can be read by current viewer (check by forum_access)
		$whr_forum = "t.forum_id IN (".implode(",",d3forum_whatsnew_forums_can_read( $mydirname, $permit )).")" ;

		$categories = empty( $category_option ) ? array() : explode(',',$category_option) ;
		// categories
		if( empty( $categories ) ) {
			$whr_categories = '1' ;
		} else {
			for( $i = 0 ; $i < count( $categories ) ; $i ++ ) {
				$categories[ $i ] = intval( $categories[ $i ] ) ;
			}
			$whr_categories = 'f.cat_id IN ('.implode(',',$categories).')' ;
		}

		if( $topic_option  == '1' ) {
			$sql = "SELECT p.topic_id, p.post_id, p.uid, p.subject, p.post_time, p.html, p.smiley, p.xcode, p.br, p.invisible, p.approval, p.post_text, t.topic_id, t.topic_views, t.topic_posts_count, t.topic_invisible, t.topic_external_link_id, f.forum_id, f.forum_title, f.forum_external_link_format FROM ".$db->prefix($mydirname."_posts")." p LEFT JOIN ".$db->prefix($mydirname."_topics")." t ON p.topic_id=t.topic_id LEFT JOIN ".$db->prefix($mydirname."_forums")." f ON f.forum_id=t.forum_id WHERE ! t.topic_invisible AND ! p.invisible AND p.approval AND ($whr_forum) AND ($whr_categories) ORDER BY p.post_time DESC" ;
		} else {
			$sql = "SELECT p.topic_id, p.post_id, p.uid, p.subject, p.post_time, p.html, p.smiley, p.xcode, p.br, p.invisible, p.approval, p.post_text, t.topic_id, t.topic_views, t.topic_posts_count, t.topic_invisible, t.topic_last_post_id, t.topic_external_link_id, f.forum_id, f.forum_title, f.forum_external_link_format FROM ".$db->prefix($mydirname."_posts")." p LEFT JOIN ".$db->prefix($mydirname."_topics")." t ON p.topic_id=t.topic_id LEFT JOIN ".$db->prefix($mydirname."_forums")." f ON f.forum_id=t.forum_id WHERE ! t.topic_invisible AND ! p.invisible AND p.approval AND ($whr_forum) AND ($whr_categories) AND p.topic_id = t.topic_id AND t.topic_last_post_id = p.post_id ORDER BY p.post_time DESC" ;
		}

// get twice records 
		$result = $db->query($sql, 2*$limit, $offset);

		$URL_MOD = XOOPS_URL.'/modules/'.$mydirname;
		
		$i = 0;
		$ret = array();

		while ( $row = $db->fetchArray($result) ) 
		{
			$canread_topic = true ;
			if ( $row['forum_external_link_format'] ) {
				require_once XOOPS_TRUST_PATH.'/modules/d3forum/include/main_functions.php' ;
				$d3com =& d3forum_main_get_comment_object( $mydirname , $row['forum_external_link_format']);
				$canread_topic = $d3com->validate_id($row['topic_external_link_id']);
			}

			if ( $canread_topic || $permit ) {
				$topic_id = $row['topic_id'];
				$forum_id = $row['forum_id'];
				$post_id = $row['post_id'];
				$ret[$i]['link']  = $URL_MOD."/index.php?topic_id=".$topic_id."#post_id".$post_id;
				$ret[$i]['cat_link'] = $URL_MOD."/index.php?forum_id=".$forum_id;
				$ret[$i]['title'] = $myts->makeTboxData4Show($row['subject']);
				$ret[$i]['cat_name'] = $myts->makeTboxData4Show($row['forum_title']);
				$ret[$i]['time']  = $row['post_time'];
				$ret[$i]['hits'] = $row['topic_views'];
				$ret[$i]['replies'] = $row['topic_posts_count'] - 1;
				$ret[$i]['uid']  = $row['uid'];
				$ret[$i]['id']  = $topic_id;

// description
				$html   = 0;
				$smiley = 0;
				$xcode  = 0;
				$br     = 0;
				$image  = 0;

				if ( $row['html'] )   $html   = 1;
				if ( $row['smiley'] ) $smiley = 1;
				if ( $row['xcode'] )  $xcode  = 1;
				if ( $row['br'] )     $br     = 1;
				if ( $config['allow_textimg'] )  $image  = 1;
				$desc = d3forum_whatsnew_quoteDecode($row['post_text']);
				$ret[$i]['description']  = $myts->displayTarea( $desc, $html, $smiley, $xcode, $image, $br);

				$i++;
				if (($limit > 0) && ($i >= $limit))  break;
			}
		}

		return $ret;
	}
}
// --- d3forum_whatsnew_base end ---

// === d3forum_whatsnew_forums_can_read begin ===
if (! function_exists('d3forum_whatsnew_forums_can_read')) {
	function d3forum_whatsnew_forums_can_read( $mydirname, $permit )
	{
		global $xoopsUser ;

		$db =& Database::getInstance() ;

		if( is_object( $xoopsUser ) ) {
			$uid = intval( $xoopsUser->getVar('uid') ) ;
			$groups = $xoopsUser->getGroups() ;
			if( ! empty( $groups ) ) {
				$whr4forum = "fa.`uid`=$uid || fa.`groupid` IN (".implode(",",$groups).")" ;
				$whr4cat = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
			} else {
				$whr4forum = "fa.`uid`=$uid" ;
				$whr4cat = "`uid`=$uid" ;
			}
		} else {
			if ( ! $permit ){
				$whr4forum = "fa.`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
				$whr4cat = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
			} else {
				$whr4forum = "fa.`groupid`=".intval(XOOPS_GROUP_USERS) ;
				$whr4cat = "`groupid`=".intval(XOOPS_GROUP_USERS) ;
			}
		}

		// get categories
		$sql = "SELECT distinct cat_id FROM ".$db->prefix($mydirname."_category_access")." WHERE ($whr4cat)" ;
		$result = $db->query( $sql ) ;
		if( $result ) while( list( $cat_id ) = $db->fetchRow( $result ) ) {
			$cat_ids[] = intval( $cat_id ) ;
		}
		if( empty( $cat_ids ) ) return array(0) ;

		// get forums
		$sql = "SELECT distinct f.forum_id FROM ".$db->prefix($mydirname."_forums")." f LEFT JOIN ".$db->prefix($mydirname."_forum_access")." fa ON fa.forum_id=f.forum_id WHERE ($whr4forum) AND f.cat_id IN (".implode(',',$cat_ids).')' ;
		$result = $db->query( $sql ) ;
		if( $result ) while( list( $forum_id ) = $db->fetchRow( $result ) ) {
			$forums[] = intval( $forum_id ) ;
		}

		if( empty( $forums ) ) return array(0) ;
		else return $forums ;
	}
}
// --- d3forum_whatsnew_forums_can_read end ---

// === d3forum_whatsnew_get_permit begin ===
if (! function_exists('d3forum_whatsnew_get_permit')) {
	function d3forum_whatsnew_get_permit( $mydirname )
	{
		global $xoopsUser ;
		
		if( is_object( $xoopsUser ) ) {
			return false;
		} else {
			$groups = intval( XOOPS_GROUP_ANONYMOUS );

			$db =& Database::getInstance() ;

			$module_handler =& xoops_gethandler('module');
			$module =& $module_handler->getByDirname($mydirname);
			$mid = intval( $module->getVar('mid'));
			$moduleperm_handler =& xoops_gethandler('groupperm');

			if ( $moduleperm_handler->checkRight('module_read', $mid, $groups) ){
				return false ;
			} else {
				$whatsnewdir = basename( dirname(dirname(dirname( __FILE__ ) ))) ;
				$whatsnewmodule =& $module_handler->getByDirname($whatsnewdir);
				$whatsnewver = intval( $whatsnewmodule->getVar('version'));

				if ( $whatsnewver >= 240 ){
					$permit_result = $db->query( "SELECT COUNT(*) FROM ".$db->prefix($whatsnewdir."_module")." WHERE mid = $mid AND permit = 1" );
					list($permit) = $db->fetchRow($permit_result);
				}

				if ( $permit ){
					return true ;
				} else {
					return false;
				}
			}
		}
	}
// --- d3forum_whatsnew_get_permit end ---
}

// === d3forum_whatsnew_quoteDecode begin ===
if (! function_exists('d3forum_whatsnew_quoteDecode')) {
	function d3forum_whatsnew_quoteDecode( $text )
	{
		$patterns = array();
		$replacements = array();

		// [quote sitecite=]
		$patterns[] = "/\[quote sitecite=([^\"'<>]*)\]/sU";
		$replacements[] = '[quote]';

	return preg_replace($patterns, $replacements, $text);
	}
}
// --- d3forum_whatsnew_quoteDecode end ---

?>
