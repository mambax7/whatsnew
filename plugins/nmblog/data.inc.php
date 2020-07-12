<?php
// $Id: data.inc.php,v 1.2 2007/05/15 06:26:30 ohwada Exp $

// 2007-05-15 K.OHWADA
// add uid in sql
// show HTML description
// revise time zone

//================================================================
// What's New Module
// get aritciles from module
// nmBlog 1.5 <http://www.nm-eternity.net/~nerk/>
// 2007-02-25 K.Naramoto <http://www.tokoharu.jp/>
//================================================================

// Id: data.inc.php,v 1.5 2007/05/09 23:35:00 K.Naramoto Exp

// 2007-02-25 K.Naramoto
// http://www.tokoharu.jp/
// new created for nmBlog module

// 2007-03-12 K.Naramoto
// http://www.tokoharu.jp/
// for BopComment Like Layout 

// 2007-05-09 K.Naramoto
// http://www.tokoharu.jp/
// for MySQL 4.0* environment 


if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( __FILE__ ) );

// --- eval begin ---
eval( '
	function '.$mydirname.'_new($limit=0, $offset=0) {
		return nmblog_new_base( "'.$mydirname.'", $limit , $offset ) ;
	}

	function '.$mydirname.'_num() 
	{
		return nmblog_num_base( "'.$mydirname.'" ) ;
	}

	function '.$mydirname.'_data( $limit=0, $offset=0 )
	{
		return nmblog_data_base( "'.$mydirname.'", $limit=0, $offset=0 ) ;
	}

' ) ;
// --- eval end ---

// === nmblog_new_base ===
if( ! function_exists( 'nmblog_new_base' ) ) {

	function nmblog_new_base( $mydirname, $limit=0, $offset=0 ) {

		global $xoopsUser, $xoopsDB, $xoopsConfig;
		$myts =& MyTextSanitizer::getInstance();

		$currentuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;

		$URL_MOD = XOOPS_URL . '/modules/' . $mydirname;
		$TZ = $xoopsConfig['server_TZ'] * 3600;

		$sql = sprintf('SELECT a.id, a.uid, c.name, UNIX_TIMESTAMP(a.time) AS post_date, a.title, a.content, a.category_id, count( m.article_id ) as cnum FROM %s as a ', $xoopsDB->prefix('nmBlogArticle'));
		$sql = sprintf('%s INNER JOIN %s as c on a.category_id = c.id left OUTER JOIN %s as m on a.id = m.article_id GROUP BY a.id ORDER BY post_date DESC', $sql, $xoopsDB->prefix('nmBlogCategory'),$xoopsDB->prefix('nmBlogComment'));

		$result = $xoopsDB->query($sql, $limit, $offset);
		$i = 0;
		$ret = array();

		while ($myrow=$xoopsDB->fetchArray($result)) {

			$id          = intval($myrow['id']);
			$category_id = intval($myrow['category_id']);
			$uid         = intval($myrow['uid']);
		
			$ret[$i]['id']  = $id;
			$ret[$i]['uid'] = $uid;
			$ret[$i]['link']     = $URL_MOD . '/response.php?aid=' . $id;
			$ret[$i]['cat_link'] = $URL_MOD . '/categories.php?mode=show&category=' . $category_id;
			$ret[$i]['title']    = $myrow['title'];
			$ret[$i]['cat_name'] = $myrow['name'];
			$ret[$i]['replies']  = $myrow['cnum'];

			$ret[$i]['time']  = $myrow['post_date'] + $TZ;

// description
			$content  = $myrow['content'];
			$dohtml   = 0;
			$dosmiley = 1;
			$doxcode  = 1;
			$doimage  = 1;
			$dobr     = 1;

			$ret[$i]['description'] = 
					$myts->displayTarea($content, $dohtml, $dosmiley, $doxcode, $doimage, $dobr);

			$i++;
		}
		return $ret;
	}
}

// === nmblog_num_base ===
if( ! function_exists( 'nmblog_num_base' ) ) {
	function nmblog_num_base( $mydirname ) {

		global $xoopsDB;

		$currentuid = !empty($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;
		$sql = sprintf('SELECT count(b.id) FROM %s as b, %s as u WHERE b.uid=u.uid', $xoopsDB->prefix('nmBlogArticle'), $xoopsDB->prefix('users'));
		$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
		$num = $array[0];
		if (empty($num)) $num = 0;
		return $num;
	}
}

// === nmblog_data_base ===
if( ! function_exists( 'nmblog_data_base' ) ) {

	function nmblog_data_base($mydirname, $limit=0, $offset=0)
	{
		global $xoopsDB;

		$currentuid = !empty($xoopsUser) ? $xoopsUser->getVar('uid','E') : 0;

		$sql = sprintf('SELECT a.id, UNIX_TIMESTAMP(a.time) AS post_date, a.title, a.content, c.name FROM %s as a, %s as u', $xoopsDB->prefix('nmBlogArticle'), $xoopsDB->prefix('users'));
		$sql = sprintf('%s LEFT JOIN %s c ON a.category_id=c.id WHERE a.uid=u.uid ORDER BY post_date DESC', $sql, $xoopsDB->prefix('nmBlogCategory'));

		$result = $xoopsDB->query($sql,$limit,$offset);

		$i = 0;
		$ret = array();

		while($myrow = $xoopsDB->fetchArray($result))
		{
			//$ret[$i]['category'] = $myrow['name'];
			$ret[$i]['category'] = $myrow['name'];
			$ret[$i]['link'] = XOOPS_URL."/modules/".$mydirname."/response.php?aid=".intval($myrow['id']);
			$ret[$i]['id'] = $myrow['id'];
			$ret[$i]['title'] = $myrow['title'];
			$ret[$i]['time']  = $myrow['post_date'];
			$i++;
		}
		return $ret;
	}
}

?>