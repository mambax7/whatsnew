<?php
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

//================================================================
// What's New Module
// get aritciles from module
// for Soapbox 1.5RC3 <http://dev.xoops.org/modules/xfmod/project/?soapbox>
// 2005-06-28 Ayou42 <http://ayou42.free.fr/>
//================================================================

function soapbox_new($limit=0, $offset=0)
{
    global $xoopsDB;

	$myts =& MyTextSanitizer::getInstance();

    $sql = "SELECT articleid, headline, datesub, counter, bodytext FROM " . $xoopsDB->prefix( 'sbarticles' ) . " ORDER BY datesub DESC";

// get twice records 
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
 	{
		$ret[$i]['link'] = XOOPS_URL."/modules/soapbox/article.php?articleID=".$row['articleid']."";
		$ret[$i]['title'] = $row['headline'];
		$ret[$i]['time']  = $row['datesub'];
// atom feed
		$ret[$i]['id'] = $row['articleid'];
		$ret[$i]['description'] = $myts->makeTareaData4Show( $row['bodytext'], 1 );

		$i++;
	}

	return $ret;
}

?>
