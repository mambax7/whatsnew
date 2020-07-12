<?php
// $Id: data.inc.php,v 1.5 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// BUG: dont sort by time 

// 2005-09-06 K.OHWADA
// BUG 2944: dont show storyid=1

// 2005-06-20 K.OHWADA
// for PDA

// 2005-06-06 K.OHWADA
// small change for plugin.

//================================================================
// What's New Module
// get aritciles from module
// for tinyD 2.18 <http://www.peak.ne.jp/xoops/>
// 2005-05-25
//================================================================
// ------------------------------------------------------------------------- //
// Hacker: hodaka <hodaka@kuri3.net>                                         //
// Site: http://www.kuri3.net/                                               //
// ------------------------------------------------------------------------- //

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

//$mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
$mydirname = basename( dirname( __FILE__ ) ) ;

if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;
$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname" ;
$mymoddir = XOOPS_URL . "/modules/$mydirname" ;
include_once( XOOPS_ROOT_PATH . "/modules/$mydirname/include/constants.inc.php" ) ;

eval( '
// function '.$mydirname.$mydirnumber.'_new( $limit=0 , $offset=0 )
function '.$mydirname.'_new( $limit=0 , $offset=0 )
{
	return tinyd_new_base( "'.$mydirname.'", "'.$mydirnumber.'", "'.$mymodpath.'", "'.$mymoddir.'", $limit , $offset ) ;
}
' ) ;

if( ! function_exists( 'tinyd_new_base' ) ) {

function tinyd_new_base( $mydirname, $mydirnumber, $mymodpath, $mymoddir, $limit=0, $offset=0 )
{

//	$myts =& MyTextSanitizer::getInstance() ;
	global $xoopsConfig;
	$db =& Database::getInstance() ;

	include_once( "$mymodpath/class/tinyd.textsanitizer.php" ) ;
	include_once( "$mymodpath/include/render_function.inc.php" ) ;

	if ( file_exists( "$mymodpath/language/{$xoopsConfig['language']}/main.php" ) ) {
		include_once( "$mymodpath/language/{$xoopsConfig['language']}/main.php" ) ;
	} else {
		include_once( "$mymodpath/language/english/main.php" ) ;
	}

	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$module =& $module_handler->getByDirname($mydirname);
	$config =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
	$space2nbsp = empty( $config['tc_space2nbsp'] ) ? 0 : 1 ;

// BUG 2944: dont show storyid=1
//	$result = $db->query("SELECT storyid,title,text,link,UNIX_TIMESTAMP(last_modified) as last_modified,nohtml,nosmiley,nobreaks,address FROM ".$db->prefix( 'tinycontent'.$mydirnumber )." WHERE visible='1' AND storyid !=1 ORDER BY blockid DESC", $limit, $offset);

// BUG : dont sort by time
	$result = $db->query("SELECT storyid, title, text, link, UNIX_TIMESTAMP(last_modified) as unix_modified, UNIX_TIMESTAMP(created) as unix_created, nohtml, nosmiley, nobreaks, address FROM ".$db->prefix( 'tinycontent'.$mydirnumber )." WHERE visible='1' ORDER BY last_modified DESC", $limit, $offset);

	$i = 0;
	$ret = array();
	while( $row = $db->fetchArray($result) ) 
	{
		// getting "content"
		if( $row['link'] > 0 ) 
		{
			// external (=wrapped) content
			$wrap_file = "$mymodpath/content/".$row['address'] ;
			if( ! file_exists( $wrap_file ) ) 
			{
				redirect_header( XOOPS_URL , 2 , _TC_FILENOTFOUND ) ;
				exit ;
			}

			ob_start() ;
			include( $wrap_file ) ;
			$content = tc_convert_wrap_to_ie( ob_get_contents() ) ;
			/* if( $link == TC_WRAPTYPE_CHANGESRCHREF ) */ 
			$content = tc_change_srchref( $content , "$mymoddir/content" ) ;
			ob_end_clean() ;

// body tag
			if (preg_match('|<\s*body\s?.*?>(.*)<\s*/\s*body\s*>|is', $content, $match)) 
			{
				$content = $match[1];
			}

		}
		else 
		{
/*
			$myts =& TinyDTextSanitizer::getInstance();
			$shorten_text = $myts->tinyExtractSummary( $text ) ;
			$is_summary = ( $shorten_text != $text ) ;
*/
			$content = tc_content_render( $row['text'], $row['nohtml'], $row['nosmiley'], $row['nobreaks'], $space2nbsp ) ;

		}

		$storyid = $row['storyid'];
		$ret[$i]['link'] = $mymoddir."/index.php?id=".$storyid;
		$ret[$i]['pda']  = $mymoddir."/print.php?id=".$storyid;

		$ret[$i]['title'] = $row['title'];

// atom feed
		$ret[$i]['id'] = $storyid;
		$ret[$i]['description'] = $content;

// time
		$modified  = $row['unix_modified'];
	   	$ret[$i]['time']     = $modified;
		$ret[$i]['modified'] = $modified;
		$ret[$i]['created']  = $row['unix_created'];

		$i++;
	}
//print_r($ret);
	return $ret;
}
}

eval( '
function '.$mydirname.$mydirnumber.'_num()
{
	return tinyd_num_base( "'.$mydirnumber.'" ) ;
}
' ) ;

if( ! function_exists( 'tinyd_num_base' ) ) {
	function tinyd_num_base( $mydirnumber )
	{
		$db =& Database::getInstance() ;

		$sql = "SELECT count(*) FROM ".$db->prefix( 'tinycontent'.$mydirnumber )." WHERE visible";
		$array = $db->fetchRow( $db->query($sql) );
		$num   = $array[0];
		if (empty($num)) $num = 0;
		return $num;
	}
}

eval( '
function '.$mydirname.$mydirnumber.'_data( $limit=0, $offset=0 )
{
	return tinyd_data_base( "'.$mydirnumber.'", "'.$mymoddir.'", $limit=0, $offset=0 ) ;
}
' ) ;

if( ! function_exists( 'tinyd_data_base' ) ) {
	function tinyd_data_base( $mydirnumber, $mymoddir, $limit=0, $offset=0)
	{
		$db =& Database::getInstance() ;

		$result = $db->query( "SELECT storyid,title,UNIX_TIMESTAMP(last_modified) as last_modified FROM ".$db->prefix( 'tinycontent'.$mydirnumber )." WHERE visible='1' ORDER BY last_modified DESC", $limit, $offset );

		$i = 0;
		$ret = array();

 		while($row = $db->fetchArray($result))
 		{
	  	$ret[$i]['id']   = $row['storyid'];
			$ret[$i]['link'] = $mymoddir."/index.php?id=".$row['storyid'];
			$ret[$i]['title'] = $row['title'];
			$ret[$i]['time']  = $row['last_modified'];
			$i++;
		}

		return $ret;
	}
}
?>