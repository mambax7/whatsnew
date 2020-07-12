# $Id: whatsnew.sql,v 1.3 2007/12/15 22:48:46 ohwada Exp $

# 2007-12-16 K.OHWADA
# BUG : Duplicate column name 'permit'

# 2007-12-01 K.OHWADA
# permit in whatsnew_module

# 2007-05-12 K.OHWADA
# plugin in whatsnew_module
# conf_valuetype in whatsnew_config
# varchar(100) -> varchar(255)

# =========================================================
# SQL: create table
# 2005-10-01 K.OHWADA
# =========================================================

#
# Table structure for table `whatsnew_module`
#

CREATE TABLE whatsnew_module (
  id smallint(5) unsigned NOT NULL auto_increment,
  mid int(5) unsigned NOT NULL default '0',
  dirname varchar(255) NOT NULL default '',
  block_show  tinyint(2) unsigned NOT NULL default '0',
  block_limit int(5)     unsigned NOT NULL default '0',
  rss_show    tinyint(2) unsigned NOT NULL default '0',
  rss_limit   int(5)     unsigned NOT NULL default '0',
  block_icon varchar(255) default '',
  aux_int_1 int(5) default '0',
  aux_int_2 int(5) default '0',
  aux_text_1 varchar(255) default '',
  aux_text_2 varchar(255) default '',
  plugin     varchar(255) default '',
  permit tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY (id),
  KEY mid (mid)
) TYPE=MyISAM;

#
# Table structure for table `whatsnew_config`
# modify from system `config`
#

CREATE TABLE whatsnew_config (
  id      smallint(5) unsigned NOT NULL auto_increment,
  conf_id smallint(5) unsigned NOT NULL default 0,
  conf_name      varchar(255) NOT NULL default '',
  conf_valuetype varchar(255) NOT NULL default '',
  conf_value text NOT NULL,
  aux_int_1 int(5) default '0',
  aux_int_2 int(5) default '0',
  aux_text_1 varchar(255) default '',
  aux_text_2 varchar(255) default '',
  PRIMARY KEY (id),
  KEY conf_id (conf_id)
) TYPE=MyISAM;

