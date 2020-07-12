<?php 
// $Id: data.inc.php,v 1.3 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-13 K.OHWADA
// description, category, counter

//================================================================
// What's New Module
// get aritciles from module
// for xwords 0.39 <http://www.kanpyo.net/>
// 2005-10-12 hide07 <http://www.hide07.jpn.org/>
//================================================================

function xwords_new($limit=0, $offset=0)
{
	global $xoopsDB;
	$myts = & MyTextSanitizer :: getInstance();

	$URL_MOD = XOOPS_URL."/modules/xwords";

	$sql = "SELECT e.entryID, e.term, e.datesub, e.definition, e.html, e.smiley, e.xcodes, e.breaks, e.uid, e.counter, e.categoryID, c.name FROM ". $xoopsDB->prefix( 'xwords_ent' ). " e, ". $xoopsDB->prefix( 'xwords_cat' ) ." c WHERE e.categoryID = c.categoryID AND datesub < ".time()." AND datesub > 0 AND submit = '0' AND offline = '0' ORDER BY e.entryID DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$i = 0;
	$ret = array();

 	while( $row = $xoopsDB->fetchArray($result) )
	{
		$id = $row['entryID'];
		$ret[$i]['link']     = $URL_MOD."/entry.php?entryID=".$id;
		$ret[$i]['cat_link'] = $URL_MOD."/category.php?categoryID=".$row['categoryID'];

		$ret[$i]['title']    = $row['term'];
		$ret[$i]['cat_name'] = $row['name'];

		$ret[$i]['time']  = $row['datesub'];
		$ret[$i]['uid']   = $row['uid'];
		$ret[$i]['hits']  = $row['counter'];
		$ret[$i]['id']    = $id;

		$html   = 0;
		$smiley = 0;
		$xcodes = 0;
		$image  = 1;
		$br     = 0;

		if ( $row['html'] )   $html   = 1;
		if ( $row['smiley'] ) $smiley = 1;
		if ( $row['xcodes'] ) $xcodes = 1;
		if ( $row['breaks'] ) $br     = 1;

		$ret[$i]['description'] = 
			$myts->displayTarea($row['definition'], $html, $smiley, $xcodes, $image, $br);

		$i++;
	}

	return $ret;
}
?>
