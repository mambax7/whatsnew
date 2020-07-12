<?php
// $Id: whatsnew_module_store_handler.php,v 1.3 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// compare_to_system()
// get_by_mid()
// permit field

// 2007-05-12 K.OHWADA
// module dupulication
// change filename from whatsnew_module_save
// WHATSNEW_FIELD_PLUGIN -> plugin

// 2006-06-25 K.OHWADA
// change load_system_module(), save()
// change name flag_both to flag_plural_plugins

//=========================================================
// What's New Module
// class module save
// 2005-10-01 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_module_store_handler') ) 
{

//================================================================
// class whatsnew_module_store_handler
//================================================================
class whatsnew_module_store_handler extends happy_linux_error
{
// constant
	var $LIMIT_MODULE_DEFAULT = 5;
	var $_DIRNAME;

// class
	var $_handler;
	var $_system;
	var $_post;

// variable
	var $_system_module_array;
	var $_system_weight_array;
	var $_flag_plural_plugins;

	var $_FLAG_NOT_EXISTS   = false;
	var $_FLAG_NOT_WHATSNEW = false;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_module_store_handler( $dirname )
{
	$this->_DIRNAME =  $dirname;
	$this->_handler =& whatsnew_get_handler( 'module',  $dirname );
	$this->_system  =& happy_linux_system::getInstance();
	$this->_post    =& happy_linux_post::getInstance();
}

//---------------------------------------------------------
// compare to system
//---------------------------------------------------------
function compare_to_system()
{
	$this->_clear_errors();

// system module config
	$system_arr = $this->load_system_module();

	foreach ($system_arr as $mid => $system) 
	{
		$dirname     = $system['dirname'];
		$in_module   = $system['in_module'];
		$in_whatsnew = $system['in_whatsnew'];
		$in_version  = $system['in_version'];

		$count1 = $this->_handler->get_count_by_key_value( 'mid', intval($mid) );
		$count2 = $this->_handler->get_count_by_key_value( 'dirname', $dirname );

		if ( $in_module || $in_whatsnew || $in_version )
		{
			if (( $count1 > 1 )||( $count2 > 1 )) 
			{
				$this->_set_errors( "$mid : $dirname : too many record" );
			}
			elseif ( $this->_FLAG_NOT_EXISTS ) 
			{
				if (( $count1 == 0 )||( $count2 == 0 ))
				{ 
					$this->_set_errors( "$mid : $dirname : no record" );
				}
			}
		}
		elseif( $this->_FLAG_NOT_WHATSNEW )
		{
			if (( $count1 > 0 )||( $count2 > 0 )) 
			{
				$this->_set_errors( "$mid : $dirname : record exists" );
			}
		}
	}

	return $this->returnExistError();
}

//---------------------------------------------------------
// save module
//---------------------------------------------------------
function save()
{
// system module config
	$system_arr = $this->load_system_module();

	$mid_ids         = $this->_post->get_post('mod_ids');
	$block_show_arr  = $this->_post->get_post('block_shows');
	$block_limit_arr = $this->_post->get_post('block_limits');
	$block_icon_arr  = $this->_post->get_post('block_icons');
	$rss_show_arr    = $this->_post->get_post('rss_shows');
	$rss_limit_arr   = $this->_post->get_post('rss_limits');
	$plugin_arr      = $this->_post->get_post('plugins');
	$permit_arr      = $this->_post->get_post('permit');
	$mode            = $this->_post->get_post('mode');

	$count = count($mid_ids);
	if (!is_array($mid_ids) || ($count <= 0))  return; 

// list from POST
	for ( $i=0; $i<$count; $i++ ) 
	{
		$mid = $mid_ids[$i];

		$system      = $system_arr[$mid];
		$dirname     = $system['dirname'];
		$in_module   = $system['in_module'];
		$in_whatsnew = $system['in_whatsnew'];
		$in_version  = $system['in_version'];

		if ( !$in_module && !$in_whatsnew && !$in_version)  continue;

		$obj =& $this->_handler->get_by_mid( $mid );

// create, when not in MySQL
		$flag_insert = 0;
		if ( !is_object($obj) )
		{
			$flag_insert = 1;
			$obj =& $this->_handler->create();
			$obj->setVar('mid', $mid );
		}

		$block_show  = $this->make_int($block_show_arr,  $mid);
		$block_limit = $this->make_int($block_limit_arr, $mid);
		$rss_show    = $this->make_int($rss_show_arr,    $mid);
		$rss_limit   = $this->make_int($rss_limit_arr,   $mid);
		$block_icon  = $this->make_text($block_icon_arr, $mid);
		$plugin      = $this->make_text($plugin_arr,     $mid);
		$permit      = $this->make_text($permit_arr,     $mid);

		$obj->setVar('plugin', $plugin );

		if ($mode == 'module')
		{
			$obj->setVar('block_show',  $block_show );
			$obj->setVar('block_limit', $block_limit );
			$obj->setVar('block_icon',  $block_icon );
			$obj->setVar('rss_show',    $rss_show );
			$obj->setVar('rss_limit',   $rss_limit );
			$obj->setVar('dirname',     $dirname );
			$obj->setVar('permit',      $permit );
		}

// insert, when not in MySQL
		if ( $flag_insert )
		{
			$this->_handler->insert($obj);
		}
// update
		else
		{
			$this->_handler->update($obj);
		}

		unset($obj);
	}

}

//---------------------------------------------------------
// system config
//---------------------------------------------------------
function load_system_module()
{
// user permission: guest
	$groups_guest = $this->_system->get_user_groups_anonymous();

	$module_objs =& $this->_system->get_module_objects();

	$system_arr  = array();
	$weight_arr  = array();
	$flag_exist  = false;
	$flag_plural = false;

	$DIR_WHATSNEW_PLUGINS = XOOPS_ROOT_PATH.'/modules/'.$this->_DIRNAME.'/plugins';

	foreach ( $module_objs as $module_obj ) 
	{
		$mid      = $module_obj->getVar('mid');
		$dirname  = $module_obj->getVar('dirname');
		$name     = $module_obj->getVar('name');
		$weight   = $module_obj->getVar('weight');
		$version  = $module_obj->getVar('version');
		$isactive = $module_obj->getVar('isactive');

// not active
		if ( !$isactive ) continue;

// check user permission
		$perm_guest = $this->_system->check_groupperm_right( 'module_read', $mid,  $groups_guest );

// plugin
		$file_modules  = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/include/data.inc.php';
		$file_whatsnew = $DIR_WHATSNEW_PLUGINS.'/'.$dirname.'/data.inc.php';
		$file_version  = $DIR_WHATSNEW_PLUGINS.'/'.$dirname.'/version.php';

		$in_module   = false;
		$in_whatsnew = false;
		$in_version  = false;
		if ( file_exists($file_modules) )   $in_module   = true;
		if ( file_exists($file_whatsnew) )  $in_whatsnew = true;
		if ( file_exists($file_version) )   $in_version  = true;
		if ( $in_module || $in_whatsnew )   $flag_exist  = true;
		if ( $in_module && $in_whatsnew )   $flag_plural = true;
		if ( $in_version )                  $flag_plural = true;

		$system_arr[$mid]['dirname']     = $dirname;
		$system_arr[$mid]['name']        = $name;
		$system_arr[$mid]['weight']      = $weight;
		$system_arr[$mid]['perm_guest']  = $perm_guest;
		$system_arr[$mid]['version']     = $version;
		$system_arr[$mid]['in_module']   = $in_module;
		$system_arr[$mid]['in_whatsnew'] = $in_whatsnew;
		$system_arr[$mid]['in_version']  = $in_version;

		$weight_arr[$mid] =  $weight;
	}

	$this->_system_module_array = $system_arr;
	$this->_system_weight_array = $weight_arr;
	$this->_flag_exist          = $flag_exist;
	$this->_flag_plural_plugins = $flag_plural;

	return $system_arr;
}

function get_system_module()
{
	return $this->_system_module_array;
}

function get_system_module_weight()
{
	return $this->_system_weight_array;
}

function get_flag_exist()
{
	return $this->_flag_exist;
}

function get_flag_plural_plugins()
{
	return $this->_flag_plural_plugins;
}

//---------------------------------------------------------
// get value for input
//---------------------------------------------------------
function make_text($arr, $key, $default='')
{
	if ( isset($arr[$key]) )
	{
		return trim($arr[$key]);
	}
	return trim($default);
}

function make_int($arr, $key, $default=0)
{
	if ( isset($arr[$key]) )
	{
		return intval($arr[$key]);
	}
	return intval($default);
}

// --- class end ---
}

// === class end ===
}

?>