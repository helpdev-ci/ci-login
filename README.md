# ci-login
### Create Table
<pre>
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `common_name` varchar(128) NOT NULL,
  `department` varchar(128) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(62) NOT NULL COMMENT 'admin',
  `add_time` datetime NOT NULL,
  `flag` int(11) NOT NULL COMMENT '0=available, 1=suspended,2=deleted',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB;
</pre>
<pre>
INSERT INTO `users` VALUES (100, 'Super User', 'System admin', 'root', '21232f297a57a5a743894a0e4a801fc3', '2015-07-24 16:22:25', 0);
INSERT INTO `users` VALUES (101, 'Administrator', 'System Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2015-07-24 16:52:27', 0);
</pre>
<pre>
CREATE TABLE `user_grant` (
  `grant_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `policy_id` int(11) NOT NULL,
  PRIMARY KEY  (`grant_id`),
  UNIQUE KEY `user_id` (`user_id`,`policy_id`)
) ENGINE=MyISAM;
</pre>
<pre>
INSERT INTO `user_grant` VALUES (1, 101, 1);
INSERT INTO `user_grant` VALUES (2, 101, 2);
INSERT INTO `user_grant` VALUES (3, 102, 1);
INSERT INTO `user_grant` VALUES (4, 102, 2);
</pre>
<pre>
CREATE TABLE `user_policy` (
  `policy_id` int(11) NOT NULL auto_increment,
  `policy_name` varchar(20) NOT NULL,
  `creation_time` datetime NOT NULL,
  `edited_time` datetime NOT NULL,
  `flag` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`policy_id`),
  UNIQUE KEY `policy_name` (`policy_name`)
) ENGINE=MyISAM;
</pre>
<pre>
INSERT INTO `user_policy` VALUES (1, 'AdministratorAccess', '2015-07-24 16:45:51', '2015-07-24 16:45:51', 0);
INSERT INTO `user_policy` VALUES (2, 'WebAccess', '2015-07-24 16:45:51', '2015-07-24 16:45:51', 0);
INSERT INTO `user_policy` VALUES (3, 'MobileWebAccess', '2015-07-24 16:45:51', '2015-07-24 16:45:51', 0);
</pre>
<pre>
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL default '0',
  `ip_address` varchar(45) NOT NULL default '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM;
</pre>
<pre>
CREATE TABLE `login_sessions` (
  `login_id` int(11) NOT NULL auto_increment,
  `ip_address` varchar(45) NOT NULL default '0',
  `last_access` datetime NOT NULL,
  `uid` int(11) NOT NULL,
  `udata` text NOT NULL,
  PRIMARY KEY  (`login_id`)
) ENGINE=InnoDB;
</pre>
<pre>
CREATE TABLE `login` (
  `uid` int(11) NOT NULL auto_increment,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;
</pre>
