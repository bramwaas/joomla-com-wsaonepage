--
-- This file will remove Table structure for `#__wsaonepage`
--
DROP TABLE IF EXISTS `#__wsaonepage`;
--
--  0.9.3 delete content-history 
--
DELETE FROM `#__content_types` WHERE `type_alias` = 'com_wsaonepage.wsaonepage';
