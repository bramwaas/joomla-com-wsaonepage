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
ALTER TABLE `#__wsaonepage` ADD COLUMN `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `created`;
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
--ALTER TABLE `#__wsaonepage` ADD COLUMN `image` VARCHAR(1024) NOT NULL DEFAULT '';
ALTER TABLE `#__wsaonepage` ADD KEY `idx_access` (`access`),
  	ADD KEY `idx_checkout` (`checked_out`),

  	ADD KEY `idx_state` (`state`),

  	ADD KEY `idx_catid` (`catid`),

  	ADD KEY `idx_createdby` (`created_by`),

  	ADD KEY `idx_language` (`language`),

  	ADD KEY `idx_xreference` (`xreference`),

  	ADD KEY `idx_alias` (`alias`(191))
;

UPDATE `#__wsaonepage` AS h1
SET alias = (SELECT CONCAT('id-', ID) FROM (SELECT * FROM `#__wsaonepage`) AS h2 WHERE h1.id = h2.id);

--  DROP INDEX `aliasindex` on `#__wsaonepage`;   -- does not exist before this version
-- CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); -- use after alias is filled ok

