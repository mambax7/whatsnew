<?php
// $Id: admin.php,v 1.14 2007/12/17 21:39:03 ohwada Exp $

// 2007-12-09 K.OHWADA
// remove _WHATSNEW_SITE_TAG

// 2007-12-01 K.OHWADA
// view
// _WHATSNEW_BLOCK_MODULE => _AM_WHATSNEW_CONF_BLOCK_MODULE_ORDER

// 2007-10-10 K.OHWADA
// banner cache_time

// 2007-06-01 K.OHWADA
// mistake to remove _WHATSNEW_NEW_IMAGE_WIDTH

// 2007-05-12 K.OHWADA
// module dupulication
// _WHATSNEW_NOTICE_IMAGE_SIZE
// remove _WHATSNEW_INIT_NOT etc

// 2006-06-25
// _WHATSNEW_PLUGIN and more

// 2006-06-20
// _WHATSNEW_CONFIG_RSS and more

// 2005-10-01
// _WHATSNEW_CONFIG_BLOCK and more

// 2005-06-20
// _WHATSNEW_NEW_IMAGE_WIDTH

// 2005-06-14
// _WHATSNEW_MENU_RDF

// 2005-06-06
// _WHATSNEW_SYSTEM_COMMENT

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// --- define language begin ---
if( !defined('WHATSNEW_LANG_AM_LOADED') ) 
{

define('WHATSNEW_LANG_AM_LOADED', 1);

// use $xoopsModule
//define('_WHATSNEW_NAME','What's New');

// use blocks.php
//define('_WHATSNEW_ADMIN_DESC','This module collecte all latest reports from two or more modules, and show it in one block, and show it RSS and ATOM format.');
//define('_WHATSNEW_MENU_CONFIG','Preferences');
//define('_WHATSNEW_MENU_PING','Send of weblog update ping');
//define('_WHATSNEW_MENU_RSS','Refresf of RSS');
//define('_WHATSNEW_MENU_ATOM','Refresh of ATOM');
//define('_WHATSNEW_MENU_RDF','Refresh of RDF');
//define('_WHATSNEW_GOTO_WHATNEW','Goto Module');

// config
define('_WHATSNEW_MID','ID');
define('_WHATSNEW_MNAME','Module name');
define('_WHATSNEW_MDIR','Derectory name');
define('_WHATSNEW_NEW','Whats New Block');
define('_WHATSNEW_RSS','RSS / ATOM');
define('_WHATSNEW_ITEM','Item');
define('_WHATSNEW_LIMIT_SHOW','Number of articles');
define('_WHATSNEW_LIMIT_SUMMARY','Number of showing summary');
define('_WHATSNEW_MAX_SUMMARY','Max chars of summary');
define('_WHATSNEW_NEW_IMAGE','Show image');
define('_WHATSNEW_NEW_PING','Send ping');

//define('_WHATSNEW_SITE_NAME','Site name');
//define('_WHATSNEW_SITE_NAME_DESC','Requirement for RSS/ATOM');
//define('_WHATSNEW_SITE_URL','Site URL');
//define('_WHATSNEW_SITE_URL_DESC','Requirement for RSS/ATOM');
//define('_WHATSNEW_SITE_DESC','Description of site');
//define('_WHATSNEW_SITE_DESC_DESC','Requirement for RSS');
//define('_WHATSNEW_SITE_AUTHOR','Webmaster');
//define('_WHATSNEW_SITE_AUTHOR_DESC','Requirement for ATOM');
//define('_WHATSNEW_SITE_EMAIL','Email of Webmaster');
//define('_WHATSNEW_SITE_EMAIL_DESC','Option for RSS/ATOM');
//define('_WHATSNEW_SITE_LOGO','Logo images of site');
//define('_WHATSNEW_SITE_LOGO_DESC','Option for RSS');

define('_WHATSNEW_PING_SERVERS','List of Ping servers');
define('_WHATSNEW_PING_PASS','Password of update_ping.php');
define('_WHATSNEW_PING_LOG','Log of Ping sending');

//define('_WHATSNEW_SAVE','SAVE');
//define('_WHATSNEW_DELETE','DELETE');
//define('_WHATSNEW_CONFIG_SAVED','Saved config table');
//define('_WHATSNEW_WARNING_NOT_WRITABLE','Not writable for cache derectory');

// not use config file
//define('_WHATSNEW_CONFIG_DELETED','Deleted config file');
//define('_WHATSNEW_WARNING_NOT_EXIST','Not exist of config file');
//define('_WHATSNEW_ERROR_CONFIG','Error in config file');
//define('_WHATSNEW_ERROR_SITE_NAME','no site name');
//define('_WHATSNEW_ERROR_SITE_URL','No site url');
//define('_WHATSNEW_ERROR_SITE_DESC','No site description');
//define('_WHATSNEW_ERROR_SITE_AUTHOR','No webmaster');
//define('_WHATSNEW_ERROR_NEW_MAX_SUMMARY','Not correct of chars of summary in Whats New Block');
//define('_WHATSNEW_ERROR_RSS_MAX_SUMMARY','Not correct chars of summary in RSS/ATOM');

// ping
define('_WHATSNEW_PING_DETAIL','Show detail information');
define('_WHATSNEW_PING','SEND Ping');
define('_WHATSNEW_PING_SENDED','Sended Ping');

// 2005-06-06
define('_WHATSNEW_SYSTEM_COMMENT','Comments');

// 2005-06-20
define('_WHATSNEW_NEW_IMAGE_WIDTH','Max width of image size');
define('_WHATSNEW_NEW_IMAGE_HEIGHT','Max height of image size');
define('_WHATSNEW_NEW_IMAGE_SIZE_NOT_SAVE','NOT save max image size');

//define('_WHATSNEW_VIEW_RSS','Debug view of RSS');
//define('_WHATSNEW_VIEW_RDF','Debug view of RDF');
//define('_WHATSNEW_VIEW_ATOM','Debug view of ATOM');
//define('_WHATSNEW_MENU_PDA','View of PDA');

// 2005-10-01
//define('_WHATSNEW_SYSTEM_GROUPS','System Groups');
//define('_WHATSNEW_SYSTEM_BLOCKS','System Blocks');
define('_WHATSNEW_VIEW_DOCS','Manual');
define('_WHATSNEW_CONFIG_BLOCK','WhatsNew block and RSS/ATOM Configration');
define('_WHATSNEW_CONFIG_MAIN','Main page Configration');
define('_WHATSNEW_CONFIG_SITE','Site Information Configration');
define('_WHATSNEW_CONFIG_PING','Ping Configration');
define('_WHATSNEW_GOTO_MENU_PING','Back to Ping send');

// index
//define('_WHATSNEW_INIT_NOT','Not initialize Config table');
//define('_WHATSNEW_INIT_EXEC','Initialize Config table');
//define('_WHATSNEW_VERSION_NOT','Not Version %s');
//define('_WHATSNEW_UPGRADE_EXEC','Upgrade Config table');

define('_WHATSNEW_NOTICE','Notice');
define('_WHATSNEW_NOTICE_PERM','Anonymous does not have the permission to read this WhatsNew module<br />Anyone cannot read RSS or ATOM');
define('_WHATSNEW_NOTICE_BOTH',"There are plugins in both module's and WhatsNew's<br />The modules' pluging is used in priority.<br />Display direcoty name in <span style='color:#ff0000;'>RED</span> <br />Please delete the older one<br />");

//define('_WHATSNEW_NOTE_RSS_MARK','The mark <b>#</b> in RSS/ATOM means that anonymous have the permission to read each module<br />Someone have permission to read this WhatsNew module can read RSS or ATOM<br />');

define('_WHATSNEW_ICON_LIST','Icon List');

// config item
define('_WHATSNEW_WEIGHT','Weight');
define('_WHATSNEW_MIN_SHOW','Minium number of article showing in each module');
define('_WHATSNEW_BLOCK_ICON','Default of icon');

// conflit to blocks.php
//define('_WHATSNEW_BLOCK_MODULE','Showing order of modules');

define('_WHATSNEW_BLOCK_MODULE_0','Latest');
define('_WHATSNEW_BLOCK_MODULE_1','Weight');
define('_WHATSNEW_BLOCK_SUMMARY_HTML','Allow HTML for summary');
define('_WHATSNEW_BLOCK_MAX_TITLE','Max chars of title');

//define('_WHATSNEW_SITE_TAG','Site tag');
//define('_WHATSNEW_SITE_IMAGE_URL','URL of site logo');
//define('_WHATSNEW_SITE_IMAGE_WIDTH','Width of site logo');
//define('_WHATSNEW_SITE_IMAGE_HEIGHT','Height of site logo');

define('_WHATSNEW_MAIN_TPL',"Main page's template");
define('_WHATSNEW_MAIN_TPL_0','WhatsNew like');
define('_WHATSNEW_MAIN_TPL_1','BopCommnets like');

// --- 2006-06-18 ---
define('_WHATSNEW_CONFIG_RSS', 'RDF/RSS/ATOM Build Configration');

//define('_WHATSNEW_RSS_PERMIT_USER', 'Permit user to show RSS feed');
//define('_WHATSNEW_RSS_PERMIT_USER_DESC', 'Anoymous user can show RSS feed always');

// --- 2006-06-25 ---
define('_WHATSNEW_PLUGIN', 'Plugin');
define('_WHATSNEW_MOD_VERSION', 'Version');
define('_WHATSNEW_NOTICE_PLURAL','There are plural plugins in one module<br />Please select appropriate plugin<br />');

// --- 2007-05-12 ---
define('_WHATSNEW_NOTICE_IMAGE_SIZE', 'a warning is displayed in XOOPS logo.gif when checking an image size according to the specification. <br />This value will be permissible. ');

// --- 2007-10-10 ---
// banner
define('_WHATSNEW_BANNER_FLAG',   'Show banner image');
define('_WHATSNEW_BANNER_WIDTH',  'Max width of banner size');
define('_WHATSNEW_BANNER_HEIGHT', 'Max height of banner size');


// --- 2007-11-24 ---
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
// --- define language end ---

?>