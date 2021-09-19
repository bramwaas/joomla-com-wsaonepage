--
-- This file will contain Table structure for `"__wsaonepage`
-- Changes between 0.2.2 and 0.9.2 copied to this file.
-- v 0.9.2 DROP some not used fields, NULL constraint from `checked_out_time`
--
ALTER TABLE `#__wsaonepage` ALTER `metakey` SET DEFAULT '';
ALTER TABLE `#__wsaonepage` ALTER `metadesc` SET DEFAULT '';
ALTER TABLE `#__wsaonepage` ALTER `metadata` SET DEFAULT '';
ALTER TABLE `#__wsaonepage` ALTER `created` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` ALTER `modified` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` DROP COLUMN `attribs`;
ALTER TABLE `#__wsaonepage` DROP COLUMN `catid`;
ALTER TABLE `#__wsaonepage` DROP COLUMN `state`; -- also removes index
ALTER TABLE `#__wsaonepage` DROP COLUMN `xreference`;
ALTER TABLE `#__wsaonepage` MODIFY `publish_up` datetime;
ALTER TABLE `#__wsaonepage` MODIFY `publish_down` datetime;
ALTER TABLE `#__wsaonepage` MODIFY `checked_out_time` datetime;
ALTER TABLE `#__wsaonepage` MODIFY `checked_out` int(10) unsigned;
ALTER TABLE `#__wsaonepage` ADD INDEX `idx_published` (`published`);
ALTER TABLE `#__wsaonepage` DROP INDEX `idx_alias`;
ALTER TABLE `#__wsaonepage` ADD CONSTRAINT UNIQUE KEY `idx_alias` (`alias`(191));
