--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.2.01 added some default fields from #__content
--

ALTER TABLE `#__wsaonepage` ADD COLUMN `state` tinyint(3) NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `created_by_alias` varchar(255) NOT NULL DEFAULT '';
ALTER TABLE `#__wsaonepage` ADD COLUMN `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `#__wsaonepage` ADD COLUMN `modified_by` int(10) unsigned NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `checked_out` int(10) unsigned NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `#__wsaonepage` ADD COLUMN `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `#__wsaonepage` ADD COLUMN `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `#__wsaonepage` ADD COLUMN `attribs` varchar(5120) NOT NULL DEFAULT '';
ALTER TABLE `#__wsaonepage` ADD COLUMN `version` int(10) unsigned NOT NULL DEFAULT 1;
ALTER TABLE `#__wsaonepage` ADD COLUMN `ordering` int(11) NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `metakey` text NOT NULL;
ALTER TABLE `#__wsaonepage` ADD COLUMN `metadesc` text NOT NULL;
ALTER TABLE `#__wsaonepage` ADD COLUMN `access` int(10) unsigned NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `hits` int(10) unsigned NOT NULL DEFAULT 0;
ALTER TABLE `#__wsaonepage` ADD COLUMN `metadata` text NOT NULL;
ALTER TABLE `#__wsaonepage` ADD COLUMN `xreference` varchar(50) NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.';
CREATE  INDEX `idx_access` ON `#__wsaonepage` (`access`);
CREATE  INDEX `idx_checkout` ON `#__wsaonepage` (`checked_out`);

CREATE  INDEX `idx_state` ON `#__wsaonepage` (`state`);

CREATE  INDEX `idx_catid` ON `#__wsaonepage` (`catid`);

CREATE  INDEX `idx_createdby` ON `#__wsaonepage` (`created_by`);

CREATE  INDEX `idx_language` ON `#__wsaonepage` (`language`);

CREATE  INDEX `idx_xreference` ON `#__wsaonepage` (`xreference`);

CREATE  INDEX `idx_alias` ON `#__wsaonepage` (`alias`(191))
;
CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); 


