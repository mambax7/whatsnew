<?php
// $Id: whatsnew_install.php,v 1.4 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// _check_config2_renew()
// _update_module_240()

// 2007-11-18 K.OHWADA
// _init_module()

//=========================================================
// What's New Module
// 2007-11-11 K.OHWADA
//=========================================================

if( ! class_exists('whatsnew_install') ) 
{

//=========================================================
// class whatsnew_install
//=========================================================
class whatsnew_install extends happy_linux_module_install
{
	var $_DIRNAME;

	var $_module_table;

	var $_LIMIT_MODULE_DEFAULT = 5;

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_install( $dirname )
{
	$this->_DIRNAME = $dirname;

	$this->happy_linux_module_install();
	$this->set_config_define_class( whatsnew_config_define::getInstance( $dirname ) );
	$this->set_config_table_name( $dirname.'_config' );

	$this->_module_table = $this->prefix( $dirname.'_module' );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_install( $dirname );
	}
	return $instance;
}

//---------------------------------------------------------
// public
//---------------------------------------------------------
function check_install()
{
	if ( !$this->check_init_config() )
	{	return false;	}

	if ( !$this->_check_init_module() )
	{	return false;	}

	return true;
}

function install()
{
	if ( !$this->check_init_config() )
	{
		$this->init_config();
		$this->set_msg( $this->get_init_config_msg() );
	}

	if ( !$this->_check_init_module() )
	{
		$this->_init_module();
		$this->set_msg( $this->build_init_msg( $this->_module_table ) );
	}

	return $this->return_flag_error();
}

function check_update()
{
	if ( !$this->_check_config_220() )
	{	return false;	}

	if ( !$this->_check_module_220() )
	{	return false;	}

	if ( !$this->_check_module_240() )
	{	return false;	}

	if ( !$this->_check_config2_renew() )
	{	return false;	}

	if ( !$this->check_update_config() )
	{	return false;	}

	return true;
}

function update()
{
	if ( !$this->_check_config_220() )
	{
		$this->clear_error();
		$this->_update_config_220();
		$this->truncate_table( $this->_config_table );
		$this->set_msg( $this->build_update_msg( $this->_config_table ) );
	}

	if ( !$this->_check_config2_renew() )
	{
		$this->truncate_table( $this->_config_table );
		$this->set_msg( $this->build_update_msg( $this->_config_table ) );
	}

	if ( !$this->_check_module_220() )
	{
		$this->clear_error();
		$this->_update_module_220();
		$this->truncate_table( $this->_module_table );
		$this->set_msg( $this->build_update_msg( $this->_module_table ) );
	}

	if ( !$this->_check_module_240() )
	{
		$this->clear_error();
		$this->_update_module_240();
		$this->set_msg( $this->build_update_msg( $this->_module_table ) );
	}

	if ( !$this->check_init_config() )
	{
		$this->init_config();
		$this->set_msg( $this->get_init_config_msg() );
	}

	if ( !$this->_check_init_module() )
	{
		$this->_init_module();
		$this->set_msg( $this->build_init_msg( $this->_module_table ) );
	}

	$this->update_config();
	$this->set_msg( $this->get_update_config_msg() );

	$this->clear_all_template();
	$this->set_msg( $this->build_tpl_msg() );

	return $this->return_flag_error();
}

//---------------------------------------------------------
// config table
//---------------------------------------------------------
function _check_config2_renew()
{
	$name_arr = array( 
		'icon_default'	// v2.30
	);
	return $this->exists_config_item_by_name_array( $name_arr );
}

function _check_config_220()
{
	return $this->exists_column( $this->_config_table, 'conf_valuetype' );
}

function _update_config_220()
{
$sql = "
  ALTER TABLE ". $this->_config_table ." ADD COLUMN (
  conf_valuetype varchar(255) NOT NULL default ''
)";

	return $this->query($sql);
}

//---------------------------------------------------------
// module table
//---------------------------------------------------------
function _init_module()
{
	$DIR_WHATSNEW_PLUGINS = XOOPS_ROOT_PATH.'/modules/'.$this->_DIRNAME.'/plugins';

	$xoops_module_objs = $this->get_xoops_module_objects_isactive();

	foreach ( $xoops_module_objs as $obj ) 
	{
		$mid     = $obj->getVar('mid',     'n');
		$dirname = $obj->getVar('dirname', 'n');

// plugin
		$file_modules  = XOOPS_ROOT_PATH.'/modules/'.$dirname.'/include/data.inc.php';
		$file_whatsnew = $DIR_WHATSNEW_PLUGINS.'/'.$dirname.'/data.inc.php';
		$file_version  = $DIR_WHATSNEW_PLUGINS.'/'.$dirname.'/version.php';

		if ( file_exists($file_modules)  || 
		     file_exists($file_whatsnew) || 
		     file_exists($file_version) )
		{
			$row = array(
				'mid'     => $mid,
				'dirname' => $dirname,
			);
			$this->_insert_module( $row );
		}
	}

}

function _insert_module( &$row )
{
	return $this->query( $this->_build_insert_module_sql( $row ) );
}

function _build_insert_module_sql( &$row )
{
	$block_show  = 0;
	$rss_show    = 0;
	$block_limit = $this->_LIMIT_MODULE_DEFAULT;
	$rss_limit   = $this->_LIMIT_MODULE_DEFAULT;
	$block_icon  = '';
	$plugin      = '';
	$permit      = 0;
	$aux_int_1   = 0;
	$aux_int_2   = 0;
	$aux_text_1  = '';
	$aux_text_2  = '';

	foreach ($row as $k => $v) 
	{	${$k} = $v;	}

	$sql  = 'INSERT INTO '.$this->_module_table.' (';
	$sql .= 'mid, ';
	$sql .= 'dirname, ';
	$sql .= 'block_show, ';
	$sql .= 'block_limit, ';
	$sql .= 'rss_show, ';
	$sql .= 'rss_limit, ';
	$sql .= 'block_icon, ';
	$sql .= 'plugin, ';
	$sql .= 'permit, ';
	$sql .= 'aux_int_1, ';
	$sql .= 'aux_int_2, ';
	$sql .= 'aux_text_1, ';
	$sql .= 'aux_text_2 ';
	$sql .= ') VALUES (';
	$sql .= intval($mid).', ';
	$sql .= $this->quote($dirname).', ';
	$sql .= intval($block_show).', ';
	$sql .= intval($block_limit).', ';
	$sql .= intval($rss_show).', ';
	$sql .= intval($rss_limit).', ';
	$sql .= $this->quote($block_icon).', ';
	$sql .= $this->quote($plugin).', ';
	$sql .= intval($permit).', ';
	$sql .= intval($aux_int_1).', ';
	$sql .= intval($aux_int_2).', ';
	$sql .= $this->quote($aux_text_1).', ';
	$sql .= $this->quote($aux_text_2).' ';
	$sql .= ')';

	return $sql;	
}

function _check_init_module()
{
	return $this->get_count_all( $this->_module_table );
}

function _check_module_220()
{
	return $this->exists_column( $this->_module_table, 'plugin' );
}

function _update_module_220()
{
$sql = "
  ALTER TABLE ". $this->_module_table ." ADD COLUMN (
  plugin varchar(255) default ''
)";
	return $this->query($sql);
}

function _check_module_240()
{
	return $this->exists_column( $this->_module_table, 'permit' );
}

function _update_module_240()
{
$sql = "
  ALTER TABLE ". $this->_module_table ." ADD COLUMN (
  permit tinyint(2) unsigned NOT NULL default '0'
)";
	return $this->query($sql);
}

//---------------------------------------------------------
// template
//---------------------------------------------------------
function clear_all_template()
{
	$dir_tpl = XOOPS_ROOT_PATH .'/modules/'. $this->_DIRNAME .'/templates';

	$this->clear_error();

	$this->clear_compiled_tpl_by_dir( $dir_tpl .'/parts' );
	$this->clear_compiled_tpl_by_dir( $dir_tpl .'/xml' );

	return $this->return_errors();
}

// --- class end ---
}

// === class end ===
}

?>