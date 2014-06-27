<?php

$extensionPath = t3lib_extMgm::extPath('pmkshadowbox');
return array(
	'tx_pmkshadowbox_cache' => $extensionPath . 'classes/class.tx_pmkshadowbox_cache.php',
	'tx_pmkshadowbox_build' => $extensionPath . 'classes/class.tx_pmkshadowbox_build.php',
	'tx_ttnews_imageMarker' => $extensionPath . 'classes/class.tx_ttnews_imageMarkerHook.php',
	'tx_ttnews_imageMarkerHook' => $extensionPath . 'classes/class.tx_ttnews_imageMarkerHook.php',
);

?>