<?php
// $Id: whatsnew_collect_plugins.php,v 1.4 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// build_measure_detail()
// _build_permit_items()

// 2007-10-10 K.OHWADA
// divid from whatsnew_show_block.php
// banner

//=========================================================
// What's New Module
// class show block
// 2004/08/20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_collect_plugins') ) 
{

//=========================================================
// class whatsnew_collect_plugins
//=========================================================
class whatsnew_collect_plugins
{
// class
	var $_config_handler;
	var $_module_handler;
	var $_system;
	var $_strings;
	var $_time;

// local variable
	var $_module_data;
	var $_config_data;
	var $_options = array();

	var $_system_module_array;
	var $_system_weight_array;
	var $_measure_array  = array();

	var $_module_work_array;
	var $_module_time_array;
	var $_article_all_array;
	var $_article_time_array;
	var $_article_time_flag_array;
	var $_time_latest;

	var $_is_japanese = false;

	var $_DIRNAME;
	var $_DIR_PLUGIN_REL;

	var $_PERM_CHECK_ARRAY = array(
		'mod_link', 'cat_link', 'link',
		'dirname', 'mod_name', 'mod_icon', 'cat_name', 'title',
		'time', 'uid', 'hits', 'replies',
		'description', 'image', 'banner_url',
		'content_url', 'thumbnail_url'
	);

	var $_permit_array = array();

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_collect_plugins( $dirname )
{
	$this->_DIRNAME        = $dirname;
	$this->_DIR_PLUGIN_REL = 'modules/'.$dirname.'/plugins';

	$this->_config_handler =& whatsnew_get_handler( 'config_basic', $dirname );
	$this->_module_handler =& whatsnew_get_handler( 'module_basic', $dirname );
	$this->_system         =& happy_linux_system::getInstance();
	$this->_strings        =& happy_linux_strings::getInstance();
	$this->_time           =& happy_linux_time::getInstance();

	$this->_is_japanese = $this->_system->is_japanese();
	$this->_strings->set_is_japanese( $this->_is_japanese );

	$this->_config_data =& $this->_config_handler->get_conf();
	$this->_module_data =& $this->_module_handler->get_cached_rows();
	
	$this->_init_permit();
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_collect_plugins( $dirname );
	}
	return $instance;
}

//=========================================================
// public
//=========================================================
//--------------------------------------------------------
// caller bin/update_ping.php
//--------------------------------------------------------
function get_time_latest_after_collect()
{
	$this->_init_option_rss();
	$this->_collect_sortby_date();
	return $this->get_time_latest();
}

// --------------------------------------------------------
// collect aritciles sortby time
// --------------------------------------------------------
function &collect_rss()
{
	$this->_init_option_rss();
	return $this->collect_permit_date();
}

function &collect_permit_date()
{
	return $this->_build_permit_items( $this->_collect_sortby_date() );
}

function &_collect_sortby_date()
{
	$max_show = $this->_get_option('max_show');
	$min_show = $this->_get_option('min_show');

// collect from all module
	$module_work_array =& $this->_collect_all_modules();

// mark time flag
	$i = 0;
	foreach ($this->_article_time_array as $num => $time)
	{
		$this->_article_time_flag_array[$num] = 1;
		$time_older = $time;

		$i ++;
		if ($i >= $max_show) break;
	}

	$icon_list = array();

// walk through in module array
	if ($min_show > 0)
	{
		foreach ($module_work_array as $mid => $module)
		{
// mark time flag, if less than min show
			$j = 0;
			foreach ($module['article_arr'] as $article) 
			{
				$num = $article['serial_num'];
				$this->_article_time_flag_array[$num] = 1;
				$j ++;

				if ($j >= $min_show)  break;
			}
		}
	}

	$i = 0;
	$article_array = array();

// sort by time
	foreach ($this->_article_time_array as $num => $time)
	{
		if ( $this->_article_time_flag_array[$num] )
		{
			$article_array[$i++] = $this->_article_all_array[$num];
		}
	}

	if ( isset($article_array[0]['time']) )
	{
		$this->_time_latest = $article_array[0]['time'];
	}
// no article
	else
	{
		$this->_time_latest = 0;
	}

	return $article_array;
}

function get_time_latest()
{
	return $this->_time_latest;
}

// --------------------------------------------------------
// collect from all modules
// caller show main class
// --------------------------------------------------------
function &collect_permit_main_module_array()
{
	return $this->_build_permit_module_array( $this->_collect_all_modules() );
}

function &_collect_all_modules()
{
	$module_show  = $this->_get_option('module_show');
	$module_limit = $this->_get_option('module_limit');
	$perm_module  = $this->_get_conf('perm_module');

// system module config
	$this->load_system_module();

	$mod_work_arr = array();
	$mod_time_arr = array();

	$serial = 0;	// all article
	$art_all_arr  = array();
	$art_time_arr = array();
	$art_time_flag_arr = array();

	foreach ( $this->_module_data as $mid => $module) 
	{
		$time_begin   = $this->_time->get_microtime();
		$memory_begin = happy_linux_memory_get_usage();

// BUG: Undefined offset
		if ( !isset($this->_system_module_array[$mid]) )
		{	continue;	} 

		$system = $this->_system_module_array[$mid];

		$mid     = $module['mid'];
		$dirname = $module['dirname'];
		$show    = $module[ $module_show ];
		$limit   = $module[ $module_limit ];
		$icon    = $module['block_icon'];
		$plugin  = $module['plugin'];
		$permit  = $module['permit'];

		$sys_dirname  = $system['dirname'];
		$sys_name     = $system['name'];
		$sys_perm     = $system['perm'];

// if not show or unlimited
		if ($show  != 1)  continue;
		if ($limit == 0)  continue;
		if ( !( $perm_module && $permit ) && !$sys_perm )  continue;

// article array from one module
		$art_arr = $this->_collect_one_module($dirname, $plugin, $limit);

		$this->_measure_array[ $dirname ] = array(
			'time'   => $this->_time->get_microtime()  - $time_begin,
			'memory' => happy_linux_memory_get_usage() - $memory_begin,
		);

		if ( !is_array($art_arr) || (count($art_arr) == 0))
		{	continue;	} 

		$time = $art_arr[0]['time'];

		$mod_arr = array();
		$mod_arr['mod']['mid']      = $mid;
		$mod_arr['mod']['dirname']  = $sys_dirname;
		$mod_arr['mod']['mod_name'] = $sys_name;
		$mod_arr['mod']['mod_icon'] = $icon;
		$mod_arr['mod']['time']     = $time;
		$mod_arr['mod']['permit']   = $sys_perm;

		$j = 0;	// article
		foreach ($art_arr as $article) 
		{
			$art_temp               = $article;
			$art_temp['mod_id']     = $mid;
			$art_temp['mod_name']   = $sys_name;
			$art_temp['mod_icon']   = $icon;
			$art_temp['dirname']    = $sys_dirname;
			$art_temp['serial_num'] = $serial;
			$art_temp['permit']     = $sys_perm;

			$mod_arr['article_arr'][$j] = $art_temp;

			$art_all_arr[$serial]  = $art_temp;
			$art_time_arr[$serial] = $art_temp['time'];
			$art_time_flag_arr[$serial] = 0;

			$j ++;
			$serial ++;
		}

		$mod_work_arr[$mid] = $mod_arr;
		$mod_time_arr[$mid] = $time;

	}

// sort by time
	arsort($art_time_arr, SORT_NUMERIC);

	$this->_module_work_array       = $mod_work_arr;
	$this->_module_time_array       = $mod_time_arr;
	$this->_article_all_array       = $art_all_arr;
	$this->_article_time_array      = $art_time_arr;
	$this->_article_time_flag_array = $art_time_flag_arr;

	return $mod_work_arr;
}

function &get_module_work_array()
{
	return $this->_module_work_array;
}

// --------------------------------------------------------
// collect aritciles sortby time, group by module
// --------------------------------------------------------
function &collect_permit_block_module_array()
{
	return $this->_build_permit_module_array( $this->_collect_module() );
}

function &_collect_module()
{
	$article_time_array =& $this->_collect_sortby_date();

	if ( $this->_get_conf('block_module_order') )
	{
		$ret =& $this->_sortby_module( $article_time_array );
	}
	else
	{
		$ret =& $this->_sortby_module_time( $article_time_array );
	}
	return $ret;
}

//---------------------------------------------------------
// get_plugins
// caller admin_config_class
//---------------------------------------------------------
function &get_plugins( $mod_dirname )
{
	$file_module   = 'modules/'.$mod_dirname.'/include/data.inc.php';
	$file_whatsnew = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/data.inc.php';
	$file_version  = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/version.php';

	$file_full_module   = XOOPS_ROOT_PATH.'/'.$file_module;
	$file_full_whatsnew = XOOPS_ROOT_PATH.'/'.$file_whatsnew;
	$file_full_version  = XOOPS_ROOT_PATH.'/'.$file_version;

	$func = $mod_dirname.'_new_version';

	$num = 0;
	$plugins = array();

	if ( file_exists($file_full_module) )
	{
		$plugins[$num] = array(
			'num'   => $num, 
			'file'  => $file_module,
			'title' => 'in '.$mod_dirname,
		);
		$num ++;
	}

	if ( file_exists($file_full_version) )
	{
		include_once $file_full_version;

		if ( function_exists($func) )
		{
			$ver_list = $func();

			foreach ($ver_list as $ver)
			{
				$ver_version     = $ver['version'];
				$ver_file        = $ver['file'];
				$ver_description = $ver['description'];

				$file_ver      = $this->_DIR_PLUGIN_REL.'/'.$mod_dirname.'/'.$ver_file;
				$file_full_ver = XOOPS_ROOT_PATH.'/'.$file_ver;

				if ( file_exists($file_full_ver) )
				{
					if ($ver_description)
					{
						$title = $ver_description;
					}
					else
					{
						$title = $ver_version;
					}

					$plugins[$num] = array(
						'num'   => $num, 
						'file'  => $file_ver,
						'title' => $title,
					);
					$num ++;
				}
			}
		}
	}
	elseif ( file_exists($file_full_whatsnew) )
	{
		$plugins[$num] = array(
			'num'   => $num, 
			'file'  => $file_whatsnew,
			'title' => 'in whatsnew',
		);
		$num ++;
	}

	return $plugins;
}

//---------------------------------------------------------
// get system config
// caller show main class
//---------------------------------------------------------
// module & weight key as mid
function &load_system_module()
{
// get user permission
	$groups =& $this->_system->get_user_groups();

	$module_objs =& $this->_system->get_module_objects();
	$is_active_legacy_module = $this->_system->is_active_legacy_module();

	$system_arr = array();
	$weight_arr = array();

	foreach ( $module_objs as $module_obj ) 
	{
		$mid      = $module_obj->getVar('mid');
		$dirname  = $module_obj->getVar('dirname');
		$name     = $module_obj->getVar('name');
		$weight   = $module_obj->getVar('weight');
		$isactive = $module_obj->getVar('isactive');

		$flag_comment = false;

// not active
		if ( !$isactive ) continue;

// check user permission
		$perm = $this->_system->check_groupperm_right( 'module_read', $mid,  $groups );

// XC2.1 legacy module exist
		if ( $is_active_legacy_module )
		{
			if ($dirname == 'legacy')
			{
				$flag_comment = true;
			}
		}
// xoops 2.0 system module exist
		else
		{
			if ($dirname == 'system')
			{
				$flag_comment = true;
			}
		}

// system comment
		if ($flag_comment)
		{
			$name    = $this->_get_conf('comment_name');
			$weight  = $this->_get_conf('comment_weight');
			$dirname = '';
		}

		$system_arr[$mid]['dirname'] = $dirname;
		$system_arr[$mid]['name']    = $name;
		$system_arr[$mid]['weight'] =  $weight;
		$system_arr[$mid]['perm']    = $perm;

		$weight_arr[$mid] = $weight;
	}

//sort by weight
	asort($weight_arr, SORT_NUMERIC);

	$this->_system_module_array = $system_arr;
	$this->_system_weight_array = $weight_arr;

	return $system_arr;
}

function &get_system_weight_array()
{
	return $this->_system_weight_array;
}

function get_measure_detail()
{
	$text = '<table class="whatsnew_measure_detail">'."\n";
	$time_total   = 0;
	$memory_total = 0;
	foreach ( $this->_measure_array as $k => $v )
	{
		$time   = $v['time'];
		$memory = $v['memory'];
		$time_total   += $time;
		$memory_total += $memory;
		$text  .= '<tr><td>'. $this->_strings->sanitize_text($k) .'</td>';
		$text  .= '<td>'. sprintf("%6.3f", $time) .'</td>';
		$text  .= '<td>'. sprintf("%6.3f", $memory / 1000000 ) ."</td></tr>\n";
	}
	$text .= '<tr><td> total </td>';
	$text .= '<td>'. sprintf("%6.3f", $time_total) .' sec </td>';
	$text .= '<td>'. sprintf("%6.3f", $memory_total / 1000000 ) ." MB </td></tr>\n";
	$text .= "</table>\n";
	return $text;
}

//=========================================================
// private
//=========================================================
// --------------------------------------------------------
// collect from one modules
// --------------------------------------------------------
function &_collect_one_module($dirname, $plugin, $limit=0, $offset=0)
{
	$false = false;

// if unlimited
	if ($limit == 0)
	{	return $false;	}

// get plugin file
	$file = '';
	$func = $dirname."_new";

	if ($plugin)
	{
		$file = $plugin;
	}
	else
	{
		$plugins =& $this->get_plugins($dirname);

		if ( isset($plugins[0]['file']) )
		{
			$file = $plugins[0]['file'];
		}
	}

// if not exist plugin file
	if (!$file)
	{	return $false;	}

	if ( file_exists( XOOPS_ROOT_PATH.'/'.$file ) )
	{
// BUG: include plugin more than one time
		if ( !function_exists($func) )
		{
			include_once XOOPS_ROOT_PATH.'/'.$file;
		}
	}
	else
	{
		return $false;
	}

	if ( function_exists($func) )
	{
		$ret = $func($limit, $offset);
		return $ret;
	}

	return $false;
}

// --------------------------------------------------------
// sortby module
// --------------------------------------------------------
function &_sortby_module($article_time_array)
{
	$i = 0;
	$module_art_arr = array();

// walk through in module weight array
	foreach ( $this->_system_weight_array as $mid => $weight)
	{
		$temp_arr =& $this->_store_artcile_in_module($mid);

// store in array
		if ($temp_arr)
		{
			$module_art_arr[$i++] = $temp_arr;
		}
	}

	return $module_art_arr;
}

// --------------------------------------------------------
// store artcile in module
// --------------------------------------------------------
function &_store_artcile_in_module($mid)
{
	$false = false;

	if ( !isset($this->_module_work_array[$mid]) )
	{	return $false;	}

	$module_temp  = $this->_module_work_array[$mid];
	$module_arr   = array();
	$art_temp_arr = array();

	$j = 0;
	foreach ($module_temp['article_arr'] as $article) 
	{
// store in temp array, if time flag is ok
		$num = $article['serial_num'];
		if ( $this->_article_time_flag_array[$num] )
		{
			$art_temp_arr[$j] = $article;
			$j ++;
		}
	}

	if ( count($art_temp_arr) == 0 )
	{	return $false;	}

// store in array
	$module_arr['mod']         = $module_temp['mod'];
	$module_arr['article_arr'] = $art_temp_arr;

	return $module_arr;
}

// --------------------------------------------------------
// sortby time, group by module
// --------------------------------------------------------
function &_sortby_module_time($article_time_array)
{
	$time_array =& $this->_module_time_array;

// sort by time
	arsort($time_array, SORT_NUMERIC);

	$i = 0;
	$module_art_arr = array();

// walk through in module time array
	foreach ( $time_array as $mid => $time)
	{
		$temp_arr = $this->_store_artcile_in_module($mid);

// store in array
		if ($temp_arr)
		{
			$module_art_arr[$i++] = $temp_arr;
		}
	}

	return $module_art_arr;
}

//--------------------------------------------------------
// permission
//--------------------------------------------------------
function &_build_permit_module_array( &$module_arr )
{
	$arr = array();
	foreach ( $module_arr as $mid => $module )
	{
		$arr[ $mid ] = $this->_build_permit_module( $module );
	}
	return $arr;
}

function &_build_permit_module( &$module )
{
//echo " build_permit_module <br>\n";
//print_r($module);
	$permit  = $module['mod']['permit'];
	$mod_arr = array();
	foreach ( $module['mod'] as $k => $v )
	{
		if ( $this->_check_permit( $k, $permit ) ) {
			$mod_arr[ $k ] = $v;
		} else {
			$mod_arr[ $k ] = null;
		}
	}
	$arr = array(
		'mod'         => $mod_arr,
		'article_arr' => $this->_build_permit_items( $module['article_arr'] ),
	);
//print_r($arr);
	return $arr;
}

function &_build_permit_items( &$items )
{
	$arr = array();
	foreach ( $items as $item )
	{
		$arr[] = $this->_build_permit_single_item( $item );
	}
	return $arr;
}

function &_build_permit_single_item( &$item )
{
//echo " build_permit_single_item ";
//print_r($item);

	$permit = $item['permit'];
	$arr    = array();
	foreach ( $item as $k => $v )
	{
		if ( $this->_check_permit( $k, $permit ) ) {
			$arr[ $k ] = $v;
		} else {
			$arr[ $k ] = null;
		}
	}

//print_r($arr);
	return $arr;
}

function _check_permit( $k, $permit )
{
	if ( in_array( $k, $this->_PERM_CHECK_ARRAY ) )
	{
		return $this->_has_permit( $k, $permit );
	}
	else
	{
		return true;
	}
	return false;
}

function _has_permit( $k, $permit )
{
	if ( $permit || $this->_get_permit($k) )
	{
		return true;
	}
	return false;
}

function _init_permit()
{
	$arr = array();
	foreach( $this->_PERM_CHECK_ARRAY as $k )
	{
		$conf_key = 'perm_'.$k;
		$arr[ $k ] = $this->_get_conf($conf_key);
	}
	$perm_image = $this->_get_conf( 'perm_image' );
	$arr[ 'content_url'   ] = $perm_image;
	$arr[ 'thumbnail_url' ] = $perm_image;
	$this->_permit_array =& $arr;
}

function _get_permit($key)
{
	if( isset($this->_permit_array[$key]) )
	{
		return $this->_permit_array[$key];
	}
	return false;
}

//--------------------------------------------------------
// config
//--------------------------------------------------------
function &get_config_data()
{
	return $this->_config_data;
}

function _get_conf($key)
{
	if( isset($this->_config_data[$key]) )
	{
		return $this->_config_data[$key];
	}
	return false;
}

//--------------------------------------------------------
// options
//--------------------------------------------------------
function _get_option( $key )
{
	if ( isset($this->_options[$key]) )
	{
		return $this->_options[$key];
	}
	return null;
}

function _init_option_main()
{
	$this->_options = array(
		'max_show'      => $this->_get_conf('block_max_show'),
		'min_show'      => $this->_get_conf('block_min_show'),
		'limit_summary' => $this->_get_conf('main_limit_summary'),
		'max_title'     => $this->_get_conf('main_max_title'),
		'max_summary'   => $this->_get_conf('main_max_summary'),
		'summary_html'  => $this->_get_conf('main_summary_html'),
		'show_image'    => $this->_get_conf('main_image_flag'),
		'show_banner'   => $this->_get_conf('main_banner_flag'),
		'newday'        => $this->_get_conf('main_newday'),
		'today'         => $this->_get_conf('main_today'),
		'date_strings'  => $this->_get_conf('main_date_strings'),
		'module_show'   => 'block_show',
		'module_limit'  => 'block_limit',
	);
}

function _init_option_block()
{
	$this->_options = array(
		'max_show'      => $this->_get_conf('block_max_show'),
		'min_show'      => $this->_get_conf('block_min_show'),
		'limit_summary' => $this->_get_conf('block_limit_summary'),
		'max_title'     => $this->_get_conf('block_max_title'),
		'max_summary'   => $this->_get_conf('block_max_summary'),
		'summary_html'  => $this->_get_conf('block_summary_html'),
		'show_image'    => $this->_get_conf('block_image_flag'),
		'show_banner'   => $this->_get_conf('block_banner_flag'),
		'newday'        => $this->_get_conf('block_newday'),
		'today'         => $this->_get_conf('block_today'),
		'date_strings'  => $this->_get_conf('block_date_strings'),
		'module_show'   => 'block_show',
		'module_limit'  => 'block_limit',
	);
}

function _init_option_rss()
{
	$this->_options = array(
		'max_show'      => $this->_get_conf('rss_max_show'),
		'min_show'      => $this->_get_conf('rss_min_show'),
		'module_show'   => 'rss_show',
		'module_limit'  => 'rss_limit',
	);
}

// --- class end ---
}

// === class end ===
}

?>