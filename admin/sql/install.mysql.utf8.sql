--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.0.11 added important Joomla fields like language and created. version not in line with https://docs.joomla.org/J3.x:Developing_an_MVC_Component any more, but in line with Component version
--
DROP TABLE IF EXISTS `#__wsaonepage`;


CREATE TABLE `#__wsaonepage` (
	`id`       INT(10)     NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10)     NOT NULL DEFAULT '0',
	`created`  DATETIME    NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by`  INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`title` VARCHAR(48) NOT NULL,
	`alias`  VARCHAR(40)  NOT NULL DEFAULT '',
	`language`  CHAR(7)  NOT NULL DEFAULT '*',
	`menutype` VARCHAR(25) NOT NULL,
	`description` VARCHAR(255) ,
	`published` tinyint(4) NOT NULL DEFAULT '1',
	`catid`	    int(11)    NOT NULL DEFAULT '0',
	`params`   VARCHAR(1024) NOT NULL DEFAULT '',
	`image`   VARCHAR(1024) NOT NULL DEFAULT '',
	PRIMARY KEY (`id`)
)
	ENGINE =MyISAM
--	ENGINE =InnoDB
	AUTO_INCREMENT =0
--	DEFAULT CHARSET =utf8;
	DEFAULT CHARSET =utf8mb4;

--      CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); -- use after alias is filled ok

