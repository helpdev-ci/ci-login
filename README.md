# ci-login
### Create Table
<pre>
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `login_username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `login_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
</pre>
<pre>
CREATE TABLE IF NOT EXISTS `users_ss` (
  `id` int(11) NOT NULL,
  `ss_uid` int(11) NOT NULL,
  `ss_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ss_access_time` datetime NOT NULL,
  `ss_key` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
</pre>
