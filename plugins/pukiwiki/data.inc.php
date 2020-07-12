<?php
// $Id: data.inc.php,v 1.1 2005/10/24 05:47:35 ohwada Exp $

// 2005-10-23 K.OHWADA
// bug: dont define $module_mid

//================================================================
// What's New Module
// get aritciles from module
// for PukiWiki 0.08  <http://hypweb.net/xoops/>
// 2005-10-23 nao-pon <http://hypweb.net/xoops/>
//================================================================

function pukiwiki_new($limit=0, $offset=0)
{
	$xoopsDB =& Database::getInstance();
	
	$module_handler = &xoops_gethandler('module');
	$module     = $module_handler->getByDirname('smartfaq');
	$module_mid = $module->getVar('mid');

	$comment = array();

	include (XOOPS_ROOT_PATH."/modules/pukiwiki/cache/config.php");
	
	$SQL = "SELECT p.id, p.lastediter, p.name as pname, p.title, p.editedtime , c.count, t.plain FROM ".
		$xoopsDB->prefix("pukiwikimod_pginfo")." p LEFT JOIN ".
		$xoopsDB->prefix("pukiwikimod_count")." c ON p.name=c.name ".
		"LEFT JOIN ".$xoopsDB->prefix("pukiwikimod_plain")." t ON t.pgid=p.id ".
		"WHERE p.vaids=\"&all\" AND p.name NOT LIKE \":%\" AND p.editedtime != 0 ".
		"ORDER BY p.editedtime DESC";
	
	if ( !$query = $xoopsDB->query($SQL,$limit,$offset) ) echo "Error! $SQL (pukiwiki)";
	
	$tb_tag = "-";
	
	$key = 0;
	while ( $result = $xoopsDB->fetchArray($query) )
	{
		$u_page_name = preg_replace("/\/[^\/]+$/","",$result['pname']);
		
		if ($use_static_url == 3)
		{
			$page = XOOPS_URL."/pukiwiki+._".$result['id'].".htm";
			$u_page = XOOPS_URL."/pukiwiki+._".b_WhatsNew_pukiwiki_get_pgid_by_name($u_page_name).".htm";
		}
		else if ($use_static_url == 2)
		{
			$page = XOOPS_URL."/pukiwiki+index.pgid+_".$result['id'].".htm";
			$u_page = XOOPS_URL."/pukiwiki+index.pgid+_".b_WhatsNew_pukiwiki_get_pgid_by_name($u_page_name).".htm";
		}
		else if ($use_static_url)
		{
			$page = XOOPS_URL."/modules/pukiwiki/".$result['id'].".html";
			$u_page = XOOPS_URL."/modules/pukiwiki/".b_WhatsNew_pukiwiki_get_pgid_by_name($u_page_name).".html";
		}
		else
		{
			$page = XOOPS_URL."/modules/pukiwiki/?".rawurlencode($result['pname']);
			$u_page = XOOPS_URL."/modules/pukiwiki/?".rawurlencode($u_page_name);
		}
		
		$tb = $com = 0;
		if ($trackback)
		{
			$t_query = "SELECT count(*) FROM ".$xoopsDB->prefix("pukiwikimod_tb")." WHERE page_name='".addslashes($result['pname'])."';";
			$t_result=$xoopsDB->query($t_query);
			$tb = mysql_result($t_result,0);
		}
		// Page Comments
		$com = xoops_comment_count($module_mid,$result['id']);
		$reply = $tb + $com;
		
		// 新規追加行
		$addfile = XOOPS_ROOT_PATH."/modules/pukiwiki/diff/"."add_".$result['id'].".cgi";
		$addtext = "";
		if (file_exists($addfile))
		{
			$addtext = trim(join('',file($addfile)));
			if ($addtext)
			{
				//$addtext = "<p>".strip_tags(str_replace(array("\r","\n"),"",$addtext))."</p>&#182;";
				$addtext = "<p>".strip_tags($addtext)."</p>&#182;";
				//$addtext = $addtext."&#182;";
			}
		}
		
		
		
		$comment[$key]['id'] = $result['id'];
		$comment[$key]['cat_link'] = $u_page;
		$comment[$key]['cat_name'] = $u_page_name;
		$comment[$key]['link'] = $page;
		$comment[$key]['title'] = ($result['title'])? $result['title'] : "+ no title +";
		$comment[$key]['uid'] = $result['lastediter'];
		$comment[$key]['hits'] = $result['count'];
		$comment[$key]['replies'] = $reply;
		$comment[$key]['time'] = $result['editedtime'];
		$comment[$key]['description'] = $addtext."<p>".str_replace("&amp;","&",htmlspecialchars($result['plain']))."</p>";
		$key++;
	}
	return $comment;
}

//ページ名からページIDを求める
function b_WhatsNew_pukiwiki_get_pgid_by_name($page)
{
	$xoopsDB =& Database::getInstance();
	static $page_id = array();
	$page = addslashes($page);
	if (!empty($page_id[$page])) return $page_id[$page];
	$query = "SELECT * FROM ".$xoopsDB->prefix("pukiwikimod_pginfo")." WHERE name='$page' LIMIT 1;";
	$res = $xoopsDB->query($query);
	if (!$res) return 0;
	$ret = mysql_fetch_row($res);
	$page_id[$page] = $ret[0];
	return $ret[0];
}
?>