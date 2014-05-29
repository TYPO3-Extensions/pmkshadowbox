<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

// post processing hook to clear any existing cache files if the clear cache button is used
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] =
	'EXT:pmkshadowbox/classes/class.tx_pmkshadowbox_cache.php:&tx_pmkshadowbox_cache->clearCachePostProc';

// Hook for adding "IMAGE_NUM_CURRENT" register value in tt_news
if (t3lib_extMgm::isLoaded('tt_news')) {
	$TYPO3_CONF_VARS['EXTCONF']['tt_news']['extraItemMarkerHook'][] =
		'EXT:pmkshadowbox/classes/class.tx_ttnews_imageMarkerHook.php:&tx_ttnews_imageMarker';
}

// Register Clear Cache Menu hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['additionalBackendItems']['cacheActions']['clearShadowboxBuilds'] =
	'EXT:pmkshadowbox/classes/class.tx_pmkshadowbox_clearcachemenu.php:&tx_pmkshadowbox_clearcachemenu';

// Register Ajax call
$TYPO3_CONF_VARS['BE']['AJAX']['pmkshadowbox::clearShadowboxBuilds'] =
	'EXT:pmkshadowbox/classes/class.tx_pmkshadowbox_cache.php:&tx_pmkshadowbox_cache->clear';

// Register eID script for saving and printing SB content.
$TYPO3_CONF_VARS['FE']['eID_include']['pmkshadowbox'] = 'EXT:pmkshadowbox/classes/class.tx_pmkshadowbox_printsave.php';

?>