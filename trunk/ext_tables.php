<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox/', 'Shadowbox - Base');
t3lib_extMgm::addStaticFile(
	'pmkshadowbox', 'static/PMK_Shadowbox_ClickEnlarge/', 'Shadowbox - tt_content (Click Enlarge)'
);
t3lib_extMgm::addStaticFile(
	'pmkshadowbox', 'static/PMK_Shadowbox_CloudZoom/', 'Shadowbox - tt_content (Cloud Zoom)'
);
t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox_tt_news/', 'Shadowbox - tt_news');
t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox_tt_products/', 'Shadowbox - tt_products');

$shadowboxExtConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['pmkshadowbox']);
if ((int) $shadowboxExtConf['enableCloudZoom'] >= 1) {
	t3lib_extMgm::addTCAcolumns(
		'tt_content', array(
			'pmkshadowbox_use_cloud_zoom' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pmkshadowbox/locallang_db.xml:pmkshadowbox_use_cloud_zoom',
				'config' => array(
					'type' => 'check',
					'default' => 0
				),
			),
		)
	);

	t3lib_extMgm::addToAllTCAtypes('tt_content', 'pmkshadowbox_use_cloud_zoom', '', 'after:image_zoom');
}
?>
