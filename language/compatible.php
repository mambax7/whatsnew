<?php
// $Id: compatible.php,v 1.6 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// _AM_WHATSNEW_CONFIG_VIEW

// 2007-10-20 K.OHWADA
// _WHATSNEW_CACHED_TIME

// 2007-05-12 K.OHWADA
// module dupulication
// _WHATSNEW_RDF_AUTO

// 2006-06-25
// _WHATSNEW_PLUGIN and more

// 2006-06-20 K.OHWADA
// this is new file

//=========================================================
// RSS Center Module
// 2006-05-18 K.OHWADA
//=========================================================

//---------------------------------------------------------
// compatible for v2.40
//---------------------------------------------------------
if( !defined('_AM_WHATSNEW_CONFIG_VIEW') ) 
{
// view
	define('_AM_WHATSNEW_CONFIG_VIEW','View Style Configration');
	define('_AM_WHATSNEW_CONF_NEWDAY_DAYS','Days to be marked as "NEW" ');
	define('_AM_WHATSNEW_CONF_NEWDAY_STRINGS','Strings of "NEW" ');
	define('_AM_WHATSNEW_CONF_NEWDAY_STYLE','Style of "NEW" ');
	define('_AM_WHATSNEW_CONF_TODAY_HOURS','Hours to be marked as "TODAY" ');
	define('_AM_WHATSNEW_CONF_TODAY_STRINGS','Strings of "TODAY" ');
	define('_AM_WHATSNEW_CONF_TODAY_STYLE','Style of "TODAY" ');

// main block
	define('_AM_WHATSNEW_CONFIG_MAIN_BLOCK','Main/Block/RSS Configration');
	define('_AM_WHATSNEW_MAIN','Main Page');
	define('_AM_WHATSNEW_CONF_NEWDAY','Show "NEW" ');
	define('_AM_WHATSNEW_CONF_TODAY','Show "TODAY" ');
	define('_AM_WHATSNEW_CONF_TODAY_DSC', 'When "No", the setting of "NEW" becomes valid.');
	define('_AM_WHATSNEW_CONF_DATE_STRINGS','Date Format');
	define('_AM_WHATSNEW_CONF_DATE_STRINGS_DSC','Referrence <a href="http://www.php.net/manual/en/function.date.php" target="_blank">PHP date function</a>');

// permission
	define('_AM_WHATSNEW_CONFIG_PERM','Access Permission Configration');
	define('_AM_WHATSNEW_CONFIG_PERM_DSC','set to show or not the item of the module which user have no access permission.');
	define('_AM_WHATSNEW_CONF_PERM_MODULE','Show the module which user have no access permission');
	define('_AM_WHATSNEW_CONF_PERM_MODULE_DSC','When "Show", the following setting becomes valid.');
	define('_AM_WHATSNEW_CONF_PERM_NOT_SHOW','Not show');
	define('_AM_WHATSNEW_CONF_PERM_SHOW','Show');
	define('_AM_WHATSNEW_CONF_PERM_DIRNAME','Directory Name');
	define('_AM_WHATSNEW_CONF_PERM_MOD_NAME','Module Name');
	define('_AM_WHATSNEW_CONF_PERM_MOD_LINK','Link to Module');
	define('_AM_WHATSNEW_CONF_PERM_MOD_ICON','Moduel Icon');
	define('_AM_WHATSNEW_CONF_PERM_CAT_NAME','Category Name');
	define('_AM_WHATSNEW_CONF_PERM_CAT_LINK','Link to Category');
	define('_AM_WHATSNEW_CONF_PERM_TITLE','Title of Article');
	define('_AM_WHATSNEW_CONF_PERM_LINK','Link to Article');
	define('_AM_WHATSNEW_CONF_PERM_SUMMARY','Summary');
	define('_AM_WHATSNEW_CONF_PERM_IMAGE','Image');
	define('_AM_WHATSNEW_CONF_PERM_BANNER','Banner');

	define('_AM_WHATSNEW_PERM','Permit');
	define('_AM_WHATSNEW_PERM_DSC','#1 Allow to show the module which guest have no access permission');
	define('_AM_WHATSNEW_CONF_BLOCK_MODULE_ORDER','Showing order of each module block');

}

//---------------------------------------------------------
// compatible for v2.30
//---------------------------------------------------------
if( !defined('_WHATSNEW_CACHED_TIME') ) 
{
// cache
	define('_WHATSNEW_CACHED_TIME','Time of created cache');
	define('_WHATSNEW_REFRESH_CACHE','Refresh cache');
}

if( !defined('_WHATSNEW_BANNER_FLAG') ) 
{
// banner
	define('_WHATSNEW_BANNER_FLAG',   'Show banner image');
	define('_WHATSNEW_BANNER_WIDTH',  'Max width of banner size');
	define('_WHATSNEW_BANNER_HEIGHT', 'Max height of banner size');
}

//---------------------------------------------------------
// compatible for v2.20
//---------------------------------------------------------
if( !defined('_WHATSNEW_RDF_AUTO') ) 
{
	define('_WHATSNEW_RDF_AUTO','Auto Discovery of RDF URL');
	define('_WHATSNEW_NOTICE_IMAGE_SIZE', 'a warning is displayed in XOOPS logo.gif when checking an image size according to the specification. <br />This value will be permissible. ');
}

//---------------------------------------------------------
// compatible for v2.10
//---------------------------------------------------------
if( !defined('_WHATSNEW_CONFIG_RSS') ) 
{
	define('_WHATSNEW_CONFIG_RSS', 'RDF/RSS/ATOM Build Configration');
	define('_WHATSNEW_RSS_PERMIT_USER', 'Permit user to show RSS feed');
	define('_WHATSNEW_RSS_PERMIT_USER_DESC', 'Anoymous user can show RSS feed always');
	define('_WHATSNEW_PLUGIN',  'Plugin');
	define('_WHATSNEW_MOD_VERSION', 'Version');
	define("_WHATSNEW_NOTICE_PLURAL","There are plural plugins in one module<br />Please select appropriate plugin<br />");
}

?>