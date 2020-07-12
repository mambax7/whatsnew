<?php
// $Id: blocks.php,v 1.4 2007/05/15 05:24:26 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-10-10 K.OHWADA
// for block_bop.html

//=========================================================
// What's New Module
// Language pack for Japanese
// 2004/08/20 K.OHWADA
// 有朋自遠方来
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_BL_LOADED') ) 
{

define('WHATSNEW_LANG_BL_LOADED', 1);

// not use config file
//define("_WHATSNEW_WARNING_NOT_EXIST","設定ファイルが存在していない");

// 2005-10-10
define("_WHATSNEW_BLOCK_MODULE","モジュール");
define('_WHATSNEW_BLOCK_CATEGORY', 'カテゴリ');
define("_WHATSNEW_BLOCK_TITLE","タイトル");
define("_WHATSNEW_BLOCK_USER","投稿者");
define("_WHATSNEW_BLOCK_HITS","ヒット数");
define("_WHATSNEW_BLOCK_REPLIES","返信数");
define("_WHATSNEW_BLOCK_DATE","日時");
define("_WHATSNEW_BLOCK_ETC","その他");
define("_WHATSNEW_BLOCK_MORE","もっと読む...");

}
// --- define language end ---

?>