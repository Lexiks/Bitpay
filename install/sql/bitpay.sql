CREATE TABLE `balance` (
  `id` int(11) NOT NULL auto_increment,
  `account` varchar(20) default NULL,
  `sum` double default '0',
  UNIQUE KEY `id` USING BTREE (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM AUTO_INCREMENT=0;
