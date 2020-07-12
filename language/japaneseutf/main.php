<?php
// $Id: main.php,v 1.1 2007/06/08 20:09:25 ohwada Exp $

// 2007-05-12 K.OHWADA
// module dupulication
// add _WHATSNEW_RDF_AUTO
// remove _WHATSNEW_LASTBUILD

// 2005-10-10 K.OHWADA
// _WHATSNEW_RSS_PERM

// 2005-06-06 K.OHWADA
// _WHATSNEW_RSS_VALID

//=========================================================
// What's New Module
// Language pack for Japanese
// 2004/08/20 K.OHWADA
// UTF-8
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_MB_LOADED') ) 
{

define('WHATSNEW_LANG_MB_LOADED', 1);

// index.php
// use $xoopsModule
//define("_WHATSNEW_NAME","新着情報 (What's New)");

define("_WHATSNEW_DESC","複数のモジュールから最新の記事を集めて、RSSとATOMを作成します");

define("_WHATSNEW_RSS_VALID","RSS/ATOMの正当性の検査");
define("_WHATSNEW_VALID","による正当性の検査");

define("_WHATSNEW_RSS_AUTO","RSS URL の自動検出");
define("_WHATSNEW_ATOM_AUTO","ATOM URL の自動検出");

// not use config file
//define("_WHATSNEW_WARNING_NOT_EXIST","設定ファイルが存在していない");

// template rss
//define('_WHATSNEW_LASTBUILD', '最終更新日');
//define('_WHATSNEW_LANGUAGE', '言語');
//define('_WHATSNEW_DESCRIPTION', 'サイト');
//define('_WHATSNEW_WEBMASTER', 'ウェブマスター');
//define('_WHATSNEW_CATEGORY', 'カテゴリ');
//define('_WHATSNEW_GENERATOR', '作成');
//define('_WHATSNEW_TITLE', '題名');
//define('_WHATSNEW_PUBDATE', '公開');

// template atom
//define('_WHATSNEW_ID', 'ID');
//define('_WHATSNEW_MODIFIED', '最終更新日');
//define('_WHATSNEW_ISSUED',   '発行日');
//define('_WHATSNEW_CREATED',  '作成日');
//define('_WHATSNEW_COPYRIGHT', 'コピーライト');
//define('_WHATSNEW_SUMMARY', '要約');
//define('_WHATSNEW_CONTENT', '内容');
//define('_WHATSNEW_AUTHOR_NAME', '作者名');
//define('_WHATSNEW_AUTHOR_URL',  '作者のURL');
//define('_WHATSNEW_AUTHOR_EMAIL','作者の電子メール');

define('_WHATSNEW_AUTO', '自動検出');
define('_WHATSNEW_SET', '指定');

define('_WHATSNEW_ERROR_CONNCET', '接続できません');
define('_WHATSNEW_ERROR_PARSE', '解析できない');
define('_WHATSNEW_ERROR_RSS_AUTO', 'RSS URL が自動検出できません');
define('_WHATSNEW_ERROR_RSS_GET', 'RSSの取得ができません');
define('_WHATSNEW_ERROR_ATOM_AUTO', 'ATOM URL が自動検出できません');
define('_WHATSNEW_ERROR_ATOM_GET', 'ATOMの取得ができません');

// 2005-10-10
define('_WHATSNEW_MAIN_PAGE', 'メイン・ページ');
define('_WHATSNEW_RSS_PERM', 'ATOM/RSS/RDF は登録ユーザには表示されません。<br />ログアウトして、ゲストの状態で確認してください。');

// 2007-05-12
define("_WHATSNEW_RDF_AUTO","RDF URL の自動検出");

}
// --- define language end ---

?>