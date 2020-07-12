<?php
// $Id: admin_config_class.php,v 1.18 2007/12/15 22:48:46 ohwada Exp $

// 2007-12-16 K.OHWADA
// BUG : Fatal error: Call to a member function on a non-object

// 2007-12-01 K.OHWADA
// WHATSNEW_C_CATID_SITEINFO
// show_form_main_block()
// get_by_mid()
// permit field

// 2007-11-11 K.OHWADA
// build_block_handler
// banner cache_time
// whatsnew_install

// 2007-06-01 K.OHWADA
// check_multi_plugin()

// 2007-05-12 K.OHWADA
// module dupulication
// XC 2.1 system comment
// add class admin_config_store
// WHATSNEW_FIELD_PLUGIN -> 'plugin'

// 2006-06-25 K.OHWADA
// add show_form_plugins() print_form_plugin() more
// change name flag_both to flag_plural_plugins

// 2006-06-20 K.OHWADA
// REQ 3873: login user can read RSS.
// add check_version()

// 2005-11-06 K.OHWADA
// BUG 3169: need to sanitaize $_SERVER['PHP_SELF']

// 2005-10-01 K.OHWADA
// change index.php to class

//=========================================================
// What's New Module
// this file contain 2 class
//   admin_config_form 
//   admin_config_store
// 2004/08/20 K.OHWADA
//=========================================================

//================================================================
// class admin_config_form
//================================================================
class admin_config_form extends whatsnew_config_form
{
// constant
	var $LIMIT_MODULE_DEFAULT = 5;
	var $MAX_ICON_COL         = 5;

// icon
	var $_DIR_ICON_REL = "images/icons";
	var $_DIR_ICON;
	var $_URL_ICON;

// class
	var $_module_handler;
	var $_module_store_handler;
	var $_build_block_handler;
	var $_system;
	var $_post;

	var $icon_array;

// variable
	var $_system_module_array;
	var $_line_count = 0;
	var $_is_active_legacy_module = false;

	var $_flag_all_modules = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function admin_config_form()
{
	$this->whatsnew_config_form();

	$define =& whatsnew_config_define::getInstance( WHATSNEW_DIRNAME );
	$this->set_config_handler('config', WHATSNEW_DIRNAME, 'whatsnew');
	$this->set_config_define( $define );

// icon
	$this->_DIR_ICON = WHATSNEW_ROOT_PATH . '/' . $this->_DIR_ICON_REL;
	$this->_URL_ICON = WHATSNEW_URL       . '/' . $this->_DIR_ICON_REL;

// class
	$this->_module_handler       =& whatsnew_get_handler('module',       WHATSNEW_DIRNAME );
	$this->_module_store_handler =& whatsnew_get_handler('module_store', WHATSNEW_DIRNAME );
	$this->_build_block_handler  =& whatsnew_get_handler('build_block',  WHATSNEW_DIRNAME );
	$this->_system               =& happy_linux_system::getInstance();
	$this->_post                 =& happy_linux_post::getInstance();

	$this->_is_active_legacy_module = $this->_system->is_active_legacy_module();

// init
	$this->load();
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new admin_config_form();
	}
	return $instance;
}

//=========================================================
// main function
//=========================================================
function show_form()
{
// system module config
	$this->_module_store_handler->load_system_module();
	$system_arr  = $this->_module_store_handler->get_system_module();
	$weight_arr  = $this->_module_store_handler->get_system_module_weight();
	$flag_plural = $this->_module_store_handler->get_flag_plural_plugins();

// this modulue'e guest permission
	$mid        = $this->_system->get_mid();
	$perm_guest = $system_arr[$mid]['perm_guest'];

	if (!$perm_guest)
	{
		echo "<h4><font color='red'>"._WHATSNEW_NOTICE."</font></h4>\n";
		echo _WHATSNEW_NOTICE_PERM."\n";
	}

	if ( $flag_plural )
	{
		echo "<h4><font color='red'>"._WHATSNEW_NOTICE."</font></h4>\n";
		echo _WHATSNEW_NOTICE_PLURAL."\n";
		echo "<br />\n";
		$this->show_form_plugins($system_arr, $weight_arr);
	}

	$this->get_icon_array();
	$this->show_form_modules($system_arr, $weight_arr);
}

function show_form_plugins( &$system_arr, &$weight_arr )
{
	echo $this->build_form_begin('whatsnew_plugin');
	echo $this->build_token();
	echo $this->build_html_input_hidden('op',   'save');
	echo $this->build_html_input_hidden('mode', 'module');

	echo '<table class="outer" width="100%">'."\n";
	echo '<tr>';
	echo '<th align="center">'._WHATSNEW_MID.'</th>'."\n";
	echo '<th align="center">'._WHATSNEW_MNAME.'</th>'."\n";
	echo '<th align="center">'._WHATSNEW_MDIR.'</th>'."\n";
	echo '<th align="center">'._WHATSNEW_MOD_VERSION.'</th>'."\n";
	echo '<th align="center">'._WHATSNEW_PLUGIN.'</th>'."\n";
	echo '</tr>'."\n";

// list from system module
	foreach ( $weight_arr as $mid => $weight ) 
	{
		if ($mid != 1)
		{
			$system = $system_arr[$mid];

			if ( $this->check_multi_plugin($system) )
			{
				$this->_print_form_plugin($mid, $system);
			}
		}
	}

	echo '<tr class="foot"><td></td><td></td><td colspan="3">';
	echo $this->build_form_submit( 'submit', _HAPPY_LINUX_UPDATE );
	echo '</tr>'."\n";
	echo '</table>'."\n";
	echo $this->build_form_end();
	echo '<br />'."\n";
}

function check_multi_plugin( &$system )
{
	if (($system['in_module'] && $system['in_whatsnew']) || $system['in_version'])
	{
		return true;
	}
	return false;
}

function show_form_modules( &$system_arr, &$weight_arr )
{
	if ( $this->_post->get_get_text('show') == 'all' )
	{	$this->_flag_all_modules = true;	}

	echo "<br />\n";
	echo '<div align="right"><a href="?show=all">Show All Modules</a></div>';

	$this->_print_form_top();

// list from system module
	foreach ( $weight_arr as $mid => $weight ) 
	{
		$system = $system_arr[$mid];
		$this->_print_form_mod($mid, $system, $weight);
	}

	$this->_print_form_conf_icon('icon_default');
	$this->_print_form_bottom();
}

function show_icon_list()
{
	$icon_arr = $this->icon_array;

	$count   = count($icon_arr) ;
	$max_col = $count / $this->MAX_ICON_COL;

	echo "<table>\n";

	for ($i=0; $i<$max_col; $i++)
	{
		echo "<tr>";

		for ($j=0; $j<$this->MAX_ICON_COL; $j++)
		{
			$ii   = $this->MAX_ICON_COL * $i + $j;
			$icon = array_shift( $icon_arr );

			if ($icon)
			{
				$url_icon  = $this->_URL_ICON."/".$icon;
				echo "<td> ";
				echo $this->build_html_img_tag($url_icon, 0, 0, 0, $icon);
				echo " $icon </td>";
			}
			else
			{
				echo "<td></td>";
			}
		}

		echo "</tr>\n";

		if ($ii > $count)  break;
	}

	echo "</table>\n";

}

function show_form_main_block()
{
	$this->_print_form_top_2();

	$this->_print_form_conf_three_2(   'main_cache_time',    'block_cache_time',  'rss_cache_time');
	$this->_print_form_conf_three_2(   '',                   'block_max_show',    'rss_max_show');
	$this->_print_form_conf_three_2(   '',                   'block_min_show',    'rss_min_show');
	$this->_print_form_conf_three_2(   'main_limit_summary', 'block_limit_summary');
	$this->_print_form_conf_three_2(   'main_max_title',     'block_max_title');
	$this->_print_form_conf_three_2(   'main_max_summary',   'block_max_summary');
	$this->_print_form_conf_three_2(   'main_date_strings',  'block_date_strings', '', 15 );
	$this->_print_form_conf_checkbox_2('main_summary_html',  'block_summary_html');
	$this->_print_form_conf_checkbox_2('main_image_flag',    'block_image_flag');
	$this->_print_form_conf_checkbox_2('main_banner_flag',   'block_banner_flag');
	$this->_print_form_conf_checkbox_2('main_newday',        'block_newday');
	$this->_print_form_conf_checkbox_2('main_today',         'block_today');
	$this->_print_form_conf_checkbox_2('main_ping',          'block_ping');

	$this->_print_form_bottom_2();
}

//---------------------------------------------------------
// show_form_modules
//---------------------------------------------------------
function _print_form_top()
{
	echo $this->build_form_begin('whatsnew_module');
	echo $this->build_token();
	echo $this->build_html_input_hidden('op',   'save');
	echo $this->build_html_input_hidden('mode', 'module');

	echo '<table class="outer" width="100%">'."\n";
	echo '</tr>'."\n";
	echo '<th align="center">' ._WHATSNEW_MID .'</th>'."\n";
	echo '<th align="center">' ._WHATSNEW_MNAME .'</th>'."\n";
	echo '<th align="center">'. _WHATSNEW_MDIR .'</th>'."\n";
	echo '<th align="center">'. _WHATSNEW_WEIGHT .'</th>'."\n";
	echo '<th align="center">'. _AM_WHATSNEW_PERM .'</th>'."\n";
	echo '<th align="center" colspan="2">'. _WHATSNEW_NEW .'</th>'."\n";
	echo '<th align="center">'. _WHATSNEW_RSS .'</th>'."\n";
	echo '</tr>'."\n";
}

function _print_form_conf_icon($name)
{
	$this->_print_form_even_odd();
	echo '<td></td><td>';
	echo $this->build_conf_title_by_name($name);
	echo '</td><td></td><td></td><td align="center">#1</td><td></td><td align="right">';
	echo $this->_build_conf_icon_select_by_name($name);
	echo '</td><td></td></tr>'."\n";
}

function _build_conf_icon_select_by_name($name)
{
	$id    = $this->get_by_name($name, 'conf_id');
	$value = $this->get_by_name($name, 'value');
	$text  = $this->_make_mod_icon_img($value);
	$text .= $this->build_html_select($name, $value, $this->icon_array);
	$text .= $this->build_conf_hidden($id);
	return $text;
}

function _print_form_bottom()
{
	echo '<tr class="foot"><td></td><td></td><td colspan="6">';
	echo $this->build_form_submit( 'submit', _HAPPY_LINUX_UPDATE );
	echo "</tr></table>\n";
	echo $this->build_form_end();
	echo "<br />\n";
}

function _print_form_even_odd()
{
	if ($this->_line_count % 2 == 0) {
		$class = 'even';
	} else {
		$class = 'odd';
	}

	$this->_line_count ++;

	echo '<tr class="'. $class .'">';
}

function _print_form_mod( $mid, &$system, $weight )
{
	$in_module   = $system['in_module'];
	$in_whatsnew = $system['in_whatsnew'];
	$in_version  = $system['in_version'];

	if ($in_module || $in_whatsnew || $in_version) 
	{
		$this->_print_form_mod_has_whatsnew( $mid, $system, $weight );
	}
	elseif ( $this->_flag_all_modules )
	{
		$this->_print_form_mod_not_whatsnew( $mid, $system, $weight );
	}
}

function _print_form_mod_not_whatsnew( $mid, &$system, $weight )
{
	$dirname      = $system['dirname'];
	$name         = $system['name'];
	$dirname_show = $this->sanitize_text($dirname);
	$name_show    = $this->sanitize_text($name);
	$weight_show  = $this->sanitize_text($weight);

	$this->_print_form_even_odd();
	echo '<td align="left">'.   $mid .'</td>';
	echo '<td align="left">'.   $name_show .'</td>';
	echo '<td align="left">'.   $dirname_show .'</td>';
	echo '<td align="center">'. $weight_show .'</td>';
	echo '<td></td><td></td><td></td>';
	echo "</tr>\n";
}

function _print_form_mod_has_whatsnew( $mid, &$system, $weight )
{
	$mod_ids         = $this->build_html_input_hidden('mod_ids[]', $mid);
	$dirname_show    = $this->sanitize_text(  $system['dirname'] );
	$perm_guest_show = $this->_make_mod_perm( $system['perm_guest'] );

	list( $name_show, $weight_show ) =
		$this->_build_form_mod_item( $mid, $system, $weight );

	list( $block_show, $block_icon_show, $rss_show, $permit_show ) =
		$this->_print_form_mod_block_rss( $mid, $system );

	$this->_print_form_even_odd();
	echo '<td align="left">'.   $mid.' '.$mod_ids .'</td>';
	echo '<td align="left">'.   $name_show .'</td>';
	echo '<td align="left">'.   $dirname_show .'</td>';
	echo '<td align="center">'. $weight_show .'</td>';
	echo '<td align="center">'. $permit_show .'</td>';
	echo '<td align="right">'.  $block_show .'</td>';
	echo '<td align="right">'.  $block_icon_show .'</td>';
	echo '<td align="right">'.  $rss_show .'</td>';
	echo "</tr>\n";
}

function _build_form_mod_item( $mid, &$system, $weight )
{
	$dirname     = $system['dirname'];
	$name        = $system['name'];
	$in_module   = $system['in_module'];
	$in_whatsnew = $system['in_whatsnew'];
	$in_version  = $system['in_version'];
	$flag_comment = false;

// XC2.1 legacy module exist
	if ( $this->_is_active_legacy_module )
	{
		if ($dirname == 'legacy')
		{	$flag_comment = true;	}
	}
// xoops 2.0 system module exist	
	else
	{
		if ($dirname == 'system')
		{	$flag_comment = true;	}
	}

// system comment
	if ( $flag_comment )
	{
		$name_show   = $this->build_conf_textbox_by_name('comment_name', 20);
		$weight_show = $this->build_conf_textbox_by_name('comment_weight');
	}
	else
	{
		$name_show   = $this->sanitize_text($name);
		$weight_show = $this->sanitize_text($weight);
	}

	return array( $name_show, $weight_show );
}

function _print_form_mod_block_rss( $mid, &$system )
{
	$dirname     = $system['dirname'];
	$block_show  = 0;
	$rss_show    = 0;
	$block_limit = $this->LIMIT_MODULE_DEFAULT;
	$rss_limit   = $this->LIMIT_MODULE_DEFAULT;
	$block_icon  = '';
	$plugin_file = '';
	$permit      = 0;
	$permit_show = '-';

	$module =& $this->_module_handler->get_by_mid( $mid );
	if ( is_object($module) )
	{
		$block_show  = $module->getVar('block_show');
		$block_limit = $module->getVar('block_limit');
		$rss_show    = $module->getVar('rss_show');
		$rss_limit   = $module->getVar('rss_limit');
		$block_icon  = $module->getVar('block_icon');
		$plugin_file = $module->getVar('plugin');
		$permit      = $module->getVar('permit');
	}

	$block_show_show  = $this->_make_mod_checkbox($mid, 'block_shows',  $block_show);
	$block_limit_show = $this->_make_mod_textbox( $mid, 'block_limits', $block_limit);
	$block_icon_show  = $this->_make_mod_icon($mid, $block_icon);
	$rss_show_show    = $this->_make_mod_checkbox($mid, 'rss_shows',  $rss_show);
	$rss_limit_show   = $this->_make_mod_textbox( $mid, 'rss_limits', $rss_limit);

	if ( $system['perm_guest'] ) {
		$permit_show = '-';
	} else{
		$permit_show = $this->_make_mod_checkbox($mid, 'permit', $permit);
	}

// plugin
	if ( empty($plugin_file) && !$this->check_multi_plugin($system) )
	{
		$plugins = $this->_build_block_handler->get_plugins($dirname);
		if ( isset($plugins[0]['file']) )
		{
			$plugin_file = $plugins[0]['file'];
		}
	}

	$plugin_name   = 'plugins['.$mid.']';
	$plugin_value  = $this->sanitize_text($plugin_file);
	$plugin_hidden = $this->build_html_input_hidden($plugin_name, $plugin_value);

	$block_show = $block_show_show.' '.$block_limit_show.' '.$plugin_hidden;
	$rss_show   = $rss_show_show.' '.$rss_limit_show;

	return array( $block_show, $block_icon_show, $rss_show, $permit_show );
}

function _make_mod_checkbox($mid, $name, $value)
{
	$name_show = $name."[".$mid."]";
	return $this->build_form_checkbox_yesno($name_show, $value);
}

function _make_mod_textbox($mid, $name, $value, $size=5)
{
	$name_show = $name."[".$mid."]";
	return $this->build_html_input_text($name_show, $value, $size);
}

function _make_mod_icon($mid, $block_icon)
{
	$text = '';
	$text .= $this->_make_mod_icon_img($block_icon)."\n";
	$text .= $this->_make_mod_icon_select($mid, $block_icon);
	return $text;
}

function _make_mod_icon_img($icon)
{
	$file_icon = $this->_DIR_ICON."/".$icon;
	$url_icon  = $this->_URL_ICON."/".$icon;

	if ( empty($icon) || !file_exists($file_icon) )  return '';

	return $this->build_html_img_tag($url_icon, 0, 0, 0, $icon);
}

function _make_mod_icon_select($mid, $value)
{
	$name_show = "block_icons[".$mid."]";
	return $this->build_html_select($name_show, $value, $this->icon_array, 1);
}

function _make_mod_perm($perm)
{
	if ($perm)
	{
		return "<b>#</b>";
	}
	return '';
}

//---------------------------------------------------------
// show_form_plugins
//---------------------------------------------------------
function _print_form_plugin( $mid, &$system )
{
	$dirname     = $system['dirname'];
	$name        = $system['name'];
	$version     = $system['version'];

	$name_show    = $this->sanitize_text($name);
	$dirname_show = $this->sanitize_text($dirname);
	$version_show = round($version / 100, 2);
	$plugin_show  = $this->_build_form_plugin_select($mid, $dirname);

	$mod_ids = $this->build_html_input_hidden('mod_ids[]', $mid);

	$this->_print_form_even_odd();
	echo '<td>'. $mid.' '.$mod_ids .'</td>';
	echo '<td>'. $name_show .'</td>';
	echo '<td>'. $dirname_show .'</td>';
	echo '<td>'. $version_show .'</td>'."\n";
	echo '<td>'. $plugin_show .'</td>';
	echo '</tr>'."\n";
}

function _build_form_plugin_select($mid, $dirname)
{
	$text   = '';

	$plugin_file = '';
	$block_show  = 0;
	$rss_show    = 0;
	$block_limit = $this->LIMIT_MODULE_DEFAULT;
	$rss_limit   = $this->LIMIT_MODULE_DEFAULT;
	$block_icon  = '';

	$module =& $this->_module_handler->get_by_mid( $mid );
	if ( is_object($module) )
	{
		$plugin_file = $module->getVar('plugin');
		$block_show  = $module->getVar('block_show');
		$block_limit = $module->getVar('block_limit');
		$rss_show    = $module->getVar('rss_show');
		$rss_limit   = $module->getVar('rss_limit');
		$block_icon  = $module->getVar('block_icon');
	}

	$bracket  = '['.$mid.']';
	$plugins  = $this->_build_block_handler->get_plugins($dirname);
	$flag_checked = false;

	foreach ($plugins as $plug)
	{
		$num   = $plug['num']; 
		$file  = $plug['file']; 
		$title = $plug['title']; 

		$checked    = $this->build_html_checked($plugin_file, $file);
		$file_show  = $this->sanitize_text($file);
		$title_show = $this->sanitize_text($title);
		$url        = 'view_plugin.php?dirname='. $dirname .'&amp;num='. $num;

		if ($checked)
		{
			$flag_checked = true;
		}

		$text .= $this->build_html_input_radio('plugins'.$bracket, $file_show, $checked);
		$text .= $title_show." \n";
		$text .= $this->build_html_a_href_name($url, '[view]', '_blank');
		$text .= "<br />\n";
	}

	if ( !$flag_checked )
	{
		$text .= '<span style="color:#ff0000">Not Select</span> <br />'."\n";
	}

	$text .= $this->build_html_input_hidden('block_shows'.$bracket,  $block_show);
	$text .= $this->build_html_input_hidden('block_limits'.$bracket, $block_limit);
	$text .= $this->build_html_input_hidden('rss_shows'.$bracket,    $rss_show);
	$text .= $this->build_html_input_hidden('rss_limits'.$bracket,   $rss_limit);
	$text .= $this->build_html_input_hidden('block_icons'.$bracket,  $block_icon);

	return $text;
}

//---------------------------------------------------------
// show_form_main_block
//---------------------------------------------------------
function _print_form_top_2()
{
	echo $this->build_form_begin('whatsnew_main_block');
	echo $this->build_token();
	echo $this->build_html_input_hidden('op', 'save');

	echo '<table class="outer" width="100%">'."\n";
	echo '<tr>';
	echo '<th align="center">'. _WHATSNEW_ITEM .'</th>';
	echo '<th align="center">'. _AM_WHATSNEW_MAIN .'</th>';
	echo '<th align="center">'. _WHATSNEW_NEW .'</th>';
	echo '<th align="center">'. _WHATSNEW_RSS .'</th>';
	echo '</tr>'."\n";
}

function _print_form_conf_three_2( $name1, $name2, $name3='', $size=5 )
{
	$name       = '';
	$name1_show = '';
	$name2_show = '';
	$name3_show = '';
	if ($name1) {
		$name = $name1;
	} elseif ($name2) {
		$name = $name2;
	} elseif ($name3) {
		$name = $name3;
	}
	if ($name1)
	{
		$name1_show = $this->build_conf_textbox_by_name($name1, $size);
	}
	if ($name2)
	{
		$name2_show = $this->build_conf_textbox_by_name($name2, $size);
	}
	if ($name3)
	{
		$name3_show = $this->build_conf_textbox_by_name($name3, $size);
	}
	$this->_print_conf_line_2($name, $name1_show, $name2_show, $name3_show);
}

function _print_form_conf_checkbox_2($name1, $name2)
{
	$name1_show = $this->build_conf_checkbox_by_name($name1);
	$name2_show = $this->build_conf_checkbox_by_name($name2);
	$this->_print_conf_line_2($name1, $name1_show, $name2_show);
}

function _print_conf_line_2($name, $name1_show, $name2_show, $name3_show='')
{
	$caption = $this->build_conf_caption_by_name($name);

	$this->_print_form_even_odd();
	echo '<td align="left">'. $caption .'</td>';
	echo '<td align="left">'. $name1_show .'</td>';
	echo '<td align="left">'. $name2_show .'</td>';
	echo '<td align="left">'. $name3_show .'</td>';
	echo "</tr>\n";
}

function _print_form_bottom_2()
{
	echo '<tr class="foot"><td></td><td colspan="3">';
	echo $this->build_form_submit( 'submit', _HAPPY_LINUX_UPDATE );
	echo "</tr></table>\n";
	echo $this->build_form_end();
	echo "<br />\n";
}

function print_msg($title)
{
	echo "<h4>". $title ."</h4>\n";
}

function print_error($title, $msg)
{
	echo '<h3 style="color:#ff0000">'. $title ."</h3>\n";
	echo $msg;
	echo "<br /><br />\n";
}

//---------------------------------------------------------
// icon
//---------------------------------------------------------
function get_icon_array()
{
	$this->icon_array =& $this->_system->get_img_list_as_array( $this->_DIR_ICON );
}

//---------------------------------------------------------
// view_plugin
//---------------------------------------------------------
function view_plugin($dirname, $num)
{
	$plugins = $this->_build_block_handler->get_plugins($dirname);

	if ( isset($plugins[$num]['file']) )
	{
		$file = $plugins[$num]['file'];
	}
	else
	{
		echo "no plugin file: $dirname";
		return false;
	}

	$file_plugin  = XOOPS_ROOT_PATH.'/'.$file;

	if ( file_exists($file_plugin) )
	{
		highlight_file($file_plugin);
	}
	else
	{
		echo "no plugin file: $file_plugin";
		return false;
	}

	return;
}

//---------------------------------------------------------
// show form rss cache clear
//---------------------------------------------------------
function show_form_rss_cache_clear( $title )
{
	$time = sprintf( "%.1f", ( $this->get_value_by_name('rss_cache_time')/3600 ) );
	$desc = sprintf( _HAPPY_LINUX_CONF_RSS_CACHE_CLEAR_TIME, $time );

	echo $this->build_lib_box_button_style( $title, $desc, 'rss_cache_clear', _HAPPY_LINUX_CLEAR );
	echo "<br />\n";
}

function show_form_template_compiled_clear( $title )
{
	$desc = sprintf( _HAPPY_LINUX_CONF_TPL_COMPILED_CLEAR_DIR, 'template/parts/ template/xml/' );
	echo $this->build_lib_box_button_style( $title, $desc, 'template_compiled_clear', _HAPPY_LINUX_CLEAR );
	echo "<br />\n";
}

// --- class end ---
}

//================================================================
// class admin_config_store
//================================================================
class admin_config_store extends happy_linux_error
{

// handler
	var $_config_store_handler;
	var $_module_store_handler;
	var $_install;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function admin_config_store()
{
	$this->happy_linux_error();

	$this->_config_store_handler =& whatsnew_get_handler('config_store', WHATSNEW_DIRNAME );
	$this->_module_store_handler =& whatsnew_get_handler('module_store', WHATSNEW_DIRNAME );
	$this->_install              =& whatsnew_install::getInstance(       WHATSNEW_DIRNAME );
}

function &getInstance()
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new admin_config_store();
	}
	return $instance;
}

//---------------------------------------------------------
// init config
//---------------------------------------------------------
function check_init()
{
	if ( !$this->_install->check_install() )
	{	return false;	}

	if ( !$this->_check_init_module() )
	{	return false;	}

	return true;
}

function init()
{
	$this->_clear_errors();

// BUG : add check_install
	if ( !$this->_install->check_install() )
	{
		$ret = $this->_install->install();
		if ( !$ret )
		{
// BUG : Fatal error: Call to a member function on a non-object
			$this->_set_errors( $this->_install->get_message() );
		}
	}

	if ( !$this->_check_init_module() )
	{
		$ret = $this->_module_store_handler->init();
		if ( !$ret )
		{
			$this->_set_errors( $this->_module_store_handler->getErrors() );
		}
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// upgrade config
//---------------------------------------------------------
function check_version()
{
	if ( !$this->_install->check_update() )
	{	return false;	}

	return true;
}

function upgrade()
{
	$this->_clear_errors();

	$ret = $this->_install->update();
	if ( !$ret )
	{
		$this->_set_errors( $this->_install->get_message() );
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// save config
//---------------------------------------------------------
function save()
{
	$ret = $this->_module_store_handler->save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_module_store_handler->getErrors() );
	}

	$ret = $this->_config_store_handler->save();
	if ( !$ret )
	{
		$this->_set_errors( $this->_config_store_handler->getErrors() );
	}

	if ( $this->_config_store_handler->check_post_form_catid( WHATSNEW_C_CATID_SITEINFO ) )
	{
		$ret = $this->_config_store_handler->save_siteinfo();
		if ( !$ret )
		{
			$this->_set_errors( $this->_config_store_handler->getErrors() );
		}
	}

	return true;
}

//---------------------------------------------------------
// check module
//---------------------------------------------------------
function _check_init_module()
{
	$num = $this->_module_store_handler->_handler->getCount();
// no record
	if ( $num == 0 )
	{
		$this->_module_store_handler->load_system_module();
		$flag_exist = $this->_module_store_handler->get_flag_exist();
// module exist
		if ($flag_exist)
		{
			return false;
		}
	}
	return true;
}

//---------------------------------------------------------
// rss cache clear
//---------------------------------------------------------
function rss_cache_clear()
{
	include_once WHATSNEW_ROOT_PATH.'/api/api_pda.php';

	$rss_builder =& whatsnew_rss_builder::getInstance( WHATSNEW_DIRNAME );
	$pda_builder =& whatsnew_pda_builder::getInstance( WHATSNEW_DIRNAME );

	$rss_builder->clear_all_guest_cache();
	$pda_builder->clear_all_guest_cache();
}

function template_compiled_clear()
{
	include_once XOOPS_ROOT_PATH.'/modules/happy_linux/api/module_install.php';
	include_once WHATSNEW_ROOT_PATH.'/class/whatsnew_install.php';

	$install =& whatsnew_install::getInstance( WHATSNEW_DIRNAME );
	$install->clear_all_template();

}

// --- class end ---
}

?>