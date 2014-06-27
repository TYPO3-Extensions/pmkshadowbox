<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010 Stefan Galinski <stefan.galinski@gmail.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

if (!t3lib_div::compat_version('6.2.0')) {
	require_once(PATH_typo3 . 'interfaces/interface.backend_cacheActionsHook.php');
}

/**
 * Extending class to render the menu for the cache clearing actions,
 * and adding Clear Shadowbox Builds option
 *
 * @author    Stefan Galinski <stefan.galinski@gmail.com>
 * @package    TYPO3
 * @subpackage pmkshadowbox
 */
class tx_pmkshadowbox_clearcachemenu implements backend_cacheActionsHook {
	/**
	 * Adds a new entry to the cache menu items array
	 *
	 * @param array array Cache menu items
	 * @param array array of access configuration identifiers (typically used by userTS with options.clearCache.identifier)
	 * @return void
	 */
	public function manipulateCacheActions(&$cacheActions, &$optionValues) {
		/** @var \TYPO3\CMS\Core\Authentication\BackendUserAuthentication $backendUser */
		$backendUser = $GLOBALS['BE_USER'];
		if ($backendUser->isAdmin()) {
			/** @var \TYPO3\CMS\Lang\LanguageService $languageObject */
			$languageObject = $GLOBALS['LANG'];
			$title = $languageObject->sL('LLL:EXT:pmkshadowbox/locallang.xml:clearCacheTitle');
			$cacheActions[] = array(
				'id' => 'clearShadowboxBuilds',
				'title' => $title,
				'href' => $GLOBALS['BACK_PATH'] . 'ajax.php?ajaxID=pmkshadowbox::clearShadowboxBuilds',
				'icon' => '<img src="' . t3lib_extMgm::extRelPath('pmkshadowbox') .
					'ext_icon.gif" width="16" height="16" title="' . htmlspecialchars($title) . '" alt="" />'
			);

			$optionValues[] = 'clearShadowboxBuilds';
		}
	}
}

if (defined(
		'TYPO3_MODE'
	) && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_clearcachemenu.php']
) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/pmkshadowbox/classes/class.tx_pmkshadowbox_clearcachemenu.php']);
}

?>