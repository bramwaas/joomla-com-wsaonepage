--
-- This file will contain Table structure for `"__wsaonepage`
-- v 0.9.3 
--
-- info for com_contenthistory 
--
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`) 
VALUES
(null, 
'Wsaonepage', 
'com_wsaonepage.wsaonepage', 
'{"special":{"dbtable":"#__wsaonepage","key":"id","type":"Wsaonepage","prefix":"WsaonepageTable"}}', 
'', '', '',
'{"formFile":"administrator\\/components\\/com_wsaonepage\\/models\\/forms\\/wsaonepage.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ]}'
);