<?php
// $Id: manage_rss.php,v 1.9 2007/12/02 03:51:30 ohwada Exp $

// 2007-12-01 K.OHWADA
// WHATSNEW_C_CATID_SITEINFO

// 2007-11-01 K.OHWADA
// rebuild_pda.php
// print_footer()

// 2007-05-12 K.OHWADA
// module dupulication

//=========================================================
// What's New Module
// admin config
// 2005-10-01 K.OHWADA
//=========================================================

include_once 'admin_header_config.php';

// class
$config_form  =& admin_config_form::getInstance();
$config_store =& admin_config_store::getInstance();

$op = $config_form->get_post_get_op();

if ($op == 'save')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->save();
		redirect_header("manage_rss.php", 1, _HAPPY_LINUX_UPDATED);
	}
}
elseif ($op == 'rss_cache_clear')
{
	if( !$config_form->check_token() ) 
	{
		xoops_cp_header();
		$config_form->print_xoops_token_error();
	}
	else
	{
		$config_store->rss_cache_clear();
		redirect_header("manage_rss.php", 1, _HAPPY_LINUX_CLEARED );
	}
}

xoops_cp_header();
print_header();
print_menu();
echo "<h3>"._MI_WHATSNEW_ADMENU_RSS."</h3>\n";

print_admin_rss();

echo "<h4>"._WHATSNEW_CONFIG_SITE."</h4>\n";
echo _WHATSNEW_NOTICE_IMAGE_SIZE."<br />\n";
echo '<ul>';
echo '<li><a href="http://web.resource.org/rss/1.0/spec" target="_blank">RDF Site Summary (RSS) 1.0</a></li>';
echo '<li><a href="http://www.rssboard.org/rss-specification" target="_blank">RSS 2.0 Specification</a></li>';
echo '<li><a href="http://www.ietf.org/rfc/rfc4287" target="_blank">The Atom Syndication Format</a></li>';
echo '</ul>';
echo "<br />\n";
$config_form->set_form_title( _WHATSNEW_CONFIG_SITE );
$config_form->show_by_catid( WHATSNEW_C_CATID_SITEINFO );

echo "<h4>"._HAPPY_LINUX_CONF_RSS_CACHE_CLEAR."</h4>\n";
$config_form->show_form_rss_cache_clear( _HAPPY_LINUX_CONF_RSS_CACHE_CLEAR );

print_footer();
xoops_cp_footer();
exit();
// --- main end ---


function print_admin_rss()
{

?>
<ul>
<li><a href='rebuild_atom.php' target="_blank"><img src='../images/atom.png' alt="atom" /></a> 
<a href='rebuild_atom.php' target="_blank">(<?php echo _HAPPY_LINUX_CONF_SHOW_ATOM; ?>)</a></li>
<li><a href='view_atom.php' target="_blank"><?php echo _HAPPY_LINUX_CONF_DEBUG_ATOM; ?></a><br /></li>
<li><a href='discovery_atom.php'><?php echo _WHATSNEW_ATOM_AUTO; ?></a><br /><br /></li>

<li><a href='rebuild_rss.php' target="_blank"><img src='../images/rss.png' alt="rss" /></a> 
<a href='rebuild_rss.php' target="_blank">(<?php echo _HAPPY_LINUX_CONF_SHOW_RSS; ?>)</a></li>
<li><a href='view_rss.php' target="_blank"><?php echo _HAPPY_LINUX_CONF_DEBUG_RSS; ?></a><br /></li>
<li><a href='discovery_rss.php'><?php echo _WHATSNEW_RSS_AUTO; ?></a><br /><br /></li>

<li><a href='rebuild_rdf.php' target="_blank"><img src='../images/rdf.png' alt="rdf" /></a> 
<a href='rebuild_rdf.php' target="_blank">(<?php echo _HAPPY_LINUX_CONF_SHOW_RDF; ?>)</a></li>
<li><a href='view_rdf.php' target="_blank"><?php echo _HAPPY_LINUX_CONF_DEBUG_RDF; ?></a><br /></li>
<li><a href='discovery_rdf.php'><?php echo _WHATSNEW_RDF_AUTO; ?></a><br /><br /></li>
</ul>
<br />

<a href="http://feedvalidator.org/" target="_blank">FEED Validator</a>
 <?php echo _WHATSNEW_VALID; ?><br />
<br />
  <a href="http://feedvalidator.org/check.cgi?url=<?php echo WHATSNEW_URL; ?>/atom.php" target="_blank">
<img src="<?php echo WHATSNEW_URL; ?>/images/valid-atom.png" alt="[Valid Atom]" title="Validate my Atom feed" width="88" height="31" /></a>
  <a href="http://feedvalidator.org/check.cgi?url=<?php echo WHATSNEW_URL; ?>/rss.php" target="_blank">
<img src="<?php echo WHATSNEW_URL; ?>/images/valid-rss.png" alt="[Valid RSS]" title="Validate my RSS feed" width="88" height="31" /></a>
  <a href="http://feedvalidator.org/check.cgi?url=<?php echo WHATSNEW_URL; ?>/rdf.php" target="_blank">
<img src="<?php echo WHATSNEW_URL; ?>/images/valid-rss.png" alt="[Valid RDF]" title="Validate my RDF feed" width="70" height="25" /></a>
<br /><br />
<?php
}

?>