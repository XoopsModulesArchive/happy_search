# $Id: happy_search.sql,v 1.1 2007/07/04 11:07:48 ohwada Exp $

# 2007-07-01 K.OHWADA
# renewal happy_search_module

#=========================================================
# Happy Search
# 2006-11-11 K.OHWADA
#=========================================================

#
# Table structure for table `happy_search_config`
# modify from system `config`
#

CREATE TABLE happy_search_config (
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

#
# Table structure for table `happy_search_module`
# porting from suin's search `search`
#

# CREATE TABLE `happy_search_module` (
#  `mid` int(8) NOT NULL default '0',
#  `notshow` tinyint(1) NOT NULL default '0',
#  UNIQUE KEY `mid_2` (`mid`)
# ) TYPE=MyISAM;

CREATE TABLE `happy_search_module` (
  id smallint(5) unsigned NOT NULL auto_increment,
  mid int(8) NOT NULL default '0',
  first_notshow tinyint(1) NOT NULL default '0',
  second_show   tinyint(1) NOT NULL default '0',
  plugin_file  varchar(255) default '',
  plugin_func  varchar(255) default '',
  aux_int_1 int(5) default '0',
  aux_int_2 int(5) default '0',
  aux_text_1 varchar(255) default '',
  aux_text_2 varchar(255) default '',
  PRIMARY KEY (id),
  KEY mid (mid)
) TYPE=MyISAM;

#
# Table structure for table `happy_search_xoogle`
# not use
# for lower compatibility
#

CREATE TABLE `happy_search_xoogle` (
  `xoogleid` int(11) NOT NULL auto_increment,
  `google_key` varchar(255) default NULL,
  `google_lr` varchar(255) default NULL,
  `lrinblock` varchar(255) default NULL,
  `xoopsactive` varchar(255) default NULL,
  `sldefault` varchar(255) default NULL,
  `siteactive` varchar(255) default NULL,
  `webactive` varchar(255) default NULL,
  `slinblock` varchar(255) default NULL,
  `sitelabel` varchar(255) default NULL,
  `weblabel` varchar(255) default NULL,
  `xoopslabel` varchar(255) default NULL,
  UNIQUE KEY `xoogleid` (`xoogleid`)
) TYPE=MyISAM ;

