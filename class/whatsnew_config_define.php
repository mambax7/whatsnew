<?php
// $Id: whatsnew_config_define.php,v 1.14 2008/01/10 11:44:40 ohwada Exp $

// 2008-01-10 K.OHWADA
// Notice [PHP]: Only variables should be assigned by reference 

// 2007-12-01 K.OHWADA
// renewal numbering
// WHATSNEW_C_CATID_SITEINFO
// newday_days
// block_icon_default -> icon_default

// 2007-11-11 K.OHWADA
// happy_linux_rss_default

// 2007-10-10 K.OHWADA
// banner cache_time

// 2007-06-01 K.OHWADA
// site_image_logo

// 2007-05-12 K.OHWADA
// module dupulication
// XC 2.1 : change author from meta_author to user with uid=1

// 2006-06-20 K.OHWADA
// REQ 3873: login user can read RSS.
// add rss_permit_user

//================================================================
// What's New Module
// class config define
// 2005-10-01 K.OHWADA
//================================================================

// === class begin ===
if( !class_exists('whatsnew_config_define') ) 
{

// manage_rss.php
// admin_config_class.php
define('WHATSNEW_C_CATID_SITEINFO', 8 );

//=========================================================
// class whatsnew_config_define
//=========================================================
class whatsnew_config_define extends happy_linux_config_define_base
{
	var $_DIRNAME;

	var $_rss_default;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_config_define( $dirname )
{
	$this->happy_linux_config_define_base();

	$this->_DIRNAME = $dirname;
	$this->_rss_default =& happy_linux_rss_default::getInstance();

}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_config_define( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// function
// same as xoops_version.php
//---------------------------------------------------------
// Notice [PHP]: Only variables should be assigned by reference 
function &get_define()
{

// constant
	$MAX_SHOW          = 10;
	$MIM_SHOW          = 1;
	$LIMIT_SUMMARY     = 1;
	$MAX_SUMMARY_MAIN  = 1000;
	$MAX_SUMMARY_BLOCK = 250;
	$MAX_TITLE_MAIN    = 100;
	$MAX_TITLE_BLOCK   = 30;

	$BLOCK_ICON = 'ball.gray.gif';

// site information
	$site_name         = $this->_rss_default->get_default_site_name();
	$site_desc         = $this->_rss_default->get_default_site_desc();
	$site_url          = $this->_rss_default->get_default_site_url();
	$site_tag          = $this->_rss_default->get_default_site_tag();
	$site_author_name  = $this->_rss_default->get_default_site_author_name();
	$site_author_email = $this->_rss_default->get_default_site_author_email();
	$site_author_uri   = $this->_rss_default->get_default_site_author_uri();
	$site_image_logo   = 'modules/'.$this->_DIRNAME.'/images/xoops_logo.gif';
	list($site_image_url, $site_image_width, $site_image_height) = 
		$this->_rss_default->get_site_image_size( $site_image_logo );

	$adminmail = $this->_rss_default->get_xoops_adminmail();

	$perm_opts = array(
		_AM_WHATSNEW_CONF_PERM_NOT_SHOW => 0,
		_AM_WHATSNEW_CONF_PERM_SHOW     => 1,
	);

//---------------------------------------------------------
// config 1
//---------------------------------------------------------
// module 
	$config[1]['name']      = 'comment_name';
	$config[1]['catid']     = 1;
	$config[1]['valuetype'] = 'text';
	$config[1]['default']   = _WHATSNEW_SYSTEM_COMMENT;

	$config[2]['name']      = 'comment_weight';
	$config[2]['catid']     = 1;
	$config[2]['valuetype'] = 'int';
	$config[2]['default']   = 99;

// block 
	$config[3]['name']      = 'icon_default';
	$config[3]['catid']     = 1;
	$config[3]['title']     = '_WHATSNEW_BLOCK_ICON';
	$config[3]['valuetype'] = 'text';
	$config[3]['default']   = $BLOCK_ICON;

//---------------------------------------------------------
// config 2
//---------------------------------------------------------
// view style
	$config[11]['name']      = 'image_width';
	$config[11]['catid']     = 2;
	$config[11]['title']     = '_WHATSNEW_NEW_IMAGE_WIDTH';
	$config[11]['valuetype'] = 'int';
	$config[11]['default']   = 160;

	$config[12]['name']      = 'image_height';
	$config[12]['catid']     = 2;
	$config[12]['title']     = '_WHATSNEW_NEW_IMAGE_HEIGHT';
	$config[12]['valuetype'] = 'int';
	$config[12]['default']   = 120;

	$config[13]['name']      = 'banner_width';
	$config[13]['catid']     = 2;
	$config[13]['title']     = '_WHATSNEW_BANNER_WIDTH';
	$config[13]['valuetype'] = 'int';
	$config[13]['default']   = 52;

	$config[14]['name']      = 'banner_height';
	$config[14]['catid']     = 2;
	$config[14]['title']     = '_WHATSNEW_BANNER_HEIGHT';
	$config[14]['valuetype'] = 'int';
	$config[14]['default']   = 40;

	$config[15]['name']        = 'newday_days';
	$config[15]['catid']       = 2;
	$config[15]['title']       = '_AM_WHATSNEW_CONF_NEWDAY_DAYS';
	$config[15]['formtype']    = 'text';
	$config[15]['valuetype']   = 'int';
	$config[15]['default']     = 7;

	$config[16]['name']      = 'newday_strings';
	$config[16]['catid']     = 2;
	$config[16]['title']     = '_AM_WHATSNEW_CONF_NEWDAY_STRINGS';
	$config[16]['formtype']  = 'text';
	$config[16]['valuetype'] = 'text';
	$config[16]['default']   = 'New!';

	$config[17]['name']      = 'newday_style';
	$config[17]['catid']     = 2;
	$config[17]['title']     = '_AM_WHATSNEW_CONF_NEWDAY_STYLE';
	$config[17]['formtype']  = 'text';
	$config[17]['valuetype'] = 'text';
	$config[17]['default']   = 'color:#ff0000;';

	$config[18]['name']        = 'today_hours';
	$config[18]['catid']       = 2;
	$config[18]['title']       = '_AM_WHATSNEW_CONF_TODAY_HOURS';
	$config[18]['formtype']    = 'text';
	$config[18]['valuetype']   = 'int';
	$config[18]['default']     = 24;

	$config[19]['name']      = 'today_strings';
	$config[19]['catid']     = 2;
	$config[19]['title']     = '_AM_WHATSNEW_CONF_TODAY_STRINGS';
	$config[19]['formtype']  = 'text';
	$config[19]['valuetype'] = 'text';
	$config[19]['default']   = 'Today!';

	$config[21]['name']      = 'today_style';
	$config[21]['catid']     = 2;
	$config[21]['title']     = '_AM_WHATSNEW_CONF_TODAY_STYLE';
	$config[21]['formtype']  = 'text';
	$config[21]['valuetype'] = 'text';
	$config[21]['default']   = 'color:#ff0000; font-weight:bold;';

	$config[25]['name']      = 'view_label_1';
	$config[25]['catid']     = 2;
	$config[25]['title']     = '-----';
	$config[25]['formtype'] = 'label';
	$config[25]['valuetype'] = 'text';
	$config[25]['default']   = '-----';

	$config[26]['name']      = 'main_tpl';
	$config[26]['catid']     = 2;
	$config[26]['title']     = '_WHATSNEW_MAIN_TPL';
	$config[26]['formtype']  = 'radio_select';
	$config[26]['valuetype'] = 'int';
	$config[26]['default']   = 0;
	$config[26]['options']   = array(
		_WHATSNEW_MAIN_TPL_0 => 0,
		_WHATSNEW_MAIN_TPL_1 => 1
	);

	$config[27]['name']      = 'block_module_order';
	$config[27]['catid']     = 2;
	$config[27]['title']     = '_AM_WHATSNEW_CONF_BLOCK_MODULE_ORDER';
	$config[27]['formtype'] = 'radio';
	$config[27]['valuetype'] = 'int';
	$config[27]['default']   = 0;
	$config[27]['options']   = array(
		_WHATSNEW_BLOCK_MODULE_0 => 0,
		_WHATSNEW_BLOCK_MODULE_1 => 1
	);

// main page
	$config[31]['name']      = 'main_cache_time';
	$config[31]['catid']     = 3;
	$config[31]['title']     = '_HAPPY_LINUX_CONF_RSS_CACHE_TIME';
	$config[31]['formtype']  = 'text';
	$config[31]['valuetype'] = 'int';
	$config[31]['default']   = 3600;

//	$config[32]['name']      = 'main_max_show';
//	$config[33]['name']      = 'main_min_show';

	$config[34]['name']      = 'main_limit_summary';
	$config[34]['catid']     = 3;
	$config[34]['title']     = '_WHATSNEW_LIMIT_SUMMARY';
	$config[34]['valuetype'] = 'int';
	$config[34]['default']   = $LIMIT_SUMMARY;

	$config[35]['name']      = 'main_max_title';
	$config[35]['catid']     = 3;
	$config[35]['title']     = '_WHATSNEW_BLOCK_MAX_TITLE';
	$config[35]['valuetype'] = 'int';
	$config[35]['default']   = $MAX_TITLE_MAIN;

	$config[36]['name']      = 'main_max_summary';
	$config[36]['catid']     = 3;
	$config[36]['title']     = '_WHATSNEW_MAX_SUMMARY';
	$config[36]['valuetype'] = 'int';
	$config[36]['default']   = $MAX_SUMMARY_MAIN;

	$config[37]['name']      = 'main_summary_html';
	$config[37]['catid']     = 3;
	$config[37]['title']     = '_WHATSNEW_BLOCK_SUMMARY_HTML';
	$config[37]['formtype']  = 'yesno';
	$config[37]['valuetype'] = 'int';
	$config[37]['default']   = 1;

	$config[38]['name']      = 'main_image_flag';
	$config[38]['catid']     = 3;
	$config[38]['title']     = '_WHATSNEW_NEW_IMAGE';
	$config[38]['formtype']  = 'yesno';
	$config[38]['valuetype'] = 'int';
	$config[38]['default']   = 1;

	$config[39]['name']      = 'main_banner_flag';
	$config[39]['catid']     = 3;
	$config[39]['title']     = '_WHATSNEW_BANNER_FLAG';
	$config[39]['formtype']  = 'yesno';
	$config[39]['valuetype'] = 'int';
	$config[39]['default']   = 1;

	$config[41]['name']        = 'main_newday';
	$config[41]['catid']       = 3;
	$config[41]['title']       = '_AM_WHATSNEW_CONF_NEWDAY';
	$config[41]['formtype']    = 'yesno';
	$config[41]['valuetype']   = 'int';
	$config[41]['default']     = 1;

	$config[42]['name']        = 'main_today';
	$config[42]['catid']       = 3;
	$config[42]['title']       = '_AM_WHATSNEW_CONF_TODAY';
	$config[42]['description'] = '_AM_WHATSNEW_CONF_TODAY_DSC';
	$config[42]['formtype']    = 'yesno';
	$config[42]['valuetype']   = 'int';
	$config[42]['default']     = 1;

	$config[43]['name']        = 'main_date_strings';
	$config[43]['catid']       = 3;
	$config[43]['title']       = '_AM_WHATSNEW_CONF_DATE_STRINGS';
	$config[43]['description'] = '_AM_WHATSNEW_CONF_DATE_STRINGS_DSC';
	$config[43]['formtype']    = 'text';
	$config[43]['valuetype']   = 'text';
	$config[43]['default']     = _DATESTRING;	// long

	$config[44]['name']      = 'main_ping';
	$config[44]['catid']     = 3;
	$config[44]['title']     = '_WHATSNEW_NEW_PING';
	$config[44]['formtype']  = 'yesno';
	$config[44]['valuetype'] = 'int';
	$config[44]['default']   = 0;

// block
	$config[51]['name']      = 'block_cache_time';
	$config[51]['catid']     = 5;
	$config[51]['title']     = '_HAPPY_LINUX_CONF_RSS_CACHE_TIME';
	$config[51]['formtype']  = 'text';
	$config[51]['valuetype'] = 'int';
	$config[51]['default']   = 3600;

	$config[52]['name']      = 'block_max_show';
	$config[52]['catid']     = 5;
	$config[52]['title']     = '_WHATSNEW_LIMIT_SHOW';
	$config[52]['valuetype'] = 'int';
	$config[52]['default']   = $MAX_SHOW;

	$config[53]['name']      = 'block_min_show';
	$config[53]['catid']     = 5;
	$config[53]['title']     = '_WHATSNEW_MIN_SHOW';
	$config[53]['valuetype'] = 'int';
	$config[53]['default']   = $MIM_SHOW;

	$config[54]['name']      = 'block_limit_summary';
	$config[54]['catid']     = 5;
	$config[54]['title']     = '_WHATSNEW_LIMIT_SUMMARY';
	$config[54]['valuetype'] = 'int';
	$config[54]['default']   = $LIMIT_SUMMARY;

	$config[55]['name']      = 'block_max_title';
	$config[55]['catid']     = 5;
	$config[55]['title']     = '_WHATSNEW_BLOCK_MAX_TITLE';
	$config[55]['valuetype'] = 'int';
	$config[55]['default']   = $MAX_TITLE_BLOCK;

	$config[56]['name']      = 'block_max_summary';
	$config[56]['catid']     = 5;
	$config[56]['title']     = '_WHATSNEW_MAX_SUMMARY';
	$config[56]['valuetype'] = 'int';
	$config[56]['default']   = $MAX_SUMMARY_BLOCK;

	$config[57]['name']      = 'block_summary_html';
	$config[57]['catid']     = 5;
	$config[57]['title']     = '_WHATSNEW_BLOCK_SUMMARY_HTML';
	$config[57]['formtype']  = 'yesno';
	$config[57]['valuetype'] = 'int';
	$config[57]['default']   = 0;

	$config[58]['name']      = 'block_image_flag';
	$config[58]['catid']     = 5;
	$config[58]['title']     = '_WHATSNEW_NEW_IMAGE';
	$config[58]['formtype']  = 'yesno';
	$config[58]['valuetype'] = 'int';
	$config[58]['default']   = 1;

	$config[59]['name']      = 'block_banner_flag';
	$config[59]['catid']     = 5;
	$config[59]['title']     = '_WHATSNEW_BANNER_FLAG';
	$config[59]['formtype']  = 'yesno';
	$config[59]['valuetype'] = 'int';
	$config[59]['default']   = 1;

	$config[61]['name']        = 'block_newday';
	$config[61]['catid']       = 5;
	$config[61]['title']       = '_AM_WHATSNEW_CONF_NEWDAY';
	$config[61]['formtype']    = 'yesno';
	$config[61]['valuetype']   = 'int';
	$config[61]['default']     = 1;

	$config[62]['name']        = 'block_today';
	$config[62]['catid']       = 5;
	$config[62]['title']       = '_AM_WHATSNEW_CONF_TODAY';
	$config[62]['description'] = '_AM_WHATSNEW_CONF_TODAY_DSC';
	$config[62]['formtype']    = 'yesno';
	$config[62]['valuetype']   = 'int';
	$config[62]['default']     = 1;

	$config[63]['name']        = 'block_date_strings';
	$config[63]['catid']       = 5;
	$config[63]['title']       = '_AM_WHATSNEW_CONF_DATE_STRINGS';
	$config[63]['description'] = '_AM_WHATSNEW_CONF_DATE_STRINGS_DSC';
	$config[63]['formtype']    = 'text';
	$config[63]['valuetype']   = 'text';
	$config[63]['default']     = _DATESTRING;	// long

	$config[64]['name']      = 'block_ping';
	$config[64]['catid']     = 5;
	$config[64]['title']     = '_WHATSNEW_NEW_PING';
	$config[64]['formtype']  = 'yesno';
	$config[64]['valuetype'] = 'int';
	$config[64]['default']   = 0;

// rss
	$config[71]['name']      = 'rss_cache_time';
	$config[71]['catid']     = 7;
	$config[71]['title']     = '_HAPPY_LINUX_CONF_RSS_CACHE_TIME';
	$config[71]['formtype']  = 'text';
	$config[71]['valuetype'] = 'int';
	$config[71]['default']   = 3600;

	$config[72]['name']      = 'rss_max_show';
	$config[72]['catid']     = 7;
	$config[72]['title']     = '_WHATSNEW_LIMIT_SHOW';
	$config[72]['valuetype'] = 'int';
	$config[72]['default']   = $MAX_SHOW;

	$config[73]['name']      = 'rss_min_show';
	$config[73]['catid']     = 7;
	$config[73]['title']     = '_WHATSNEW_MIN_SHOW';
	$config[73]['valuetype'] = 'int';
	$config[73]['default']   = $MIM_SHOW;

//---------------------------------------------------------
// rss
//---------------------------------------------------------

// site
	$config[81]['name']         = 'site_name';
	$config[81]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[81]['title']        = '_HAPPY_LINUX_VIEW_SITE_TITLE';
	$config[81]['description']  = '_HAPPY_LINUX_VIEW_RSS_ATOM_REQUIRE';
	$config[81]['formtype']     = 'textbox';
	$config[81]['valuetype']    = 'text';
	$config[81]['default']      = $site_name;

	$config[82]['name']         = 'site_url';
	$config[82]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[82]['title']        = '_HAPPY_LINUX_VIEW_SITE_LINK';
	$config[82]['description']  = '_HAPPY_LINUX_VIEW_RSS_ATOM_REQUIRE';
	$config[82]['formtype']     = 'textbox';
	$config[82]['valuetype']    = 'text';
	$config[82]['default']      = $site_url;

	$config[83]['name']         = 'site_tag';
	$config[83]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[83]['title']        = '';
	$config[83]['description']  = '_HAPPY_LINUX_VIEW_SITE_TAG';
	$config[83]['formtype']     = 'label';
	$config[83]['valuetype']    = 'text';
	$config[83]['default']      = $site_tag;

	$config[84]['name']         = 'site_desc';
	$config[84]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[84]['title']        = '_HAPPY_LINUX_VIEW_SITE_DESCRIPTION';
	$config[84]['description']  = '_HAPPY_LINUX_VIEW_RSS_REQUIRE';
	$config[84]['formtype']     = 'textbox';
	$config[84]['valuetype']    = 'text';
	$config[84]['default']      = $site_desc;

	$config[85]['name']         = 'site_author';
	$config[85]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[85]['title']        = '_HAPPY_LINUX_VIEW_AUTHOR_NAME';
	$config[85]['description']  = '_HAPPY_LINUX_VIEW_ATOM_REQUIRE';
	$config[85]['formtype']     = 'textbox';
	$config[85]['valuetype']    = 'text';
	$config[85]['default']      = $site_author_name;

	$config[86]['name']         = 'site_email';
	$config[86]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[86]['title']        = '_HAPPY_LINUX_VIEW_AUTHOR_EMAIL';
	$config[86]['description']  = '_HAPPY_LINUX_VIEW_OPTION';
	$config[86]['formtype']     = 'textbox';
	$config[86]['valuetype']    = 'text';
	$config[86]['default']      = $site_author_email;

	$config[87]['name']         = 'site_image_logo';
	$config[87]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[87]['title']        = '_HAPPY_LINUX_VIEW_SITE_LOGO';
	$config[87]['description']  = '_HAPPY_LINUX_VIEW_OPTION';
	$config[87]['formtype']     = 'textbox';
	$config[87]['valuetype']    = 'text';
	$config[87]['default']      = $site_image_logo;

	$config[88]['name']         = 'site_image_url';
	$config[88]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[88]['title']        = '';
	$config[88]['description']  = '_HAPPY_LINUX_VIEW_RSS_IMAGE_URL';
	$config[88]['formtype']     = 'label_image';
	$config[88]['valuetype']    = 'text';
	$config[88]['default']      = $site_image_url;

	$config[89]['name']         = 'site_image_width';
	$config[89]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[89]['title']        = '';
	$config[89]['description']  = '_HAPPY_LINUX_VIEW_RSS_IMAGE_WIDTH';
	$config[89]['formtype']     = 'extra_site_image_width';
	$config[89]['valuetype']    = 'int';
	$config[89]['default']      = $site_image_width;

	$config[91]['name']         = 'site_image_height';
	$config[91]['catid']        = WHATSNEW_C_CATID_SITEINFO;
	$config[91]['title']        = '';
	$config[91]['description']  = '_HAPPY_LINUX_VIEW_RSS_IMAGE_HEIGHT';
	$config[91]['formtype']     = 'extra_site_image_height';
	$config[91]['valuetype']    = 'int';
	$config[91]['default']      = $site_image_height;

//---------------------------------------------------------
// ping
//---------------------------------------------------------
// ping
	$config[101]['name']      = 'ping_servers';
	$config[101]['catid']     = 10;
	$config[101]['title']     = '_WHATSNEW_PING_SERVERS';
	$config[101]['formtype']  = 'textarea';
	$config[101]['valuetype'] = 'textarea';
	$config[101]['default']   = $this->get_ping_servers();

	$config[102]['name']      = 'ping_log';
	$config[102]['catid']     = 10;
	$config[102]['title']     = '_WHATSNEW_PING_LOG';
	$config[102]['formtype']  = 'yesno';
	$config[102]['valuetype'] = 'int';
	$config[102]['default']   = 1;

	$config[103]['name']      = 'ping_time';
	$config[103]['catid']     = 0;
	$config[103]['title']     = '';
	$config[103]['valuetype'] = 'int';
	$config[103]['default']   = 0;

// bin ping
	$config[111]['name']      = 'ping_pass';
	$config[111]['catid']     = 11;
	$config[111]['title']     = '_HAPPY_LINUX_CONF_BIN_PASS';
	$config[111]['formtype']  = 'textbox';
	$config[111]['valuetype'] = 'text';
	$config[111]['default']   = xoops_makepass();

	$config[112]['name']      = 'bin_send';
	$config[112]['catid']     = 11;
	$config[112]['title']     = '_HAPPY_LINUX_CONF_BIN_SEND';
	$config[112]['formtype']  = 'radio';
	$config[112]['valuetype'] = 'int';
	$config[112]['default']   = 1;
	$config[112]['options']   = array(
		_HAPPY_LINUX_CONF_BIN_SEND_NON     => 0,
		_HAPPY_LINUX_CONF_BIN_SEND_EXECUTE => 1,
		_HAPPY_LINUX_CONF_BIN_SEND_ALWAYS  => 2,
	);

	$config[113]['name']      = 'bin_mailto';
	$config[113]['catid']     = 11;
	$config[113]['title']     = '_HAPPY_LINUX_CONF_BIN_MAILTO';
	$config[113]['formtype']  = 'text';
	$config[113]['valuetype'] = 'text';
	$config[113]['default']   = $adminmail;

//---------------------------------------------------------
// permission
//---------------------------------------------------------
	$config[121]['name']         = 'perm_module';
	$config[121]['catid']        = 12;
	$config[121]['title']        = '_AM_WHATSNEW_CONF_PERM_MODULE';
	$config[121]['description']  = '_AM_WHATSNEW_CONF_PERM_MODULE_DSC';
	$config[121]['formtype']     = 'radio';
	$config[121]['valuetype']    = 'int';
	$config[121]['default']      = 0;
	$config[121]['options']      = $perm_opts;

	$config[122]['name']         = 'perm_mod_link';
	$config[122]['catid']        = 12;
	$config[122]['title']        = '_AM_WHATSNEW_CONF_PERM_MOD_LINK';
	$config[122]['formtype']     = 'radio';
	$config[122]['valuetype']    = 'int';
	$config[122]['default']      = 0;
	$config[122]['options']      = $perm_opts;

	$config[123]['name']         = 'perm_cat_link';
	$config[123]['catid']        = 12;
	$config[123]['title']        = '_AM_WHATSNEW_CONF_PERM_CAT_LINK';
	$config[123]['formtype']     = 'radio';
	$config[123]['valuetype']    = 'int';
	$config[123]['default']      = 0;
	$config[123]['options']      = $perm_opts;

	$config[124]['name']         = 'perm_link';
	$config[124]['catid']        = 12;
	$config[124]['title']        = '_AM_WHATSNEW_CONF_PERM_LINK';
	$config[124]['formtype']     = 'radio';
	$config[124]['valuetype']    = 'int';
	$config[124]['default']      = 0;
	$config[124]['options']      = $perm_opts;

	$config[125]['name']         = 'perm_dirname';
	$config[125]['catid']        = 12;
	$config[125]['title']        = '_AM_WHATSNEW_CONF_PERM_DIRNAME';
	$config[125]['formtype']     = 'radio';
	$config[125]['valuetype']    = 'int';
	$config[125]['default']      = 1;
	$config[125]['options']      = $perm_opts;

	$config[126]['name']         = 'perm_mod_name';
	$config[126]['catid']        = 12;
	$config[126]['title']        = '_AM_WHATSNEW_CONF_PERM_MOD_NAME';
	$config[126]['formtype']     = 'radio';
	$config[126]['valuetype']    = 'int';
	$config[126]['default']      = 1;
	$config[126]['options']      = $perm_opts;

	$config[127]['name']         = 'perm_mod_icon';
	$config[127]['catid']        = 12;
	$config[127]['title']        = '_AM_WHATSNEW_CONF_PERM_MOD_ICON';
	$config[127]['formtype']     = 'radio';
	$config[127]['valuetype']    = 'int';
	$config[127]['default']      = 1;
	$config[127]['options']      = $perm_opts;

	$config[128]['name']         = 'perm_cat_name';
	$config[128]['catid']        = 12;
	$config[128]['title']        = '_AM_WHATSNEW_CONF_PERM_CAT_NAME';
	$config[128]['formtype']     = 'radio';
	$config[128]['valuetype']    = 'int';
	$config[128]['default']      = 1;
	$config[128]['options']      = $perm_opts;

	$config[129]['name']         = 'perm_title';
	$config[129]['catid']        = 12;
	$config[129]['title']        = '_AM_WHATSNEW_CONF_PERM_TITLE';
	$config[129]['formtype']     = 'radio';
	$config[129]['valuetype']    = 'int';
	$config[129]['default']      = 1;
	$config[129]['options']      = $perm_opts;

	$config[131]['name']         = 'perm_time';
	$config[131]['catid']        = 12;
	$config[131]['title']        = '_WHATSNEW_BLOCK_DATE';
	$config[131]['formtype']     = 'radio';
	$config[131]['valuetype']    = 'int';
	$config[131]['default']      = 1;
	$config[131]['options']      = $perm_opts;

	$config[132]['name']         = 'perm_uid';
	$config[132]['catid']        = 12;
	$config[132]['title']        = '_WHATSNEW_BLOCK_USER';
	$config[132]['formtype']     = 'radio';
	$config[132]['valuetype']    = 'int';
	$config[132]['default']      = 0;
	$config[132]['options']      = $perm_opts;

	$config[133]['name']         = 'perm_hits';
	$config[133]['catid']        = 12;
	$config[133]['title']        = '_WHATSNEW_BLOCK_HITS';
	$config[133]['formtype']     = 'radio';
	$config[133]['valuetype']    = 'int';
	$config[133]['default']      = 0;
	$config[133]['options']      = $perm_opts;

	$config[134]['name']         = 'perm_replies';
	$config[134]['catid']        = 12;
	$config[134]['title']        = '_WHATSNEW_BLOCK_REPLIES';
	$config[134]['formtype']     = 'radio';
	$config[134]['valuetype']    = 'int';
	$config[134]['default']      = 0;
	$config[134]['options']      = $perm_opts;

	$config[135]['name']         = 'perm_description';
	$config[135]['catid']        = 12;
	$config[135]['title']        = '_AM_WHATSNEW_CONF_PERM_SUMMARY';
	$config[135]['formtype']     = 'radio';
	$config[135]['valuetype']    = 'int';
	$config[135]['default']      = 0;
	$config[135]['options']      = $perm_opts;

	$config[136]['name']         = 'perm_image';
	$config[136]['catid']        = 12;
	$config[136]['title']        = '_AM_WHATSNEW_CONF_PERM_IMAGE';
	$config[136]['formtype']     = 'radio';
	$config[136]['valuetype']    = 'int';
	$config[136]['default']      = 0;
	$config[136]['options']      = $perm_opts;

	$config[137]['name']         = 'perm_banner_url';
	$config[137]['catid']        = 12;
	$config[137]['title']        = '_AM_WHATSNEW_CONF_PERM_BANNER';
	$config[137]['formtype']     = 'radio';
	$config[137]['valuetype']    = 'int';
	$config[137]['default']      = 0;
	$config[137]['options']      = $perm_opts;

//---------------------------------------------------------
	return $config;
}

//---------------------------------------------------------
// default value
//---------------------------------------------------------
function get_ping_servers()
{
	$locate =& happy_linux_locate_factory::getInstance();
	$ping_servers = $locate->get_var( 'ping_servers' );
	$ping_servers .= XOOPS_URL.'/modules/'.$this->_DIRNAME."/bin/server.php\n";
	return $ping_servers;
}

// --- class end ---
}

// === class end ===
}

?>