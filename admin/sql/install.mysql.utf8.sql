--
-- This file will contain Table structure for `"__wsaonepage`
--
DROP TABLE IF EXISTS `#__wsaonepage`;


CREATE TABLE `#__wsaonepage` (
	`id`       INT(10)     NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(48) NOT NULL,
	`menutype` VARCHAR(25) NOT NULL,
	`description` VARCHAR(255) ,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
--	ENGINE =InnoDB
	AUTO_INCREMENT =0
--	DEFAULT CHARSET =utf8;
	DEFAULT CHARSET =utf8mb4;
