<?php
// $Id: modinfo.php,v 1.5 2007/10/22 02:46:17 ohwada Exp $

// 2007-10-10 K.OHWADA
// change slightly

// 2007-05-12 K.OHWADA
// module dupulication

// 2005-10-01 K.OHWADA
// _MI_WHATSNEW_BNAME_BOP

//=========================================================
// What's New Module
// Language pack for Japanese
// 2004/08/20 K.OHWADA
// 有朋自遠方来
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_MI_LOADED') ) 
{

define('WHATSNEW_LANG_MI_LOADED', 1);

// The name of this module
define("_MI_WHATSNEW_NAME","新着情報");

// A brief description of this module
define("_MI_WHATSNEW_DESC","複数のモジュールから最新の記事を集めて、新着情報の一覧を作成します");

// Names of blocks for this module (Not all module has blocks)
define("_MI_WHATSNEW_BNAME1","新着情報 (日付順)");
define("_MI_WHATSNEW_BNAME2","新着情報 (モジュール順)");

// Admin menu
define("_MI_WHATSNEW_ADMENU1","モジュール設定 1");

// 2005-10-01
define("_MI_WHATSNEW_BNAME_BOP","新着情報 (BopComment風)");
define("_MI_WHATSNEW_ADMENU_CONFIG2","モジュール設定 2");
define("_MI_WHATSNEW_ADMENU_RSS","RDF/RSS/ATOM の管理");
define("_MI_WHATSNEW_ADMENU_PING","Ping の管理");

}
// --- define language end ---

?>