<?php
// $Id: whatsnew_build_main.php,v 1.3 2007/12/02 02:48:04 ohwada Exp $

// 2007-12-01 K.OHWADA
// collect_permit_module_array()

// 2007-10-10 K.OHWADA
// divid form whatsnew_show_main.php

// 2007-05-12 K.OHWADA
// module dupulication
// remove measure_time_start()

// 2005-09-29 K.OHWADA
// change index.php & func.whatsnew.php to class

//=========================================================
// What's New Module
// 2004/08/20 K.OHWADA
//=========================================================

// === class begin ===
if( !class_exists('whatsnew_build_main') ) 
{

//=========================================================
// class whatsnew_build_main
//=========================================================
class whatsnew_build_main extends whatsnew_build_block_handler
{

//---------------------------------------------------------
// constructor
//---------------------------------------------------------
function whatsnew_build_main( $dirname )
{
	$this->whatsnew_build_block_handler( $dirname );
}

function &getInstance( $dirname )
{
	static $instance;
	if (!isset($instance)) 
	{
		$instance = new whatsnew_build_main( $dirname );
	}
	return $instance;
}

// --------------------------------------------------------
// public
// --------------------------------------------------------
function &build_main_modules()
{
	$this->_init_option_main();

// collect from all module
	$module_work_array = $this->collect_permit_main_module_array();

	$arr = array();
	foreach ( $this->get_system_weight_array() as $mid => $weight)
	{
		if ( !isset($module_work_array[$mid]) )  continue;

		$arr[] = $this->_make_block_module( $module_work_array[$mid] );
	}

	return $arr;
}

function &build_pda()
{
	$this->_init_option_main();
	$article_arr =& $this->collect_permit_date();

	$i   = 0;
	$arr = array();

	foreach ( $article_arr as $article )
	{
		$line = $this->_make_block_line($i, $article);

		if ( isset($article['pda']) && $article['pda'] )
		{
			$line['link'] = $article['pda'];
		}

		$arr[] = $line;
		$i ++;
	}

	return $arr;
}

// --- class end ---
}

// === class end ===
}

?>