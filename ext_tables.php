<?php

if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox/', 'Shadowbox - Base');
t3lib_extMgm::addStaticFile(
	'pmkshadowbox', 'static/PMK_Shadowbox_ClickEnlarge/', 'Shadowbox - tt_content (Click Enlarge)'
);
t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox_tt_news/', 'Shadowbox - tt_news');
t3lib_extMgm::addStaticFile('pmkshadowbox', 'static/PMK_Shadowbox_tt_products/', 'Shadowbox - tt_products');

?>
