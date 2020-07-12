<?php
// $Id: main.php,v 1.5 2007/10/22 02:46:16 ohwada Exp $

// 2007-10-10
// cache

// 2007-05-12 K.OHWADA
// module dupulication
// add _WHATSNEW_RDF_AUTO
// remove _WHATSNEW_LASTBUILD

// 2005-10-10 K.OHWADA
// _WHATSNEW_RSS_PERM

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_MB_LOADED') ) 
{

define('WHATSNEW_LANG_MB_LOADED', 1);
// index.php
// use $xoopsModule
//define("_WHATSNEW_NAME","What's New");

define("_WHATSNEW_DESC","This module collecte all latest reports from two or more modules, and show it in one block, and show it RSS and ATOM format.");

define("_WHATSNEW_RSS_VALID","RSS/ATOM Valid check");
define("_WHATSNEW_VALID","Valid check");

define("_WHATSNEW_RSS_AUTO","Auto Discovery of RSS URL");
define("_WHATSNEW_ATOM_AUTO","Auto Discovery of ATOM URL");

// not use config file
//define("_WHATSNEW_WARNING_NOT_EXIST","Not exist of config file");

// template rss
//define('_WHATSNEW_LASTBUILD', 'Last build date');
//define('_WHATSNEW_LANGUAGE', 'Language');
//define('_WHATSNEW_DESCRIPTION', 'Site');
//define('_WHATSNEW_WEBMASTER', 'Webmaster');
//define('_WHATSNEW_CATEGORY', 'Category');
//define('_WHATSNEW_GENERATOR', 'Generator');
//define('_WHATSNEW_TITLE', 'Title');
//define('_WHATSNEW_PUBDATE', 'Public date');

// template atom
//define('_WHATSNEW_ID', 'ID');
//define('_WHATSNEW_MODIFIED', 'Moditid date');
//define('_WHATSNEW_ISSUED',   'Issued date');
//define('_WHATSNEW_CREATED',  'Created date');
//define('_WHATSNEW_COPYRIGHT', 'Copyright');
//define('_WHATSNEW_SUMMARY', 'Summary');
//define('_WHATSNEW_CONTENT', 'Content');
//define('_WHATSNEW_AUTHOR_NAME', 'Author name');
//define('_WHATSNEW_AUTHOR_URL',  'Author URL');
//define('_WHATSNEW_AUTHOR_EMAIL','Author email');

define('_WHATSNEW_AUTO', 'Auto Discovery');
define('_WHATSNEW_SET', 'Specify');

define('_WHATSNEW_ERROR_CONNCET', 'Cannot connect');
define('_WHATSNEW_ERROR_PARSE', 'Cannot parse');
define('_WHATSNEW_ERROR_RSS_AUTO', 'Cannot RSS Auto Discovery');
define('_WHATSNEW_ERROR_RSS_GET', 'Cannot get RSS');
define('_WHATSNEW_ERROR_ATOM_AUTO', 'Cannot ATOM Auto Discovery');
define('_WHATSNEW_ERROR_ATOM_GET', 'Cannot get ATOM');

// 2005-10-10
define('_WHATSNEW_MAIN_PAGE', 'Main Page');
define('_WHATSNEW_RSS_PERM', 'Registed user cannot read ATOM/RSS/RDF<br />Please logout and read by anonymous mode');

// 2007-05-12
define('_WHATSNEW_RDF_AUTO','Auto Discovery of RDF URL');

// 2007-10-10
// cache
define('_WHATSNEW_CACHED_TIME','Time of created cache');
define('_WHATSNEW_REFRESH_CACHE','Refresh cache');

}
// --- define language end ---

?>