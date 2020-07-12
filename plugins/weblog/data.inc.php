<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// category, counter

// 2005-06-06 K.OHWADA
// small change for plugin.

//================================================================
// get aritciles from module
// weblog 1.42 <http://tohokuaiki.jp/>
// 2005.05.16 Hodaka <http://www.kuri3.net/>
//================================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

//$mydirname = basename( dirname( dirname( __FILE__ ) ) );
$mydirname = basename( dirname( __FILE__ ) );

//if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) );
//$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] );
//$mymodpath = XOOPS_ROOT_PATH . "/modules/$mydirname";
//$mymoddir = XOOPS_URL . "/modules/$mydirname";

eval( '
	function '.$mydirname.'_new($limit=0, $offset=0) {
		return weblog_new_base( "'.$mydirname.'", $limit , $offset ) ;
	}
' ) ;

if( ! function_exists( 'weblog_new_base' ) ) {

	function weblog_new_base( $mydirname, $limit=0, $offset=0 ) 
	{

		global $xoopsUser, $xoopsDB, $xoopsConfig;

		$myts =& MyTextSanitizer::getInstance();

		$url_mod = XOOPS_URL."/modules/".$mydirname;

  		$currentuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;

		$sql = sprintf('SELECT b.blog_id, b.created, b.title, b.contents, b.dohtml, b.dobr, b.user_id, b.reads, b.cat_id, c.cat_title FROM %s as b, %s as u', $xoopsDB->prefix($mydirname), $xoopsDB->prefix('users'));
		$sql = sprintf('%s LEFT JOIN %s c ON b.cat_id=c.cat_id', $sql, $xoopsDB->prefix($mydirname.'_category'));
		$sql = sprintf('%s WHERE (b.private = \'N\' OR b.user_id=\'%d\') AND b.user_id=u.uid ORDER BY b.created DESC', $sql, $currentuid);

		$result = $xoopsDB->query($sql, $limit, $offset);
		$i = 0;
		$ret = array();

		while ( $row=$xoopsDB->fetchArray($result) ) 
		{
			$ret[$i]['link']     = $url_mod."/details.php?blog_id=".intval($row['blog_id']);
			$ret[$i]['cat_link'] = $url_mod."/index.php?cat_id=".intval($row['cat_id']);
			$ret[$i]['title']    = $row['title'];
			$ret[$i]['cat_name'] = $row['cat_title'];
			$ret[$i]['time'] = $row['created'];
			$ret[$i]['uid']  = $row['user_id'];
			$ret[$i]['hits'] = $row['reads'];

			$html   = 0;
			$smiley = 1;
			$xcodes = 1;
			$image  = 1;
			$br     = 0;

			if ( $row['dohtml'] )	$html   = 1;
			if ( $row['dobr'] )		$br     = 1;

			$desc = $myts->displayTarea($row['contents'], $html, $smiley, $xcodes, $image, $br);
			$ret[$i]['description'] = $desc;

			$i++;
		}

		return $ret;
	}
}

eval( '
	function '.$mydirname.'_num() {
		return weblog_num_base( "'.$mydirname.'" ) ;
	}
' ) ;

if( ! function_exists( 'weblog_num_base' ) ) {
	function weblog_num_base( $mydirname ) {

		global $xoopsDB;

		$currentuid = !empty($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;
		$sql = sprintf('SELECT count(b.blog_id) FROM %s as b, %s as u', $xoopsDB->prefix($mydirname), $xoopsDB->prefix('users'));
		$sql = sprintf('%s WHERE (b.private = \'N\' OR b.user_id=\'%d\') AND b.user_id=u.uid', $sql, $currentuid);

		$sql = "SELECT count(*) FROM ".$xoopsDB->prefix($mydirname);
		$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
		$num = $array[0];
		if (empty($num)) $num = 0;
		return $num;
	}
}

eval( '
function '.$mydirname.'_data( $limit=0, $offset=0 )
{
	return weblog_data_base( "'.$mydirname.'", $limit=0, $offset=0 ) ;
}
' ) ;

if( ! function_exists( 'weblog_data_base' ) ) {

	function weblog_data_base($mydirname, $limit=0, $offset=0)
	{
		global $xoopsDB;

		$currentuid = !empty($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;

		$sql = sprintf('SELECT b.blog_id, b.created, b.title, c.cat_title FROM %s as b, %s as u', $xoopsDB->prefix($mydirname), $xoopsDB->prefix('users'));
		$sql = sprintf('%s LEFT JOIN %s c ON b.cat_id=c.cat_id', $sql, $xoopsDB->prefix($mydirname.'_category'));
		$sql = sprintf('%s WHERE (b.private = \'N\' OR b.user_id=\'%d\') AND b.user_id=u.uid ORDER BY b.created DESC', $sql, $currentuid);

		$result = $xoopsDB->query($sql,$limit,$offset);

		$i = 0;
		$ret = array();

		while($row = $xoopsDB->fetchArray($result))
		{
			$ret[$i]['category'] = $row['cat_title'];
			$ret[$i]['id'] = $row['blog_id'];
			$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/details.php?blog_id=".intval($row['blog_id']);
			$ret[$i]['title'] = $row['title'];
			$ret[$i]['time']  = $row['created'];
			$i++;
		}
		return $ret;
	}
}

?>
