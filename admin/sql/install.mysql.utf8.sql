--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.0.11 added important Joomla fields like language and created. version not in line with https://docs.joomla.org/J3.x:Developing_an_MVC_Component any more, but in line with Component version
-- v 0.2.01 added some default fields from #__content and chend some existing field in accordance with #__content (has no effect on existing table)
--
DROP TABLE IF EXISTS `#__wsaonepage`;


CREATE TABLE IF NOT EXISTS `#__wsaonepage` (
  	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  	`asset_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',

  	`title` varchar(255) NOT NULL DEFAULT '',

  	`alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',

	`menutype` VARCHAR(25) NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
        `state` tinyint(3) NOT NULL DEFAULT 0,
	`catid` int(10) unsigned NOT NULL DEFAULT 0,

	`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

	`created_by` int(10) unsigned NOT NULL DEFAULT 0,

	`created_by_alias` varchar(255) NOT NULL DEFAULT '',

  	`modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  	`modified_by` int(10) unsigned NOT NULL DEFAULT 0,

  	`checked_out` int(10) unsigned NOT NULL DEFAULT 0,

  	`checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  	`publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  	`publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

  	`attribs` varchar(5120) NOT NULL,

  	`version` int(10) unsigned NOT NULL DEFAULT 1,

  	`ordering` int(11) NOT NULL DEFAULT 0,

  	`metakey` text NOT NULL,

  	`metadesc` text NOT NULL,

  	`access` int(10) unsigned NOT NULL DEFAULT 0,

  	`hits` int(10) unsigned NOT NULL DEFAULT 0,

  	`metadata` text NOT NULL,

	`language`  CHAR(7)  NOT NULL DEFAULT '*',
  	`xreference` varchar(50) NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',

	`published` tinyint(4) NOT NULL DEFAULT '1',  -- TODO nodig??
	`params`   VARCHAR(1024) NOT NULL DEFAULT '', -- TODO nodig??
	`image`   VARCHAR(1024) NOT NULL DEFAULT '', -- TODO nodig??
	PRIMARY KEY (`id`),
  	KEY `idx_access` (`access`),

  	KEY `idx_checkout` (`checked_out`),

  	KEY `idx_state` (`state`),

  	KEY `idx_catid` (`catid`),

  	KEY `idx_createdby` (`created_by`),

  	KEY `idx_language` (`language`),

  	KEY `idx_xreference` (`xreference`),

  	KEY `idx_alias` (`alias`(191))

)
--	ENGINE =MyISAM
	ENGINE =InnoDB
--	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8mb4
	DEFAULT COLLATE=utf8mb4_unicode_ci;

      CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); -- use after alias is filled ok

