<?php
// $Id: main.php,v 1.4 2005/11/16 14:06:49 ohwada Exp $

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// index.php



// use $xoopsModule
//define("_WHATSNEW_NAME","Quoi de neuf");

define("_WHATSNEW_DESC","Ce module collecte toutes les derni&egrave;res informations depuis un ou plusieurs modules et les affiche dans un bloc et au format RSS et ATOM.");

define("_WHATSNEW_RSS_VALID","V&eacute;rification de validit&eacute; RSS/ATOM");
define("_WHATSNEW_VALID","V&eacute;rification de validit&eacute;");

define("_WHATSNEW_RSS_AUTO","Recherche automatique d'URL RSS");
define("_WHATSNEW_ATOM_AUTO","Recherche automatique d'URL ATOM");

// not use config file
//define("_WHATSNEW_WARNING_NOT_EXIST","Fichier de configuration inexistant");

// template rss
define('_WHATSNEW_LASTBUILD', 'Derni&egrave;re date de construction');
define('_WHATSNEW_LANGUAGE', 'Langue');
define('_WHATSNEW_DESCRIPTION', 'Site');
define('_WHATSNEW_WEBMASTER', 'Webmaster');
define('_WHATSNEW_CATEGORY', 'Categorie');
define('_WHATSNEW_GENERATOR', 'G&eacute;nerateur');
define('_WHATSNEW_TITLE', 'Titre');
define('_WHATSNEW_PUBDATE', 'Date publique');

// template atom
define('_WHATSNEW_ID', 'ID');
define('_WHATSNEW_MODIFIED', 'Date de modification');
define('_WHATSNEW_ISSUED',   'Date de publication');
define('_WHATSNEW_CREATED',  'Date de cr&eacute;ation');
define('_WHATSNEW_COPYRIGHT', 'Copyright');
define('_WHATSNEW_SUMMARY', 'Sommaire');
define('_WHATSNEW_CONTENT', 'Contenu');
define('_WHATSNEW_AUTHOR_NAME', 'Nom de l\'auteur');
define('_WHATSNEW_AUTHOR_URL',  'Url de l\'auteur');
define('_WHATSNEW_AUTHOR_EMAIL','Email de l\'auteur');

define('_WHATSNEW_AUTO', 'Recherche automatique');
define('_WHATSNEW_SET', 'R&eacute;gler');

define('_WHATSNEW_ERROR_CONNCET', 'Impossible de se connecter');
define('_WHATSNEW_ERROR_PARSE', 'Impossible d\'analyser');
define('_WHATSNEW_ERROR_RSS_AUTO', 'Impossible de d&eacute;tecter des flux RSS');
define('_WHATSNEW_ERROR_RSS_GET', 'Impossible d\'obtenir un flux RSS');
define('_WHATSNEW_ERROR_ATOM_AUTO', 'Impossible de d&eacute;tecter un flux ATOM');
define('_WHATSNEW_ERROR_ATOM_GET', 'Impossible d\'obtenir un flux ATOM');
// 2005-10-10
define('_WHATSNEW_MAIN_PAGE', 'Page Principale');
define('_WHATSNEW_RSS_PERM', 'Les utilisateurs enregistr&eacute;s ne peuvent pas lire les flux ATOM/RSS/RDF<br />Merci de vous d&eacute;connecter et de consulter ces flux en anonyme');

?>