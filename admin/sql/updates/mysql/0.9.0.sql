--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.9.0 drop defaults from datatime fields
--
ALTER TABLE `#__wsaonepage` ALTER `created` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` ALTER `modified` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` ALTER `checked_out_time` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` ALTER `publish_up` DROP DEFAULT;
ALTER TABLE `#__wsaonepage` ALTER `publish_down` DROP DEFAULT;




