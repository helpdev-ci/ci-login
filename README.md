# ci-login
### Create Table
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
