--
-- This file will contain Table structure changes for `#__wsaonepage`
-- Changes between 0.9.3 and 1.0.1.
-- v 1.0.1 DROP some NULL constraint 
--
ALTER TABLE `#__wsaonepage` MODIFY `publish_up` datetime NULL;
ALTER TABLE `#__wsaonepage` MODIFY `publish_down` datetime NULL;
ALTER TABLE `#__wsaonepage` MODIFY `checked_out_time` datetime NULL;
ALTER TABLE `#__wsaonepage` MODIFY `checked_out` int(10) unsigned NULL;
