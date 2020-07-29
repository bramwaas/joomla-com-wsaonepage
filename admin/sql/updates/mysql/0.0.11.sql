--
-- This file will contain Table structure for `"__wsaonepage`
--

ALTER TABLE `#__wsaonepage` ADD `catid` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `#__wsaonepage` ADD `params` VARCHAR(1024) NOT NULL DEFAULT '';
ALTER TABLE `#__wsaonepage` ADD COLUMN `asset_id` INT(10)     NOT NULL DEFAULT '0' AFTER `id`;
ALTER TABLE `#__wsaonepage` ADD COLUMN `created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `asset_id`;
ALTER TABLE `#__wsaonepage` ADD COLUMN `created_by` INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER `created`;
ALTER TABLE `#__wsaonepage` ADD `image` VARCHAR(1024) NOT NULL DEFAULT '';
ALTER TABLE `#__wsaonepage` ADD COLUMN `alias` VARCHAR(40) NOT NULL DEFAULT '' AFTER `title`;
ALTER TABLE `#__wsaonepage` ADD COLUMN `language` CHAR(7) NOT NULL DEFAULT '*' AFTER `alias`;

UPDATE `#__wsaonepage` AS h1
SET alias = (SELECT CONCAT('id-', ID) FROM (SELECT * FROM `#__wsaonepage`) AS h2 WHERE h1.id = h2.id);

--  DROP INDEX `aliasindex` on `#__wsaonepage`;   -- does not exist before this version
-- CREATE UNIQUE INDEX `aliasindex` ON `#__wsaonepage` (`alias`, `catid`); -- use after alias is filled ok

