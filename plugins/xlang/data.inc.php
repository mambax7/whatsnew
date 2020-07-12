<?php
// $Id: data.inc.php,v 1.1 2007/12/20 12:53:32 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// Xlang 0.10 <http://linux2.ohwada.net/>
// 2007-12-01 K.OHWADA
//================================================================

function xlang_new( $limit=0, $offset=0 )
{
	global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

	$MOD_URL = XOOPS_URL.'/modules/xlang';

	$table_file   = $xoopsDB->prefix( 'xlang_file' );
	$table_mail   = $xoopsDB->prefix( 'xlang_mail' );
	$table_word   = $xoopsDB->prefix( 'xlang_word' );
	$table_group  = $xoopsDB->prefix( 'xlang_group' );

	$i   = 1;
	$ret = array();
	$arr = array();

// latest file
	$sql1  = "SELECT h.*, g.dirname, g.language, g.file, g.word, g.mail, g.kind ";
	$sql1 .= "FROM $table_file h, $table_group g ";
	$sql1 .= "WHERE h.gid=g.id ";
	$sql1 .= "ORDER BY h.time DESC, h.id DESC";

// latest mail
	$sql2  = "SELECT h.*, g.dirname, g.language, g.file, g.word, g.mail, g.kind ";
	$sql2 .= "FROM $table_mail h, $table_group g ";
	$sql2 .= "WHERE h.gid=g.id ";
	$sql2 .= "ORDER BY h.time DESC, h.id DESC";

// latest word group by file
	$sql3  = "SELECT g.dirname, g.language, g.file ";
	$sql3 .= "FROM $table_word h, $table_group g ";
	$sql3 .= "WHERE h.gid=g.id ";
	$sql3 .= "GROUP BY g.dirname, g.language, g.file ";
	$sql3 .= "ORDER BY h.time DESC, h.id DESC";

// latest word in file
	$sql4  = "SELECT h.*, g.dirname, g.language, g.file, g.word, g.mail, g.kind ";
	$sql4 .= "FROM $table_word h, $table_group g ";
	$sql4 .= "WHERE h.gid=g.id ";
	$sql4 .= "AND g.dirname = %s ";
	$sql4 .= "AND g.language = %s ";
	$sql4 .= "AND g.file = %s ";	
	$sql4 .= "ORDER BY h.time DESC, h.id DESC ";

	$res1 = $xoopsDB->query( $sql1, $limit, $offset );
	while( $row1 = $xoopsDB->fetchArray($res1) )
	{
		$dirname  = $row1['dirname'];
		$language = $row1['language'];
		$file     = $row1['file'];
		$time     = $row1['time'];
		$desc     = $dirname .' > '. $language .' > '. $file .'<br />';
		$desc    .= $row1['f_content'];
		$path     = 'dirname='. $dirname .'&language='. $language;

		$line = array(
			'link'        => $MOD_URL.'/edit.php?'. $path .'&file='.$file,
			'cat_link'    => $MOD_URL.'/index.php?'. $path,
			'title'       => $file,
			'cat_name'    => $dirname,
			'time'        => $time,
			'description' => $desc,
		);

		$arr[ $time ] = $line;
	}

	$res2 = $xoopsDB->query( $sql2, $limit, $offset );
	while( $row2 = $xoopsDB->fetchArray($res2) )
	{
		$dirname  = $row2['dirname'];
		$language = $row2['language'];
		$mail     = $row2['mail'];
		$time     = $row2['time'];
		$desc     = $dirname .' > '. $language .' > '. $mail .'<br />';
		$desc    .= $row2['m_content'];
		$path     = 'dirname='. $dirname .'&language='. $language;

		$line  = array(
			'link'        => $MOD_URL.'/mail.php?'. $path .'&mail='.$mail,
			'cat_link'    => $MOD_URL.'/index.php?'. $path,
			'title'       => $mail,
			'cat_name'    => $dirname,
			'time'        => $time,
			'description' => $desc,
		);

		$arr[ $time ] = $line;
	}


	$res3 = $xoopsDB->query( $sql3, $limit, $offset );
	while( $row3 = $xoopsDB->fetchArray($res3) )
	{
		$dirname  = $row3['dirname'];
		$language = $row3['language'];
		$file     = $row3['file'];

		$sql4_1 = sprintf( $sql4, $xoopsDB->quoteString( $dirname ), 
			$xoopsDB->quoteString( $language ), $xoopsDB->quoteString( $file ) );
		$res4 = $xoopsDB->query( $sql4_1, 1 );
		$row4 = $xoopsDB->fetchArray($res4);

		$word  = $row4['word'];
		$time  = $row4['time'];
		$desc  = $dirname .' > '. $language .' > '. $file .' > '. $word .'<br />';
		$desc .= $row4['w_content'];
		$path  = 'dirname='. $dirname .'&language='. $language;

		$line  = array(
			'link'        => $MOD_URL.'/edit.php?'. $path .'&file='. $file .'&word='. $word,
			'cat_link'    => $MOD_URL.'/index.php?'. $path,
			'title'       => $word,
			'cat_name'    => $dirname,
			'time'        => $time,
			'description' => $desc,
		);

		$arr[ $time ] = $line;
	}

	krsort( $arr, SORT_NUMERIC );

	foreach( $arr as $line )
	{
		$ret[] = $line;
		if ( $i >= $limit ) break;
		$i++;
	}

	return $ret;
}

?>