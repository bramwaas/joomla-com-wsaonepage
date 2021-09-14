--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.0.11 added important Joomla fields like language and created. version not in line with https://docs.joomla.org/J3.x:Developing_an_MVC_Component any more, but in line with Component version
-- v 0.2.01 added some default fields from #__content and chend some existing field in accordance with #__content (has no effect on existing table)
-- v 0.7.9 attribs default '' until I know how to fill it from params.
-- v 0.7.10 metainfo default '' until I know how to fill it from params.
-- v0.8.6 drop defaults of datetime fields. 
-- v0.9.1 publish up and down NULL allowed.
-- v0.9.2 fields state = published and attribs removed `checked_out_time` NULL allowed
--
DROP TABLE IF EXISTS `#__wsaonepage`;


CREATE TABLE IF NOT EXISTS `#__wsaonepage` (
  	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  	`asset_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  	`title` varchar(255) NOT NULL DEFAULT '',
  	`alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
	`menutype` VARCHAR(25) NOT NULL,
	`description` VARCHAR(255) NOT NULL DEFAULT '',
	`catid` int(10) unsigned NOT NULL DEFAULT 0,
	`created` datetime NOT NULL,
	`created_by` int(10) unsigned NOT NULL DEFAULT 0,
	`created_by_alias` varchar(255) NOT NULL DEFAULT '',
  	`modified` datetime NOT NULL,
  	`modified_by` int(10) unsigned NOT NULL DEFAULT 0,
  	`checked_out` int(10) unsigned,
  	`checked_out_time` datetime,
  	`publish_up` datetime, 
  	`publish_down` datetime, 
  	`version` int(10) unsigned NOT NULL DEFAULT 1 COMMENT 'Number of revisions',
  	`ordering` int(11) NOT NULL DEFAULT 0,
  	`metakey` text NOT NULL DEFAULT '',
  	`metadesc` text NOT NULL DEFAULT '',
  	`access` int(10) unsigned NOT NULL DEFAULT 0,
  	`hits` int(10) unsigned NOT NULL DEFAULT 0,
  	`metadata` text NOT NULL DEFAULT '',
	`language`  CHAR(7)  NOT NULL DEFAULT '*',
  	`xreference` varchar(50) NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
	`published` tinyint(4) NOT NULL DEFAULT '1'  COMMENT 'State of the record in some other components state',
	`params`   VARCHAR(1024) NOT NULL DEFAULT '' COMMENT 'params for this component in some other components attribs',
	`image`   VARCHAR(1024) NOT NULL DEFAULT '', 
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
	ENGINE =InnoDB
	DEFAULT CHARSET =utf8mb4
	DEFAULT COLLATE=utf8mb4_unicode_ci;
      CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); -- use after alias is filled ok

