<?php
// $Id: admin.php,v 1.4 2005/11/16 14:06:49 ohwada Exp $
// 2005-10-01
// _WHATSNEW_CONFIG_BLOCK and more

// 2005-06-20
// _WHATSNEW_NEW_IMAGE_WIDTH

// 2005-06-14
// _WHATSNEW_MENU_RDF

// 2005-06-06
// _WHATSNEW_SYSTEM_COMMENT

//=========================================================
// What's New Module
// Language pack for English
// 2005-06-06 K.OHWADA
//=========================================================

// use $xoopsModule
//define("_WHATSNEW_NAME","Quoi de neuf ?");

// use blocks.php
//define("_WHATSNEW_ADMIN_DESC","Ce module collecte toutes les dernières informations depuis un ou plusieurs modules et les affiche dans un bloc et au format RSS et ATOM.");
//define("_WHATSNEW_MENU_CONFIG","Préférences");
//define("_WHATSNEW_MENU_PING","Envoi d'un ping de mise mise à jour");

define("_WHATSNEW_MENU_RSS","Rafra&icirc;chissement RSS");
define("_WHATSNEW_MENU_ATOM","Rafra&icirc;chissement ATOM");
define("_WHATSNEW_MENU_RDF","Rafra&icirc;chissement RDF");
define("_WHATSNEW_GOTO_WHATNEW","Aller au module");

// config
define("_WHATSNEW_MID","ID");
define("_WHATSNEW_MNAME","Nom du module");
define("_WHATSNEW_MDIR","Nom du r&eacute;pertoire");
define("_WHATSNEW_NEW","Bloc Quoi de neuf");
define("_WHATSNEW_RSS","RSS / ATOM");
define("_WHATSNEW_ITEM","El&eacute;ment");
define("_WHATSNEW_LIMIT_SHOW","Nombre d'articles");
define("_WHATSNEW_LIMIT_SUMMARY","Nombre de sommaires visibles");
define("_WHATSNEW_MAX_SUMMARY","Taille maximale des caract&egrave;res");
define("_WHATSNEW_NEW_IMAGE","Voir image");
define("_WHATSNEW_NEW_PING","Tester par envoi ping");

define("_WHATSNEW_SITE_NAME","Nom du site");
define("_WHATSNEW_SITE_NAME_DESC","Conditions requises pour RSS/ATOM");
define("_WHATSNEW_SITE_URL","URL du site");
define("_WHATSNEW_SITE_URL_DESC","Conditions requises pour RSS/ATOM");
define("_WHATSNEW_SITE_DESC","Description du site");
define("_WHATSNEW_SITE_DESC_DESC","Conditions requises pour RSS");
define("_WHATSNEW_SITE_AUTHOR","Webmaster");
define("_WHATSNEW_SITE_AUTHOR_DESC","Conditions requises pour ATOM");
define("_WHATSNEW_SITE_EMAIL","Email du Webmaster");
define("_WHATSNEW_SITE_EMAIL_DESC","Options pour RSS/ATOM");
define("_WHATSNEW_SITE_LOGO","Logo du site");
define("_WHATSNEW_SITE_LOGO_DESC","Options pour RSS");

define("_WHATSNEW_PING_SERVERS","Liste des serveurs de ping");
define("_WHATSNEW_PING_PASS","Mot de passe de update_ping.php");
define("_WHATSNEW_PING_LOG","Log des envois de Ping");

define("_WHATSNEW_SAVE","ENREGISTRER");
define("_WHATSNEW_DELETE","SUPPRIMER");
define("_WHATSNEW_CONFIG_SAVED","Enregistrer la configuration sur fichier");
define("_WHATSNEW_WARNING_NOT_WRITABLE","Impossible d'écrire le r&eacute;pertoire ou le fichier de configuration");

// not use config file
//define("_WHATSNEW_CONFIG_DELETED","Supprimer un fichier de configuration");
//define("_WHATSNEW_WARNING_NOT_EXIST","Le fichier de configuration n'existe pas");
//define("_WHATSNEW_ERROR_CONFIG","Erreur dans le fichier de configuration");
//define("_WHATSNEW_ERROR_SITE_NAME","pas de nom de site");
//define("_WHATSNEW_ERROR_SITE_URL","Pas d'adresse de site");
//define("_WHATSNEW_ERROR_SITE_DESC","Pas de description de site");
//define("_WHATSNEW_ERROR_SITE_AUTHOR","Pas de webmaster");
//define("_WHATSNEW_ERROR_NEW_MAX_SUMMARY","Nombre de caractères incorrect pour le résumé dans le bloc Quoi de neuf");
//define("_WHATSNEW_ERROR_RSS_MAX_SUMMARY","Nombre de caractères incorrect pour le résumé dans les flux RSS/ATOM");

// ping
define("_WHATSNEW_PING_DETAIL","Voir les informations d&eacute;taill&eacute;es");
define("_WHATSNEW_PING","ENVOYER un requ&ecirc;te Ping");
define("_WHATSNEW_PING_SENDED","Ping envoy&eacute;");

// 2005-06-06
define("_WHATSNEW_SYSTEM_COMMENT","Commentaires");
// 2005-06-20
define("_WHATSNEW_NEW_IMAGE_WIDTH","largeur maximale de l'image");
define("_WHATSNEW_NEW_IMAGE_HEIGHT","hauteur maximale de l'image");
define("_WHATSNEW_NEW_IMAGE_SIZE_NOT_SAVE","NE PAS sauvegarder la taille maximale de l'image");
define("_WHATSNEW_VIEW_RSS","Vue Debug du flux RSS");
define("_WHATSNEW_VIEW_RDF","Vue Debug du flux RDF");
define("_WHATSNEW_VIEW_ATOM","Vue Debug du flux ATOM");
define("_WHATSNEW_MENU_PDA","Rafra&icirc;chissement du template PDA");

// 2005-10-01
define("_WHATSNEW_SYSTEM_GROUPS","Gestion des Groupes");
define("_WHATSNEW_SYSTEM_BLOCKS","Gestion des Blocs");
define("_WHATSNEW_VIEW_DOCS","Manuel");
define("_WHATSNEW_CONFIG_BLOCK","Gestion des Blocs et configuration des flux RSS/ATOM");
define("_WHATSNEW_CONFIG_MAIN","Configuration de la Page Principale");
define("_WHATSNEW_CONFIG_SITE","Configuration des informations du site");
define("_WHATSNEW_CONFIG_PING","Configuration Ping ");
define("_WHATSNEW_GOTO_MENU_PING","Retour au Ping envoyé");

// index
define("_WHATSNEW_INIT_NOT","Ne pas initialiser la table de configuration");
define("_WHATSNEW_INIT_EXEC","Initialiser la table de configuration");
define("_WHATSNEW_VERSION_NOT","Version non %s");
define("_WHATSNEW_UPGRADE_EXEC","Mettre &agrave; jour la table de configuration");
define("_WHATSNEW_NOTICE","Attention");
define("_WHATSNEW_NOTICE_PERM","Les anonymes n'ont pas le droit de consulter le module WhatsNew<br />Personne ne peut lire les flux RSS ou ATOM");
define("_WHATSNEW_NOTICE_BOTH","Il y a des plugins &agrave; la fois dans le module et dans WhatsNew's<br />Le plugin du module est utilis&eacute; en priorit&eacute;.<br />Afficher le nom du r&eacute;pertoire en <font color='red'>ROUGE</font><br />Merci de supprimer le plus ancien<br />");
define("_WHATSNEW_NOTE_RSS_MARK","L'indication <b>#</b> dans la colonne RSS/ATOM signifit  :'les anonymes ont la permission de lire le module'<br />i.e. la personne ayant la permission de lire le module  pourra lire les flux RSS ou ATOM<br />");
define("_WHATSNEW_ICON_LIST","Liste d'Icones");

// config item
define("_WHATSNEW_WEIGHT","Poids");
define("_WHATSNEW_MIN_SHOW","Nombre minimum d'articles &agrave; montrer pour chaque module");
define("_WHATSNEW_BLOCK_ICON","Icone par d&eacute;faut");
define("_WHATSNEW_BLOCK_MODULE","Montrer l'ordre des modules");
define("_WHATSNEW_BLOCK_MODULE_0","Derniers");
define("_WHATSNEW_BLOCK_MODULE_1","Poids");
define("_WHATSNEW_BLOCK_SUMMARY_HTML","Autoriser l'HTML dans le r&eacute;sum&eacute;");
define("_WHATSNEW_BLOCK_MAX_TITLE","Nombre maximal de caract&egrave;res du titre");
define("_WHATSNEW_SITE_TAG","tag du Site");
define("_WHATSNEW_SITE_IMAGE_URL","URL du logo du site");
define("_WHATSNEW_SITE_IMAGE_WIDTH","Largeur du logo du site");
define("_WHATSNEW_SITE_IMAGE_HEIGHT","Hauteur du logo du site");
define("_WHATSNEW_MAIN_TPL","Template de la page principale");
define("_WHATSNEW_MAIN_TPL_0","à la 'WhatsNew'");
define("_WHATSNEW_MAIN_TPL_1","à la 'BopCommments'");


?>