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
'{"special":{"dbtable":"#__wsaonepage","key":"id","type":"WsaonepageTable","prefix":"WaasdorpSoekhan\\Component\\Wsaonepage\\Administrator\\Table\\","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"Joomla\\CMS\\Table\\","config":"array()"}}', 
'',
'{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"description", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"null", "asset_id":"asset_id", "note":"null"}, "special":{"menutype":"menutype"}}',
'',
'{"formFile":"administrator\\/components\\/com_wsaonepage\\/forms\\/wsaonepage.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ]}'
);
