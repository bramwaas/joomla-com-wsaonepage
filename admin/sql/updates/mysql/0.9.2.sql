--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.9.2 DROP some not used fields, NULL constraint from `checked_out_time`
--
ALTER TABLE `#__wsaonepage` DROP COLUMN `attribs`;
ALTER TABLE `#__wsaonepage` DROP COLUMN `state`;
ALTER TABLE `#__wsaonepage` MODIFY `checked_out_time` datetime;
