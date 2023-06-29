DROP TABLE IF EXISTS `member_tb` ;//
CREATE TABLE IF NOT EXISTS `member_tb` (
`member_id` int(11) AUTO_INCREMENT, //
`member_email` varchar(255),// Email
`member_first_name` varchar(255),//
`member_last_name` varchar(255),
`member_sex` varchar(50),//
`member_years` int(11),//
`membership_id` int(11),//
`register_date` text,//
`login_date` text,//login 
PRIMARY KEY (`member_id`),
UNIQUE KEY (`member_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `membership_tb` ;//member ship 
CREATE TABLE IF NOT EXISTS `membership_tb` (
`membership_id` int(11) AUTO_INCREMENT,
`membership_name` varchar(255),
PRIMARY KEY (`membership_id`),
UNIQUE KEY (`membership_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `setting_tb` ;//
CREATE TABLE IF NOT EXISTS `setting_tb` (
`setting_id` int(11) AUTO_INCREMENT,
`membership_id` int(11) ,
`type_name` varchar(255),
`type_max_count` int(11),
PRIMARY KEY (`setting_id`),
UNIQUE KEY (`membership_id`,`type_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `content_tb` ;
CREATE TABLE IF NOT EXISTS `content_tb` (
`content_id` int(11) AUTO_INCREMENT,
`class_number` int(11) ,
`subject` varchar(255),
`title` text,
`category_number` int(11) ,
`section`  varchar(255),
PRIMARY KEY (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;