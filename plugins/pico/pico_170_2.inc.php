<?php
// $Id: pico_170_2.inc.php,v 1.1 2008/10/11 09:59:20 ohwada Exp $

// === option begin ===
$category_option = '';
//表示するカテゴリー番号をカンマ(,)で区切って記入。空欄なら全カテゴリー表示。
// --- option end ---

//================================================================
// What's New Module
// get aritciles from module
// for pico <http://www.peak.ne.jp/xoops/>
// by  photosite <http://www.photositelinks.com/>
//================================================================

// 2008-9-30 photosite
// check by expiring_time

// 2007-12-16 photosite
// pico_whatsnew_get_permit(for whatsnew 2.40)

// 2007-12-12 photosite
// view_detail

// 2007-12-10 photosite
// replies

// 2007-06-15 photosite
// future timestamped

// 2007-05-25 photosite
// pico_whatsnew_filter_body

// 2007-05-19 photosite
// category option

// 2007-05-14 photosite
// modified, created

// 2007-05-13 photosite
// for textwiki

// 2007-05-08 photosite
// for pico 1.31 alpha

// 2007-05-06 photosite
// check by category_permissions

// 2007-05-05 photosite
// check by visible

$mydirname = basename( dirname( __FILE__ ) ) ;

// === eval begin ===
eval( '

function '.$mydirname.'_new( $limit=0, $offset=0 )
{
	return pico_whatsnew_base( "'.$mydirname.'", "'.$category_option.'", $limit, $offset ) ;
}

' ) ;
// --- eval end ---

// === pico_whatsnew_base begin ===
if (! function_exists('pico_whatsnew_base')) {
	function pico_whatsnew_base( $mydirname, $category_option, $limit=0, $offset=0 )
	{
		global $xoopsUser ;

		$db =& Database::getInstance() ;
		$myts =& MyTextSanitizer::getInstance();
		$uid = is_object( @$xoopsUser ) ? $xoopsUser->getVar('uid') : 0 ;

		$module_handler =& xoops_gethandler('module');
		$config_handler =& xoops_gethandler('config');
		$module =& $module_handler->getByDirname($mydirname);
		$mod_config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
		$version = intval( $module->getVar('version'));

		$permit = pico_whatsnew_get_permit( $mydirname );
		// categories can be read by current viewer (check by category_permissions)
		$whr_readcontent = 'o.`cat_id` IN (' . implode( "," , pico_whatsnew_categories_can_read( $mydirname , $uid ,$permit ) ) . ')' ;

		$categories = trim( @$category_option ) === '' ? array() : array_map( 'intval' , explode( ',' , $category_option ) ) ;
		// categories
		if( $categories === array() ) {
			$whr_categories = '1' ;
		} else {
			$whr_categories = 'o.cat_id IN ('.implode(',',$categories).')' ;
		}

		$sql = "SELECT  *  FROM ".$db->prefix($mydirname."_contents")." o LEFT JOIN ".$db->prefix($mydirname."_categories")." c ON o.cat_id=c.cat_id WHERE ($whr_readcontent) AND ($whr_categories) AND o.visible AND o.created_time <= UNIX_TIMESTAMP()" ;
		if ( $version >= 170 ){
			$sql .= " AND o.expiring_time > UNIX_TIMESTAMP()";
		}
		$sql .= " ORDER BY o.modified_time DESC";
		$result = $db->query($sql, $limit, $offset);

		$URL_MOD = XOOPS_URL.'/modules/'.$mydirname;

		// d3forum comment
		if( ! empty( $mod_config['comment_dirname'] ) && $mod_config['comment_forum_id'] > 0 ) {
			$replies = true ;
		} else {
			$replies = '' ;
		}

		$i = 0;
		$ret = array();

		while( $row = $db->fetchArray($result))
		{
			$id     = $row['content_id'];
			$cat_id     = $row['cat_id'];
			$ret[$i]['link']  =  $URL_MOD.'/'.pico_whatsnew_content_link4html( $mod_config , $row );
			$ret[$i]['cat_link'] = $URL_MOD.'/'.pico_whatsnew_category_link4html( $mod_config , $row );
			$ret[$i]['title'] = $myts->makeTboxData4Show($row['subject']);
			$ret[$i]['cat_name'] = $myts->makeTboxData4Show($row['cat_title']);
			$ret[$i]['time']  = intval( $row['modified_time'] );
			$ret[$i]['modified'] = intval( $row['modified_time'] );
			$ret[$i]['created']  = intval( $row['created_time'] );
			$ret[$i]['uid']  = intval( $row['poster_uid'] );
			$ret[$i]['hits'] = intval( $row['viewed'] );

// replies
			if( $replies && $row['allow_comment']) {
				$ret[$i]['replies'] = intval( $row['comments_count'] );
			}

// description
			$permissions = array();
			if( ! $permit ) {
				$permissions = pico_whatsnew_view_detail( $mydirname, $uid, $cat_id ) ;
			}
			if ( $permit || $permissions[ $cat_id ]['can_readfull'] ){
				$ret[$i]['description'] = pico_whatsnew_filter_body( $mydirname , $row , $row['use_cache'] );
			}
			$i++;
		}
		return $ret;
	}
}
// --- pico_whatsnew_base end ---

// === pico_whatsnew_categories_can_read begin ===
if (! function_exists('pico_whatsnew_categories_can_read')) {
	function pico_whatsnew_categories_can_read( $mydirname , $uid ,$permit )
	{
		global $xoopsUser ;

		$db =& Database::getInstance() ;

		if( is_object( $xoopsUser) ) {
			$groups = $xoopsUser->getGroups() ;
			if( ! empty( $groups ) ) {
				$whr4cat = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
			} else {
				$whr4cat = "`uid`=$uid" ;
			}
		} else {
			if ( ! $permit ){
				$whr4cat = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
			} else {
				$whr4cat = "`groupid`=".intval(XOOPS_GROUP_USERS) ;
			}
		}

		// get categories
		$sql = "SELECT distinct cat_id FROM ".$db->prefix($mydirname."_category_permissions")." WHERE ($whr4cat)" ;
		$result = $db->query( $sql ) ;
		if( $result ) while( list( $cat_id ) = $db->fetchRow( $result ) ) {
			$cat_ids[] = intval( $cat_id ) ;
		}
		
		if( empty( $cat_ids ) ) return array(0) ;
		else return $cat_ids ;
	}
}
// --- pico_whatsnew_categories_can_read end ---

// === pico_whatsnew_content_link4html begin ===
if (! function_exists('pico_whatsnew_content_link4html')) {
	function pico_whatsnew_content_link4html( $mod_config , $content_row , $mydirname = null )
	{
		if( ! empty( $mod_config['use_wraps_mode'] ) ) {
			// wraps mode 
			if( ! is_array( $content_row ) && ! empty( $mydirname ) ) {
				// specify content by content_id instead of content_row
				$db =& Database::getInstance() ;
				$content_row = $db->fetchArray( $db->query( "SELECT content_id,vpath FROM ".$db->prefix($mydirname."_contents")." WHERE content_id=".intval($content_row) ) ) ;
			}

			if( ! empty( $content_row['vpath'] ) ) {
				$ret = 'index.php'.htmlspecialchars($content_row['vpath'],ENT_QUOTES) ;
			} else {
				$ret = 'index.php' . sprintf( '/content%04d.html' , intval( $content_row['content_id'] ) ) ;
			}
			return empty( $mod_config['use_rewrite'] ) ? $ret : substr( $ret , 10 ) ;
		} else {
			// normal mode
			$content_id = is_array( $content_row ) ? intval( $content_row['content_id'] ) : intval( $content_row ) ;
			return empty( $mod_config['use_rewrite'] ) ? 'index.php?content_id='.$content_id : substr( sprintf( '/content%04d.html' , $content_id ) , 1 ) ;
		}
	}
}
// --- pico_whatsnew_content_link4html end ---

// === pico_whatsnew_category_link4html begin ===
if (! function_exists('pico_whatsnew_category_link4html')) {
	function pico_whatsnew_category_link4html( $mod_config , $cat_row , $mydirname = null )
	{
		if( ! empty( $mod_config['use_wraps_mode'] ) ) {
			if( empty( $cat_row ) || is_array( $cat_row ) && $cat_row['cat_id'] == 0 ) return '' ;
			if( ! is_array( $cat_row ) && ! empty( $mydirname ) ) {
				// specify category by cat_id instead of cat_row
				$db =& Database::getInstance() ;
				$cat_row = $db->fetchArray( $db->query( "SELECT cat_id,cat_vpath FROM ".$db->prefix($mydirname."_categories")." WHERE cat_id=".intval($cat_row) ) ) ;
			}
			if( ! empty( $cat_row['cat_vpath'] ) ) {
				$ret = 'index.php'.htmlspecialchars($cat_row['cat_vpath'],ENT_QUOTES) ;
				if( substr( $ret , -1 ) != '/' ) $ret .= '/' ;
			} else {
				$ret = 'index.php' . sprintf( '/category%04d.html' , intval( $cat_row['cat_id'] ) ) ;
			}
			return empty( $mod_config['use_rewrite'] ) ? $ret : substr( $ret , 10 ) ;
		} else {
			// normal mode
			$cat_id = is_array( $cat_row ) ? intval( $cat_row['cat_id'] ) : intval( $cat_row ) ;
			if( $cat_id ) return empty( $mod_config['use_rewrite'] ) ? 'index.php?cat_id='.$cat_id : substr( sprintf( '/category%04d.html' , $cat_id ) , 1 ) ;
			else return '' ;
		}
	}
}
// --- pico_whatsnew_category_link4html end ---

// === pico_whatsnew_view_detail begin ===
if (! function_exists('pico_whatsnew_view_detail')) {
	function pico_whatsnew_view_detail( $mydirname , $uid , $cat_id )
	{
		$db =& Database::getInstance() ;

		if( $uid > 0 ) {
			$user_handler =& xoops_gethandler( 'user' ) ;
			$user =& $user_handler->get( $uid ) ;
		} else {
			$user = @$GLOBALS['xoopsUser'] ;
		}

		if( is_object( $user ) ) {
			$groups = $user->getGroups() ;
		if( ! empty( $groups ) ) $whr = "`uid`=$uid || `groupid` IN (".implode(",",$groups).")" ;
			else $whr = "`uid`=$uid" ;
		} else {
			$whr = "`groupid`=".intval(XOOPS_GROUP_ANONYMOUS) ;
		}

		$sql = "SELECT cat_id,permissions FROM ".$db->prefix($mydirname."_category_permissions")." WHERE ($whr) AND cat_id=$cat_id" ;
		$result = $db->query( $sql ) ;
		if( $result ) while( list( $cat_id , $serialized_permissions ) = $db->fetchRow( $result ) ) {
			$permissions = unserialize( $serialized_permissions ) ;
			if( is_array( @$ret[ $cat_id ] ) ) {
				foreach( $permissions as $perm_name => $value ) {
					@$ret[ $cat_id ][ $perm_name ] |= $value ;
				}
			} else {
				$ret[ $cat_id ] = $permissions ;
			}
		}

		if( empty( $ret ) ) return array( 0 => array() ) ;
		else return $ret ;
	}
// --- pico_whatsnew_view_detail end ---
}

// === pico_whatsnew_filter_body begin ===
if (! function_exists('pico_whatsnew_filter_body')) {
	function pico_whatsnew_filter_body( $mydirname , $content_row , $use_cache = false )
	{
		include_once XOOPS_TRUST_PATH.'/modules/pico/include/common_functions.php' ;

		$can_use_cache = $content_row['use_cache'] && $content_row['body_cached'] ;

		if( $can_use_cache ) {
			return $content_row['body_cached'] ;
		}

		// process each filters
		$text = $content_row['body'] ;
		$filters = explode( '|' , $content_row['filters'] ) ;
		foreach( array_keys( $filters ) as $i ) {
			$filter = trim( $filters[ $i ] ) ;
			if( empty( $filter ) ) continue ;
			// xcode special check
			if( $filter == 'xcode' ) {
				$nl2br = $smiley = 0 ;
				for( $j = $i + 1 ; $j < $i + 3 ; $j ++ ) {
					if( @$filters[ $j ] == 'nl2br' ) {
						$nl2br = 1 ;
						$filters[ $j ] = '' ;
					} else if( @$filters[ $j ] == 'smiley' ) {
						$smiley = 1 ;
						$filters[ $j ] = '' ;
					}
				}
				require_once XOOPS_TRUST_PATH.'/modules/pico/class/pico.textsanitizer.php' ;
				$myts =& PicoTextSanitizer::getInstance() ;
				$text = $myts->displayTarea( $text , 1 , $smiley , 1 , 1 , $nl2br ) ;
				continue ;
			}
			$func_name = 'pico_'.$filter ;
			$file_path = XOOPS_TRUST_PATH.'/modules/pico/filters/pico_'.$filter.'.php' ;
			if( function_exists( $func_name ) ) {
				$text = $func_name( $mydirname , $text , $content_row ) ;
			} else if( file_exists( $file_path ) ) {
				require_once $file_path ;
				$text = $func_name( $mydirname , $text , $content_row ) ;
			}
		}
		return $text ;
	}
// --- pico_whatsnew_filter_body end ---
}

// === pico_whatsnew_get_permit begin ===
if (! function_exists('pico_whatsnew_get_permit')) {
	function pico_whatsnew_get_permit( $mydirname )
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
// --- pico_whatsnew_get_permit end ---
}

?>