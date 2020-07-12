<?php
// $Id: data.inc.php,v 1.5 2007/05/15 05:24:26 ohwada Exp $

// 2007-05-12 K.OHWADA
// check file_exists

// 2005-10-10 K.OHWADA
// dipsplaing description conflict with many modules. 

// 2005-07-15
// BUG 2778: warning array_merge() in bwiki
//   This is temporary measure
//   Warning [PHP]: array_merge(): Argument #2 is not an array
//   in file modules/bwiki/lib/bwiki.php line 135

// 2005-02-05
// description with wiki library

//================================================================
// What's New Module
// get aritciles from module
// for B-Wiki 20050210 <http://ishii.mydns.jp/>
// 2003.12.20 K.OHWADA
//================================================================

function bwiki_new($limit=0, $offset=0)
{

// Flag dipsplay description
// This flag conflict with many modules. 
// Sometime occure FATAL error.
	$FLAG_DISPLAY_DESC = 0;

	if ($FLAG_DISPLAY_DESC)
	{
		global $foot_explain, $related, $head_tags;
		global $weeklabels;
		global $WikiName, $BracketName, $InterWikiName, $NotePattern;
		global $now, $entity_pattern, $line_rules;
		global $vars;

		$vars         = array();
		$vars['cmd']  = 'read';

// BUG 2778: warning array_merge() in bwiki
		global $facemark_rules;
		$facemark_rules = array();

// wiki library
		$DATA_HOME = XOOPS_ROOT_PATH.'/modules/bwiki/';
		$LIB_DIR   = XOOPS_ROOT_PATH.'/modules/bwiki/lib/';

		if( ! defined( 'DATA_HOME' ) )
		{
			define('DATA_HOME', $DATA_HOME);
		}
	
		if( ! defined( 'LIB_DIR' ) )
		{
			define('LIB_DIR',   $LIB_DIR);
		}

		require_once(LIB_DIR . 'bwiki.php');
		require_once(LIB_DIR . 'func.php');
		require_once(LIB_DIR . 'file.php');
		require_once(LIB_DIR . 'plugin.php');
		require_once(LIB_DIR . 'html.php');
		require_once(LIB_DIR . 'backup.php');
		require_once(LIB_DIR . 'convert_html.php');
		require_once(LIB_DIR . 'make_link.php');
		require_once(LIB_DIR . 'diff.php');
		require_once(LIB_DIR . 'config.php');
		require_once(LIB_DIR . 'link.php');
		require_once(LIB_DIR . 'trackback.php');
		require_once(LIB_DIR . 'auth.php');
		require_once(LIB_DIR . 'proxy.php');
		require_once(LIB_DIR . 'mail.php');

		if (! extension_loaded('mbstring')) 
		{
			require_once(LIB_DIR . 'mbstring.php');
		}

		require_once(LIB_DIR . 'init.php');
	}

// recent data
	$i    = 0;
	$ret  = array();
	$desc = '';

// check file_exists
	if ( file_exists(XOOPS_ROOT_PATH.'/modules/bwiki/cache/recent.dat') ) 
	{
		$recent_line = @file(XOOPS_ROOT_PATH.'/modules/bwiki/cache/recent.dat');
	}
	else
	{
		return false;
	}

	$recent_arr  = array_slice($recent_line, 0, $limit);

	foreach($recent_arr as $line)
	{
		list($time, $base) = explode("\t", trim($line));
		$localtime = $time + (9 * 3600);

		$ret[$i]['link']  = XOOPS_URL."/modules/bwiki/index.php?".rawurlencode($base);
	    $ret[$i]['title'] = $base;
	   	$ret[$i]['time']  = $localtime;

		if ($FLAG_DISPLAY_DESC)
		{
			global $vars;
			$vars['page'] = $base;
			$desc = convert_html(get_source($base));
		}

		$ret[$i]['description'] = $desc;
		$i++;
	}

	return $ret;
}

function bwiki_num()
{
	include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
	include_once XOOPS_ROOT_PATH.'/modules/bwiki/func.php';

	$i = 0;
	$ret = array();

	$dir = XOOPS_ROOT_PATH.'/modules/bwiki/wiki';
	$file_array = XoopsLists::getFileListAsArray($dir);

	foreach ($file_array as $file)
	{
		list($id, $txt)   = explode(".", $file);
		$title            = decode($id);
		if (preg_match("/^:/",$title)) { continue; }
		$i++;
	}

	return $i;
}

function bwiki_data($limit=0, $offset=0)
{
	include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
	include_once XOOPS_ROOT_PATH.'/modules/bwiki/func.php';
	
	$i = 0;
	$j = 0;
	$ret = array();

	$dir = XOOPS_ROOT_PATH.'/modules/bwiki/wiki';
	$file_array = XoopsLists::getFileListAsArray($dir);

	foreach ($file_array as $file)
	{
		list($id, $txt)   = explode(".", $file);
		$title            = decode($id);
		if (preg_match("/^:/",$title)) { continue; }

 		if ($j >= $offset)
		{	$ret[$i]['id']    = $id;
			$ret[$i]['link']  = XOOPS_URL."/modules/bwiki/index.php?".rawurlencode($title);
	    	$ret[$i]['title'] = $title;
	   		$ret[$i]['time']  = filemtime("$dir/$file");
			$i++;
 			if ($i >= $limit) { break; }
		}

		$j++;
	}

	return $ret;
}
?>
